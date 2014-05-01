<?php

require 'includes/RedBeanPHP/rb.phar';

// R::setup(); //sqlite /tmp/red.db
R::setup('sqlite:./ljdf.sqlite'); //sqlite
// R::setup('mysql:host=localhost;dbname=ljdf', 'ljdf', 'ljdf');

// R::freeze( TRUE ); // for production, don't alter schema
R::debug( TRUE );


$b = R::dispense( 'book' );

// $b->title = 'Learn to Program';
// $b->rating = 10;
// $b['price'] = 29.99; //you can use array notation as well
// $id = R::store( $b );


// $b = R::load( 'book', $id ); //reloads our book

$b->title = 'Learn to fly';
$b->rating = 'good';
$b->published = '2015-02-15';
R::store( $b );



$logs = R::getDatabaseAdapter()->getDatabase()->getLogger();
print_r( $logs->grep( 'SELECT' ) );

//perf : cache schema meta
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables( $schema );




R::close();

?>