<?php
namespace App\YouTubeAPI;
use Exception;
class YouTube{
    public  const TOKEN = "AIzaSyBy3IjwhjkKurHYelHWzkFBHsaPzMsV2WI";
    public const CAHNNEL_ID = "UC704-gdkAeYFEjudxRCEAJA";
    //UCnAFByy3QDi6Hm3RK3f7PaQ
    /**
     * request to YouTube API we get the 20 last information's  video in channel "UCnAFByy3QDi6Hm3RK3f7PaQ"
     *
     * @return array or null
     *
     */
    public function YTBRequest(): ?\stdClass
    {

        try {
            $curl = curl_init("https://www.googleapis.com/youtube/v3/search?key=" . YouTube::TOKEN . "&channelId=" . YouTube::CAHNNEL_ID  ."&part=snippet,id&order=date&maxResults=10");

            curl_setopt_array($curl, array(

                    CURLOPT_HTTPHEADER => [
                        'Content-Type: text/plain',
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36',
                    ],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0.5,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                )
            );
        } catch (Exception $e) {
            echo "The connexion is impossible because of {{$e->getMessage()}}" ;
        }
        $response = curl_exec($curl);
        return json_decode($response);
    }
    public function array_ytb(int $number_return):array
    {
        $compteur = 0;
        foreach ($this -> YTBRequest() -> items as $key => $VideoID){
             $Video[$key] = [$VideoID-> id -> videoId];
        }
        while ($compteur <= $number_return ){
            $compteur++;
            $videos[] = $Video[$compteur];
            if(count($videos) === $number_return){
                return $videos;
                }
            }
        }
}