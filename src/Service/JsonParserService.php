<?php

namespace App\Service;


use Symfony\Component\Yaml\Exception\ParseException;

class JsonParserService extends Parser
{

    /**
     * Получение значение валюты
     * @param string $url
     * @return float
     */
    public function getValue(string $url): float
    {
        $json = $this->getDataFromUrl($url);

        if ($json === false) {
            return false;
        }

        try {
            $currencyObject = json_decode($json);
            $value = $currencyObject->Valute->EUR->Value;
        } catch (\Exception $e) {
            throw new ParseException('Cannot get value from data (json)');
        }

        return $value;
    }
}