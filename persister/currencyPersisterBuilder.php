<?php
/**
 * this class is responsible for creating CurrencyPersister objects
 */
class CurrencyPersisterBuilder {
    const CLASS_TYPE_DUMMY = 'dummy';
    public static function create($type)
    {
        if(!in_array($type, array(self::CLASS_TYPE_DUMMY))) {
            throw new CurrencyPersisterBuilderException();
        }
        
        $class = ucwords($type).'CurrencyPersister';
        
        return new $class();
    }
}

class CurrencyPersisterBuilderException extends Exception {}
