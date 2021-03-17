<?php

namespace App\Controller;

use App\System;
use App\Response;

class ApiController
{
    function getEpisode(Response $response, array $args)
    {
        if (is_numeric($args["episode"]) and strlen($args["anime"]) > 2)
        {
            $name = str_replace([" "], "-", strtolower($args["anime"]));
            $fc   =  ucfirst($name[0]);

            $data = [
                "status" => 200,
                "info" => [
                    "name" => ucFirst(str_replace("-", " ", $name)),
                    "slug" => $name,
                    "fc"   => $fc,
                    "epi"  => $args["episode"]
                ]
            ];

            $data["cdn"] = $this->MountResponse($name, $fc, $args["episode"]);

            return $response->setStatusCode(200)->json($data)->run();
        }

        return $response->setStatusCode(400)->json([
            "status" => 400,
            "error"  => "Bad request"
        ])->run();
    }

    private function MountResponse(string $name, string $fc, string $epi): array
    {
        $services = $this->getCdnServices();

        $links  = [];
        $chs    = [];
        $result = [];

        foreach ($services as $service)
        {
            $links = array_merge($links, $service::mountURLSeach([
                "name" => $name,
                "fc" => $fc,
                "epi" => $epi
            ]));
        }

        foreach ($links as $link)
        {
            $ch = curl_init($link);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => 1, 
                CURLOPT_HEADER => 1,       
                CURLOPT_CONNECTTIMEOUT => 1,
                CURLOPT_TIMEOUT => 9,
                CURLOPT_NOBODY => 1
            ]);

            array_push($chs, $ch);
        }

        $mch = curl_multi_init();

        foreach ($chs as $ch)
        {
            curl_multi_add_handle($mch, $ch);
        }

        $active = null;
        $mrc = 0;

        do
        {
            $mrc = curl_multi_exec($mch, $active);
            curl_multi_select($mch);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK)
        {
            if (curl_multi_select($mch) != -1)
            {
                do {
                    $mrc = curl_multi_exec($mch, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        for ($num = 0; $num < count($chs); $num++)
        {
            if (curl_getinfo($chs[$num], CURLINFO_CONTENT_TYPE) == "video/mp4")
            {
                $info = (int) ($num / 3);

                if (!array_key_exists((int) ($num / 3), $result))
                {
                    $result[$info] = array_merge(
                        $services[$info]::getDataService(),
                        [
                            "links" => [$links[$num]]
                        ]
                    );
                }
                else
                {
                    array_push($result[$info]["links"], $links[$num]);
                }
            }

            curl_multi_remove_handle($mch, $chs[$num]);
        }

        curl_multi_close($mch);

        $res = [];

        foreach ($result as $cdn)
        {
            array_push($res, $cdn);
        }
        
        return $res;
    }

    private function getCdnServices(): array
    {
        $data = [];

        $data = System::getConfig("list_cdn_services");

        return $data;
    }
}
