<?php

namespace APi;

class AnimesController
{

    public function __construct()
    {
        global $links;
        $links = [ "https://cdn.superanimes.tv/010/animes/n/naruto-classico-legendado/01.mp4" ];
    }
    
    public function getEpisode( $anime = '', $episode = '' )
    {
        if ( !empty($anime) || !empty($episode) ) {
            $anime = str_replace([" ", "%20"], "-", strtolower($anime));
            ($episode < 10 && substr($episode, -1)) ? $episode = "0" . $episode : false;
            $links_foreach = [];
            foreach ($GLOBALS['links'] as $link) {
                array_push($links_foreach, str_replace(substr($link, -6), $episode . substr($link, -4), $link));
            }
            foreach ( $links_foreach as $links_format ) {
                if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                    http_response_code(200);
                    return json_encode(["Anime" => $anime, "Watch in" => $links_format]);
                } else if ( $links_format == end($links_foreach) ) {
                    http_response_code(404);
                    return json_encode(["error" => "Not Found", "code" => "404"]);
                }
            }
        } else {
            http_response_code(400);
            return json_encode(["error" => "Bad request", "code" => "400"]);
        }
    }

    public function verifyIfAnimeExists( $anime ) 
    {
        $anime = str_replace([" ", "%20"], "-", strtolower($anime));
    }
}