<?php

class CommandHandler {

    protected static $instance = null;
    
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct() {
    }
    
    protected function __clone() {
    }

    public function validateInput($input) 
    {
        $commandParts = explode(' ', $input);
          
        Command::validateCommand($commandParts[0]);
        
        // this should go to ConvertCommand class
        if ($commandParts[0] == Command::COMMAND_TYPE_CONVERT && count($commandParts) == 1) {
            throw new CommandHandlerException("For convert command please specify currency, e.g. convert 'JPY 5000'");
        }
 
        return $commandParts;
    }


    public function handle($input)
    {
        $parts = $this->validateInput($input);
        
        // it's better to take a specific class type from a configuration, here it's defined statically
        $currencyLoader = CurrencyLoaderBuilder::create(CurrencyLoaderBuilder::CLASS_TYPE_WIKIMEDIA);
        $currencyPersister = CurrencyPersisterBuilder::create(CurrencyPersisterBuilder::CLASS_TYPE_DUMMY);
        
        $command = Command::create($parts[0], $input);
        // dependency injection via methods and inversion of control: internal objects are created first
        $command->setPersister($currencyPersister);
        $command->setLoader($currencyLoader);
        return $command->execute();
    }   

    public function getWelcomeMessage() {
        return 'Type a command: '.  Command::COMMAND_TYPE_UPDATE.' or '.Command::COMMAND_TYPE_CONVERT;
    }
    
}

class CommandHandlerException extends Exception {}
