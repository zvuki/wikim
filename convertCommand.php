<?php

class ConvertCommand extends Command {
    
    public function execute() {
        $input = trim(str_replace(self::COMMAND_TYPE_CONVERT, '', $this->input));

        if (strpos($input, 'array')!==false) {
            // array
        } else {
            // not array
            $input = trim($input, "'");
            $parts = explode(' ',$input);
            if (count($parts) != 2) {
                 throw new ConvertCommandException("For convert command please specify currency, e.g. convert 'JPY 5000'");
            }
            $valueInUSD = $this->convert($parts[0], $parts[1]);
            
            return "'USD ".$valueInUSD."'";
        }
    }
    
    protected function convert($currency, $amount) {
        $currencies = $this->loader->getCurrencies();
        if (!isset($currencies[$currency])) {
            throw new ConvertCommandException("Currency $currency hasn't been found");
        }  
        
        return round($currencies[$currency]*$amount, 2);
    }
}

class ConvertCommandException extends Exception {}

