<?php

class UpdateCommand extends Command {
    public function execute() {
        
            $currencies = $this->loader->getCurrencies();
            $this->persister->persist($currencies);
            
            return 'Operation complete, currencies loaded: '.implode(' ',  array_keys($currencies)) . ' with values: '.  implode(' ',  $currencies);
    }
}
