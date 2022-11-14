<?php

namespace App\lib;

class GithubApi {

    private $userName;
    private $userToken;

    public function __construct($userName, $token) {
        $this->userName = $userName;
        $this->userToken = $token;
    }


    public function getReposInfo($username) {

        $url = 'https://api.github.com/users/' . $username . '/repos';
        $response = $this->request($url);

        if(isset($response)){
            return json_decode($response, true);
        }

        return null;
    }

    private function request($url) {

        //простое ограничение запросов
        $timeFile = 'time.txt';
        while (true) {
            $time = @file_get_contents($timeFile);
            if ($time < (microtime(true) - 0.5)) {
                file_put_contents($timeFile, microtime(true));

                break;
            }

            sleep(0.05);
        }

        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'User-Agent: https://api.github.com/meta'
        ));

        $result = curl_exec($cURL);
        curl_close($cURL);

        return $result;
    }

}