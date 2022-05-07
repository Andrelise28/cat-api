<?php

namespace App\Traits;

trait GenerateUrl
{

    private static function generate()
    {
        $data = array();

        for ($i = 0; $i < 4; $i++) {
            $data[$i] = '0';
        }

        $http = 'http://';
        $version = '/v1';
        $tcp = '80';

        return $http . $data[0] . '.' . $data[1] . '.' . $data[2] . '.' . $data[3] . ':' . $tcp . $tcp . $version;
    }

    public function generateUrl()
    {
        return self::generate();
    }

    public static function generateUrlForRoutes()
    {
        return substr(self::generate(), 7, 7);
    }


}