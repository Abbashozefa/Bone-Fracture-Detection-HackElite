<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
->withServiceAccount('private_key.json')
->withDatabaseUri('https://haddikabaddi-76c51-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
?>