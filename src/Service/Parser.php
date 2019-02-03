<?php

namespace App\Service;


abstract class Parser
{
    abstract public function getValue(string $url): float;

    /**
     * Получение содержимого страницы по url
     * @param string $url
     * @return mixed
     */
    public function getDataFromUrl(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}