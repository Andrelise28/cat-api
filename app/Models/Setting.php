<?php


namespace App\Models;


class Setting
{

    private $settings;

    public function __construct()
    {
        $this->settings = require __DIR__ . '/../../config/config.php';
    }

    public function getSettings()
    {
        return $this->settings;
    }
}