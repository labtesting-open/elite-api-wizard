<?php

include __DIR__."/../vendor/autoload.php";

$operation = new \Elitelib\Operations();

$suma = $operation->add(10,25);

echo "el resultado es $suma";

