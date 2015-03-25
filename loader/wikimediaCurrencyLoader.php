<?php

class WikimediaCurrencyLoader implements CurrencyLoaderInterface {
    const ENDPOINT = 'https://wikitech.wikimedia.org/wiki/Fundraising/tech/Currency_conversion_sample?ctype=text/xml&action=raw';
    
    public function load() {
        return file_get_contents(self::ENDPOINT);
    }
    
    public function convertFromXML($xml)
    {
        $XMLOblect = new SimpleXMLElement($xml);
        $result = array();
        foreach ($XMLOblect->conversion as $element) {
            $result[(string)$element->currency] = (string)$element->rate;
        }
        return $result;
    }


    /**
    * 
    * @return array()  [currency => value]
    */
   public function getCurrencies()
   {
       $xml = $this->load();
       if ($xml === false) {
           throw new WikimediaCurrencyLoaderException("Can't load currencies from Wikimedia");
       }
       $converted = $this->convertFromXML($xml);
       if (empty($converted)) {
           throw new WikimediaCurrencyLoaderException("No data available");
       }
       
       return $converted;
   }
}

class WikimediaCurrencyLoaderException extends Exception {}
