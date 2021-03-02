<?php

class ApiController
{
    public function searchAnime( $anime )
    {
        try {

            $anime = str_replace([" "], "-", strtolower($anime));
            $anime = str_replace(["legendado", "dublado","-legendado", "-dublado"], "", $anime);
            $anime_FC = ucfirst($anime[0]);
            $anime_fc = $anime[0];

            $links = [ 
            "https://ns569461.ip-51-79-82.net/$anime_FC/$anime/01.mp4",
            "https://ns545982.ip-66-70-177.net/$anime_FC/$anime/01.mp4",
            "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime/01.mp4",
            "https://cdn02.fluehost.com/a/$anime/hd/01.mp4",
            "https://servertv001.com/animes/$anime_fc/$anime/01.mp4",

            "https://ns569461.ip-51-79-82.net/$anime_FC/$anime-legendado/01.mp4",
            "https://ns545982.ip-66-70-177.net/$anime_FC/$anime-legendado/01.mp4",
            "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime-legendado/01.mp4",
            "https://cdn02.fluehost.com/a/$anime-legendado/hd/01.mp4",
            "https://servertv001.com/animes/$anime_fc/$anime-legendado/01.mp4",

            "https://ns569461.ip-51-79-82.net/$anime_FC/$anime-dublado/01.MP4",
            "https://ns545982.ip-66-70-177.net/$anime_FC/$anime-dublado/01.mp4",
            "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime-dublado/01.mp4",
            "https://cdn02.fluehost.com/a/$anime-dublado/hd/01.mp4",
            "https://servertv001.com/animes/$anime_fc/$anime-legendado/01.mp4"
            ];

            $links_succ = [];
            
            foreach( $links as $links_format ) {
                if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                    array_push($links_succ, $links_format);
                    continue;
                } elseif( $links_format == end($links) ) {
                    dd(json_encode(
                        [
                            "anime" => [
                                "nome" => ucFirst(str_replace("-", " ", $anime)),
                                "audio" => (strpos($links_format, "dublado")) ? "dublado" : "legendado",
                                "slug" => $anime
                            ],
                            "links" => $links_succ,
                            "status" => "HTTP/1.1 200"
                        ]
                    ));
                }
            }

        } catch (Exception $ex) {
            http_response_code(500);
            dd(json_encode(["error" => "Internal Server Error", "status" => "HTTP/1.1 500"]));
        }
    }
}