<?php

$user = [
		'name' => 'Gigio Donnarumma',
		'age' => '20',
		'job' => 'goalkeeper'
];

$user2 = [
		'name' => 'Rino Gattuso',
		'age' => '47',
		'job' => 'unemployed'
];

try {
	$session = mysql_xdevapi\getSession("mysqlx://inpeco:inpeco@inpeco-mysql8");
} catch(Exception $e) {
	die("Connection could not be established: " . $e->getMessage());
}
try {
	$schema = $session->createSchema("inpeco");
} catch(Exception $e) {
	echo ("Cannot create schema: " . $e->getMessage()) . PHP_EOL;
	$schema = $session->getSchema("inpeco");
}
try {
	$collection = $schema->createCollection("user");
} catch(Exception $e) {
	echo ("Cannot create collection: " . $e->getMessage()) . PHP_EOL;
	$collection = $schema->getCollection("user");
}
//$collection->add($user)->execute();
//$collection->add($user2)->execute();

//var_dump($collection->find()->execute()->fetchAll());
var_dump($collection->find("job = 'goalkeeper'")->execute()->fetchAll());

// ... use $session