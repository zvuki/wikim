<?php
/**
 * this class is responsible for creating CurrencyLoader objects
 */
class CurrencyLoaderBuilder {
    const CLASS_TYPE_WIKIMEDIA = 'wikimedia';
    public static function create($type)
    {
        if(!in_array($type, array(self::CLASS_TYPE_WIKIMEDIA))) {
            throw new CurrencyLoaderBuilderException();
        }
        
        $class = ucwords($type).'CurrencyLoader';
        
        return new $class();
    }
}

class CurrencyLoaderBuilderException extends Exception {}
