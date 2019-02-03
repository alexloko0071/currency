<?php

namespace App\Service;


use Symfony\Component\Yaml\Exception\ParseException;

class XmlParserService extends Parser
{

    /**
     * Получение значение валюты
     * @param string $xml
     * @return float
     */
    public function getValue(string $xml): float
    {
        $xml = $this->getDataFromUrl($xml);

        if ($xml === false) {
            return false;
        }

        $value = 0;
        try {
            $data = new \SimpleXMLElement($xml);
            $currencies = $data->children()[0]->children()[0]->children();
            foreach ($currencies as $currency) {
                if ($currency->attributes()['currency']->__toString() === "RUB") {
                    $value = $currency->attributes()['rate']->__toString();
                }
            }
        } catch (\Exception $e) {
            throw new ParseException('Cannot get value from data (xml)');
        }

        return $value;
    }


}