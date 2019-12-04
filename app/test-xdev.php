<?php

$users = [];
$users[] = [
	'name' => 'Belldandy',
	'age' => 20,
	'job' => 'goddess',
	'address' => [
		'city' => 'Tokyo',
		'state' => 'Japan'
	]
];
$users[] = [
	'name' => 'Denise Milani',
	'age' => 40,
	'job' => 'model',
	'address' => [
		'city' => 'Prague',
		'state' => 'Czech Republic'
	]
];
$users[] = [
	'name' => 'Carolina Crescentini',
	'age' => 30,
	'job' => 'actress',
	'address' => [
		'city' => 'Rome',
		'state' => 'Italy'
	]
];
$users[] = [
	'name' => 'Serena Autieri',
	'age' => 40,
	'job' => 'actress',
	'address' => [
		'city' => 'Neaples',
		'state' => 'Italy'
	]
];

try {
	$session = mysql_xdevapi\getSession( "mysqlx://inpeco:inpeco@inpeco-mysql8" );
} catch ( Exception $e ) {
	die( "Connection could not be established: " . $e->getMessage() );
}
try {
	$schema = $session->getSchema( "inpeco" );
} catch ( Exception $e ) {
	echo ("Cannot find schema: " . $e->getMessage()) . PHP_EOL;
	$schema = $session->createSchema( "inpeco" );
}
try {
	$schema->dropCollection( "user" );
} catch ( Exception $e ) {
	echo ("Cannot drop collection: " . $e->getMessage()) . PHP_EOL;
}
try {
	$collection = $schema->createCollection( "user" );
	$collection->createIndex( 'index', '{"fields": [{"field": "$.name", "type": "TEXT(20)", "required": true}, {"field": "$.age","type": "INTEGER"}],"unique": true}' );
} catch ( Exception $e ) {
	echo ("Cannot create collection: " . $e->getMessage()) . PHP_EOL;
	$collection = $schema->getCollection( "user" );
}

foreach ( $users as $user ) {
	$collection->add( $user )->execute();
}

var_dump( $collection->find()->execute()->fetchAll() );
var_dump( $collection->find( "address.state = 'Italy'" )->execute()->fetchAll() );

$collection->modify( "address.state = :state && age > 30" )->bind( ['state' => 'Italy'] )->replace( "age", new mysql_xdevapi\Expression( "age - 10" ) )->execute();
var_dump( $collection->find( "address.state = 'Italy'" )->execute()->fetchAll() );