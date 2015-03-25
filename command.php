<?php

abstract class Command 
{
    const COMMAND_TYPE_UPDATE = 'update';
    const COMMAND_TYPE_CONVERT = 'convert';
    
    protected $loader = null;
    protected $persister = null;
    
    protected $input = null;


    public static function validateCommand($type) {
        if(!in_array($type, array(self::COMMAND_TYPE_UPDATE, self::COMMAND_TYPE_CONVERT))) {
             throw new CommandHandlerException("Can't recognize the command");
        }
    }
    
    public static function create($type, $input) {
        self::validateCommand($type);
        $class = ucwords($type).'Command';
        $object = new $class;
        $object->setInput($input);
        return $object;
    }
    
    public function setLoader(CurrencyLoaderInterface $loader) {
        $this->loader = $loader;
    } 
    
    public function setPersister(CurrencyRersisterInterface $persister) {
        $this->persister = $persister;
    }   
    
    public function setinput($input) {
        $this->input = $input;
    }


    abstract public function execute();
}
