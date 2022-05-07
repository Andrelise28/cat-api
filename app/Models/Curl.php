<?php


namespace App\Models;


class Curl
{
    public static function setOptStart($curl)
    {
        $theCatApiKey = getenv("THE_CAT_API_KEY");
        $curlOptHeader = array(
            "x-api-key: {$theCatApiKey}",
            "Accept: application/json"
        );
        $curlOpt = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $curlOptHeader
        );
        curl_setopt_array($curl, $curlOpt);
    }

    public static function setOptUrlCurl($curl, $url)
    {
        curl_setopt($curl, CURLOPT_URL, $url);
    }

    public static function closeCurl($curl)
    {
        curl_close($curl);
    }

}