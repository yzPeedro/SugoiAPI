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

            $data["links"] = $this->MountResponse($name, $fc, $args["episode"]);

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
        $mh = curl_multi_init();
        $successfulLinks = [];

        foreach ($services as $service) {
            $links = array_merge($links, $service::mountURLSearch([
                "name" => $name,
                "fc" => $fc,
                "epi" => $epi
            ]));
        }

        foreach ($links as $link) {
            $ch = curl_init($link);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                CURLOPT_CONNECTTIMEOUT => true,
                CURLOPT_NOBODY => true,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);

            curl_multi_add_handle($mh, $ch);
        }

        do {
            $status = curl_multi_exec($mh, $active);

            if ($active) {
                curl_multi_select($mh);
            }

            while (false !== ($info = curl_multi_info_read($mh))) {
                $http_code = curl_getinfo($info['handle'], CURLINFO_HTTP_CODE);
                $content_type = curl_getinfo($info['handle'], CURLINFO_CONTENT_TYPE);
                $url = curl_getinfo($info['handle'], CURLINFO_EFFECTIVE_URL);

                if ($http_code === 200 && $content_type === 'video/mp4') {
                    $successfulLinks[] = $url;
                }
            }
        } while ($active && $status == CURLM_OK);

        return $successfulLinks;
    }

    private function getCdnServices(): array
    {
        return System::getConfig("list_cdn_services");
    }
}
