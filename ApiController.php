<?php

namespace APi;

class AnimesController
{

    public function __construct()
    {
        global $links;
        $links = [ "https://cdn.superanimes.tv/010/animes/n/naruto-classico-legendado/01.mp4"];
    }
    
    public function getEpisode( $anime, $episode )
    {
        $anime = str_replace([" ", "%20"], "-", strtolower($anime));
        ($episode < 10 && substr($episode, -1)) ? $episode = "0" . $episode : false;
        $links_foreach = [];
        foreach ($GLOBALS['links'] as $link) {
            array_push($links_foreach, str_replace(substr($link, -6), $episode . substr($link, -4), $link));
        }
        foreach ( $links_foreach as $links_format ) {
            if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                return json_encode(["Anime" => $anime, "Watch in" => $links_format]);
            }
        }
    }
}