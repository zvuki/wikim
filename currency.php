<?php
/*
 * due to time constraint the solution is preliminary, future improvements are needed
 * possible future improvements:
 * - add namespaces
 * - add PSR-compliant autoloader
 * - add more Exception-specific messages for user output
 * 
 * - it doesn't save/load from database, apropriate driver/classes could be easily added as extentions
 * - stop loading currencies from remote datasource each time user inputs a command, cache them instead
 */

include_once 'commandHandler.php';
include_once 'command.php';
include_once 'updateCommand.php';
include_once 'convertCommand.php';
include_once 'loader/currencyLoaderBuilder.php';
include_once 'loader/currencyLoaderInterface.php';
include_once 'loader/wikimediaCurrencyLoader.php';
include_once 'persister/currencyPersisterBuilder.php';
include_once 'persister/currencyPersisterInterface.php';
include_once 'persister/dummyCurrencyPersister.php';

$in = fopen('php://stdin', 'r');
$out = fopen('php://stdout', 'w');

$commandHandler = CommandHandler::getInstance();
fputs($out, $commandHandler->getWelcomeMessage()."\n");

while(true) {
    $input = trim(fgets($in));
    
    if (feof($in)) {
        break;
    }
    
    if (empty($input)) {
        continue;
    }
    
    try {
        $result = $commandHandler->handle($input);
        if (strlen($result) > 0)
        {
            fputs($out, "$result\n");
        }
        
    } catch (Exception $e) {
        fputs($out, '* '.$e->getMessage()."\n");
    }
}

fclose($in);
fclose($out);