<?php namespace Dotink\Parody {

	include 'Jest.php';
	include 'Mime.php';

	Mime::define('App\Test')->implementing('IFake')
		-> extending('App\TestBase')->implementing('IFakeBase')->using('Bob')
		-> extending('App\Base')->using('WTF');

	$test = Mime::create('App\Test')
		-> onNew('factory', function($mime) {
			$mime -> onCall('speak') -> give(function(){
				return 'Amazing!' . PHP_EOL;
			});
		})
		-> onCall('check') -> expect(2)     -> give(TRUE)
		-> onCall('add')   -> expect(2, 3)  -> give(5)
		-> onGet('name')   ->                  give('Matthew J. Sahagian')
		-> resolve();

	var_dump(class_implements($test));

	var_dump($test->check(2));

	var_dump(\App\Test::add(2, 3));

	var_dump($test->name);

	$test = new \App\Test('factory');

	echo $test->speak();
}
