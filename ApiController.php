<?php

namespace APi;

class AnimesController
{   
    public function getEpisode( $anime = '', $episode = '')
    {
        try {
            if ( $anime == '' || $episode == '' ) {
                http_response_code(400);
                return json_encode(["error" => "Bad request", "status" => "HTTP/1.1 400"]);
            } else {
                $anime = str_replace([" ", "%20"], "-", strtolower($anime));
                $anime_FC = ucfirst($anime[0]);
                $anime_fc = $anime[0];                
                ($episode < 10 && substr($episode, 0, 1) != "0") ? $episode = "0" . $episode : false;
                $links = [ 
                "https://ns569461.ip-51-79-82.net/$anime_FC/$anime/$episode.mp4",
                "https://ns545982.ip-66-70-177.net/$anime_FC/$anime/$episode.mp4",
                "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime/$episode.mp4",//01
                "https://cdn02.fluehost.com/a/$anime/hd/$episode.mp4"
                ];
                foreach ( $links as $links_format ) {
                    if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                        http_response_code(200);
                        return json_encode(["anime" => $anime, "watch_in" => $links_format, "status" => "HTTP/1.1 200"]);
                    } else if ( $links_format == end($links) ) {
                        http_response_code(404);
                        return json_encode(["error" => "Not Found", "status" => "HTTP/1.1 404"]);
                    }
                }
            }
        } catch (Exception $ex) {
            http_response_code(400);
            return json_encode(["error" => "Bad request", "status" => "HTTP/1.1 400"]);
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
                "https://cdn02.fluehost.com/a/$anime/hd/01.mp4"
                ];
                foreach ( $links as $links_format ) {
                    if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                        http_response_code(200);
                        return json_encode(["anime" => $anime, "status_in_api" => true, "found_at" => $links_format, "status" => "HTTP/1.1 200"]);
                    } else if ( $links_format == end($links) ) {
                        http_response_code(404);
                        return json_encode(["anime" => $anime, "status_in_api" => false, "status" => "HTTP/1.1 404"]);
                    }
                }
            } else {
                http_response_code(400);
                return json_encode(["error" => "Bad request", "status" => "HTTP/1.1 400"]);
            }
        } catch (Exception $ex) {
            http_response_code(500);
            return json_encode(["error" => "Internal Server Error", "status" => "HTTP/1.1 500"]);
        }
    }



    public function verifyIfExistsAllEpisodes( $anime = '', $episodes = '' )
    {	
    	try {
    		if ( $anime == '' || $episodes == '' ) {
    			http_response_code(400);
    			return json_encode(["error" => "Bad Request", "status" => "HTTP/1.1 400"]);
    		} else {
    			$anime = str_replace([" ", "%20"], "-", strtolower($anime));
                $anime_FC = ucfirst($anime[0]);
                $anime_fc = $anime[0];
                ($episodes < 10 && substr($episodes, 0, 1) != "0") ? $episodes = "0" . $episodes : false;
                $links = [ 
                "https://ns569461.ip-51-79-82.net/$anime_FC/$anime/01.mp4",
                "https://ns545982.ip-66-70-177.net/$anime_FC/$anime/01.mp4",
                "https://cdn.superanimes.tv/010/animes/$anime_fc/$anime/01.mp4",
                "https://cdn02.fluehost.com/a/$anime/hd/01.mp4"
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
		                    			return json_encode(["anime" => $anime, "episodes_found" => $i, "found_all" => true, "link" => $links_format = str_replace(substr($links_format, -7), $i . substr($links_format, -4), $links_format), "status" => "HTTP/1.1 200"]);
                        			} else {
                        				continue;
                        			}
                        		} else {
                        			http_response_code(200);
	                    			return json_encode(["anime" => $anime, "episodes_found" => $i, "found_all" => false, "link" => $links_format = str_replace(substr($links_format, -7), $i . substr($links_format, -4), $links_format), "status" => "HTTP/1.1 200"]);
                        		}
                        	} else {
                        		$links_format = str_replace(substr($links_format, -6), $i . substr($links_format, -4), $links_format);
                        		if ( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
                        			if ( $i == $episodes ) {
										http_response_code(200);
		                    			return json_encode(["anime" => $anime, "episodes_found" => $i, "found_all" => true, "link" => $links_format = str_replace(substr($links_format, -6), $i . substr($links_format, -4), $links_format), "status" => "HTTP/1.1 200"]);
                        			} else {
                        				continue;
                        			}
                        		} else {
                        			http_response_code(200);
	                    			return json_encode(["anime" => $anime, "episodes_found" => $i, "found_all" => false, "link" => $links_format = str_replace(substr($links_format, -6), $i . substr($links_format, -4), $links_format), "status" => "HTTP/1.1 200"]);
                        		}
                        	}
                        }
                    } else if ( $links_format == end($links) ) {
                        http_response_code(404);
                        return json_encode(["error" => "Not Found", "status" => "HTTP/1.1 404"]);
                    }
                }
    		}
    	} catch(Exception $ex) {
			http_response_code(500);
			return json_encode(["error" => "Internal Server Error", "status" => "HTTP/1.1 500"]);
    	}
    }

    public function countEpisodes( $anime = '')
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
						$count = '0';
						while( true ) {
							$count = $count + 1;
							if ( $count < 10 ) {
								$count = "0" . $count;
							}
							$links_format = str_replace(substr($links_format, -6), $count . substr($links_format, -4), $links_format);
							if( get_headers($links_format)[2] == "Content-Type: video/mp4" || get_headers($links_format)[3] == "Content-Type: video/mp4" ) {
								continue;
							} else {
								http_response_code(200);
                        		return json_encode(["anime" => $anime, "episodes_found" => $count - 1, "link_last_episode_found" => $links_format = str_replace(substr($links_format, -6), $count - 1 . substr($links_format, -4), $links_format), "status" => "HTTP/1.1 200"]);
							}
						}                  
                    } else if ( $links_format == end($links) ) {
                        http_response_code(404);
                        return json_encode(["error" => "Not Found", "status" => "HTTP/1.1 404"]);
                    }
                }
    		} else {
    			http_response_code(400);
    			return json_encode(["error" => "Bad Request", "status" => "HTTP/1.1 400"]);	
    		}
    	} catch (Exception $ex) {
    		http_response_code(500);
    		return json_encode(["error" => "Internal Server Error", "status" => "HTTP/1.1 500"]);
    	}
    }
}