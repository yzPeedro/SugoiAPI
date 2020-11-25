<?php

namespace APi;

class AnimesController
{   
    public function getEpisode( $anime = '', $episode = '')
    {
        try {
            if ( $anime == '' || $episode == '' ) {
                http_response_code(400);
                return json_encode(["error" => "Bad request", "code" => "400"]);
            } else {
                $anime = str_replace([" ", "%20"], "-", strtolower($anime));
                $anime_FC = ucfirst($anime[0]);
                $anime_fc = $anime[0];                
                ($episode < 10 && substr($episode, -1)) ? $episode = "0" . $episode : false;
                $links = [ 
                "https://ns569461.ip-51-79-82.net/$anime_FC/$anime/$episode.mp4",
                "https://ns545982.ip-66-70-177.net/$anime_FC/$anime/$episode.mp4",
                "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime/$episode.mp4",//01
                "https://cdn02.fluehost.com/a/$anime/hd/$episode.mp4"
                ];
                foreach ( $links as $links_format ) {
                    if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                        http_response_code(200);
                        return json_encode(["anime" => $anime, "watch_in" => $links_format, "code" => "200"]);
                    } else if ( $links_format == end($links) ) {
                        http_response_code(404);
                        return json_encode(["error" => "Not Found", "code" => "404"]);
                    }
                }
            }
        } catch (Exception $ex) {
            http_response_code(400);
            return json_encode(["error" => "Bad request", "code" => "400"]);
        }
    }

    public function verifyIfAnimeExists( $anime = '' )
    {
        try {
            if ( !empty($anime) ) {
                $anime = str_replace([" ", "%20"], "-", strtolower($anime));
                $anime_FC = ucfirst($anime[0]);
                $anime_fc = $anime[0];
                $links = [ 
                "https://ns569461.ip-51-79-82.net/$anime_FC/$anime/01.mp4",
                "https://ns545982.ip-66-70-177.net/$anime_FC/$anime/01.mp4",
                "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime/01.mp4",
                "https://cdn02.fluehost.com/a/$anime/hd/01.mp4"
                ];
                foreach ( $links as $links_format ) {
                    if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                        http_response_code(200);
                        return json_encode(["anime" => $anime, "status in api" => "exists"]);
                    } else if ( $links_format == end($links) ) {
                        http_response_code(404);
                        return json_encode(["error" => "Not Found", "code" => "404"]);
                    }
                }
            } else {
                http_response_code(400);
                return json_encode(["error" => "Bad request", "code" => "400"]);
            }
        } catch (Exception $ex) {
            http_response_code(500);
            return json_encode(["error" => "Internal Server Error", "code" => "500"]);
        }
    }
}