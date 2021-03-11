<?php

class ApiController
{
    public function searchAnime( $anime = '')
    {

        try {

            if ( empty($anime) ) {
                dd(json_encode([
                    "error" => "Bad Request",
                    "status" => 400
                ]));
            }

            $anime = str_replace([" ", "_", "+"], "-", strtolower($anime));
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
            
                "https://ns569461.ip-51-79-82.net/$anime_FC/$anime-dublado/01.mp4",
                "https://ns545982.ip-66-70-177.net/$anime_FC/$anime-dublado/01.mp4",
                "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime-dublado/01.mp4",
                "https://cdn02.fluehost.com/a/$anime-dublado/hd/01.mp4",
                "https://servertv001.com/animes/$anime_fc/$anime-dublado/01.mp4"
            ];

            $links_succ = [];
            
            foreach( $links as $links_format ) {
                if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                    array_push($links_succ, $links_format);
                    continue;
                } elseif( $links_format == end($links) ) {
                    if( !empty($links_succ) ) {
                        dd(json_encode(
                            [
                                "anime" => [
                                    "nome" => ucFirst(str_replace("-", " ", $anime)),
                                    "audio" => (strpos($links_format, "dublado")) ? "dublado" : "legendado",
                                    "slug" => $anime
                                ],
                                "links" => $links_succ,
                                "status" => 200
                            ]
                        ));
                    } else {
                        dd(json_encode(["error" => "Not Found", "status" => 404]), false);
                        http_response_code(404);
                        die;
                    }
                }
            }

        } catch (Exception $ex) {
            http_response_code(500);
            dd(json_encode(["error" => "Internal Server Error", "status" => 500]));
        }
    }

    public function verifyIfAnimeExists( $anime = '' )
    {
        try {
            if ( !empty($anime) ) {
                $anime = str_replace([" "], "-", strtolower($anime));
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
                
                    "https://ns569461.ip-51-79-82.net/$anime_FC/$anime-dublado/01.mp4",
                    "https://ns545982.ip-66-70-177.net/$anime_FC/$anime-dublado/01.mp4",
                    "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime-dublado/01.mp4",
                    "https://cdn02.fluehost.com/a/$anime-dublado/hd/01.mp4",
                    "https://servertv001.com/animes/$anime_fc/$anime-dublado/01.mp4"
                ];

                $links_succ = [];

                foreach ( $links as $links_format ) {
                    if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                        array_push($links_succ, $links_format);
                    } else if ( $links_format == end($links) ) {
                        if ( !empty($links_succ) ) {
                            http_response_code(200);
                            dd(json_encode(["anime" => ["nome" => ucFirst(str_replace("-", " ", $anime)), "slug" => $anime], "exists" => true, "links" => $links_succ, "status" => 200]));
                        }

                        http_response_code(404);
                        dd(json_encode(["anime" => ["nome" => ucFirst(str_replace("-", " ", $anime)), "slug" => $anime], "exists" => false, "links" => NULL, "status" => 404]));
                    }
                }
            } else {
                http_response_code(400);
                dd(json_encode(["error" => "Bad quest", "status" => 400]));
            }
        } catch (Exception $ex) {
            http_response_code(500);
            dd(json_encode(["error" => "Internal Server Error", "status" => 500]));
        }
    }

    public function getEpisode( $params )
    {
        if ( empty($params[0]) || empty($params[1]) ) {
            dd(json_encode([
                "error" => "Bad Request",
                "status" => 400
            ]));
        }

        $anime = $params[0];
        $episode = $params[1];
        
        try {
            $anime = str_replace([" ", "_", "+"], "-", strtolower($anime));
            $anime = str_replace(["legendado", "dublado","-legendado", "-dublado"], "", $anime);
            $anime_FC = ucfirst($anime[0]);
            $anime_fc = $anime[0];
            ($episode < 10 && substr($episode, 0, 1) != "0") ? $episode = "0" . $episode : false;
            
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
            
                "https://ns569461.ip-51-79-82.net/$anime_FC/$anime-dublado/01.mp4",
                "https://ns545982.ip-66-70-177.net/$anime_FC/$anime-dublado/01.mp4",
                "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime-dublado/01.mp4",
                "https://cdn02.fluehost.com/a/$anime-dublado/hd/01.mp4",
                "https://servertv001.com/animes/$anime_fc/$anime-dublado/01.mp4"
            ];

            $links_succ = [];

            foreach( $links as $links_format ) {
                if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                    array_push($links_succ, $links_format);
                } elseif( $links_format == end($links) ) {
                    if ( $links_succ != [] ) {
                        dd(json_encode([
                            "anime" => [
                                "nome" => ucFirst(str_replace("-", " ", $anime)),
                                "slug" => $anime
                            ],
                            "links" => $links_succ,
                            "status" => 200
                        ]));
                    } else {
                        http_response_code(404);
			            dd( json_encode(["error" => "Not Found", "status" => 404]));
                    }
                } else {
                    continue;
                }
            }

        } catch (\Throwable $th) {
            http_response_code(500);
			dd( json_encode(["error" => "Internal Server Error", "status" => 500]));
        }
    }

    public function countEp( $params )
    {
        if ( empty($params[0]) || empty($params[1]) ) {
            dd(json_encode([
                "error" => "Bad Request",
                "status" => 400
            ]));
        }

        $anime = $params[0];
        $episodes = $params[1];

        try {
            $anime = str_replace([" ", "%20"], "-", strtolower($anime));
            $anime_FC = ucfirst($anime[0]);
            $anime_fc = $anime[0];
            ($episodes < 10 && substr($episodes, 0, 1) != "0") ? $episodes = "0" . $episodes : false;
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
            
                "https://ns569461.ip-51-79-82.net/$anime_FC/$anime-dublado/01.mp4",
                "https://ns545982.ip-66-70-177.net/$anime_FC/$anime-dublado/01.mp4",
                "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime-dublado/01.mp4",
                "https://cdn02.fluehost.com/a/$anime-dublado/hd/01.mp4",
                "https://servertv001.com/animes/$anime_fc/$anime-dublado/01.mp4"
            ];
            foreach ( $links as $links_format ) {
                if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                    for( $i = "1"; ; $i++ ) {
                        if( $i < 10 ) {
                            $i = "0" . $i;
                        }
                        if ( $i >= 100 ) {
                            $links_format = str_replace(substr($links_format, -7), $i . substr($links_format, -4), $links_format);
                            if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                                if ( $i == $episodes ) {
                                    http_response_code(200);
                                    dd( json_encode(
                                        ["anime" => 
                                            ["nome" => ucFirst(str_replace("-", " ", $anime)), 
                                                "audio" => (strpos($links_format, "dublado")) ? "dublado" : "legendado", 
                                                "slug" => $anime 
                                            ],
                                        "episodes_found" => $i, 
                                        "found_all" => true, 
                                        "link" => $links_format = str_replace(substr($links_format, -7), $i . substr($links_format, -4), $links_format), 
                                        "status" => 200]
                                    ));
                                } else {
                                    continue;
                                }
                            } else {
                                http_response_code(200);
                                dd( json_encode(["anime" => 
                                    ["nome" => ucFirst(str_replace("-", " ", $anime)), 
                                        "audio" => (strpos($links_format, "dublado")) ? "dublado" : "legendado", 
                                        "slug" => $anime 
                                    ],
                                "episodes_found" => $i, 
                                "found_all" => false, 
                                "link" => $links_format = str_replace(substr($links_format, -7), $i . substr($links_format, -4), $links_format), 
                                "status" => 200]
                                ));
                            }
                        } else {
                            $links_format = str_replace(substr($links_format, -6), $i . substr($links_format, -4), $links_format);
                            if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                                if ( $i == $episodes ) {
                                    http_response_code(200);
                                    dd( json_encode(["anime" => 
                                        ["nome" => ucFirst(str_replace("-", " ", $anime)), 
                                            "audio" => (strpos($links_format, "dublado")) ? "dublado" : "legendado", 
                                            "slug" => $anime 
                                        ], 
                                        "episodes_found" => $i, 
                                        "found_all" => true, 
                                        "link" => $links_format = str_replace(substr($links_format, -6), $i . substr($links_format, -4), $links_format), 
                                        "status" => 200]
                                    ));
                                } else {
                                    continue;
                                }
                            } else {
                                http_response_code(200);
                                dd( json_encode(["anime" => 
                                    ["nome" => ucFirst(str_replace("-", " ", $anime)), 
                                        "audio" => (strpos($links_format, "dublado")) ? "dublado" : "legendado", 
                                        "slug" => $anime 
                                    ],
                                "episodes_found" => $i, 
                                "found_all" => false, 
                                "link" => $links_format = str_replace(substr($links_format, -6), $i . substr($links_format, -4), $links_format),
                                "status" => 200]
                            ));
                            }
                        }
                    }
                } else if ( $links_format == end($links) ) {
                    http_response_code(404);
                    dd( json_encode(["error" => "Not Found", "status" => 404]));
                }
            }
    	} catch(Exception $ex) {
			http_response_code(500);
			dd( json_encode(["error" => "Internal Server Error", "status" => 500]));
    	}
    }
}