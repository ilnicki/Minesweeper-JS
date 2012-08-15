<?php
function class_loader($class_name) 
{
    $class_file = $class_name.'.class.php';
    
    if (file_exists($class_file))
    {    
        require $class_file;
    }
    else
    {    
        throw new Exception('Class file "' . $class_file . '" not found.'); 
    }
}
spl_autoload_register('class_loader');

$db = new mysqli('localhost','root', '', 'miner');

$minerGame = new MinesweeperProcessor($db);
$minerGame->putKey($_GET['keydown']);
$minerGame->calcResult();

$db->close();

$data = $minerGame->getResult();

$json = new JsonSender();
$json->putData($data);

$json->send();