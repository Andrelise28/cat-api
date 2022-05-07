<?php

namespace App\Services\TheCatAPIServices;

use App\Models\Curl;
use App\Models\QueryCache;


class CatBreedsService
{

    const URL_BREEDS = "https://api.thecatapi.com/v1/breeds";
    const URL_SEARCH = "https://api.thecatapi.com/v1/breeds/search?q=";

    private $curl;
    private $query;

    public function __construct()
    {
        $this->curl = curl_init();
        Curl::setOptStart($this->curl);
        $this->query = new QueryCache();
    }

    public function getBreedsService()
    {
        $queryIndex = "index";
        $searchBreedResult = $this->query->queryExists($queryIndex);

        if(empty($searchBreedResult))
        {
            $searchBreedResult = $this->getCurlExec($queryIndex, self::URL_BREEDS);
        }

        return $searchBreedResult;
    }

    public function searchBreedsService($query)
    {
        $searchBreedResult = $this->query->queryExists($query);
        $searchUrl = self::URL_SEARCH . $query;

        if(empty($searchBreedResult)){
            $searchBreedResult = $this->getCurlExec($query, $searchUrl);
        }

        return $searchBreedResult;
    }

    private function getCurlExec($queryName, $url)
    {
        Curl::setOptUrlCurl($this->curl, $url);
        $searchBreedResult = json_decode(curl_exec($this->curl));
        $this->query->saveCache($queryName, $searchBreedResult);
        Curl::closeCurl($this->curl);
        return $searchBreedResult;
    }

}