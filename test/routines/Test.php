<?php namespace Dotink\Lab;

use Dotink\Parody\Mime;

return [
		'setup' => function($data, $shared) {
			needs('src/Quip.php');
			needs('src/Mime.php');
		},

		'tests' => [
				'Test' => function($data, $shared) {
					$static   = Mime::define('Bar');
					$instance = Mime::create('Bar')->onCall('foo')->give('bar');

					$static->onCall('foo')->give('bar');

					assert(\Bar::foo())->equals('bar');
					assert($instance()->foo())->equals('bar');

					$instance = $static->create()->onCall('foo')->give('bar');

					assert($instance()->foo())->equals('bar');

					$static->onNew('test', function($mime) {
						$mime->onCall('foo')->give('foo');
					});

					$instance = new \Bar('test');

					assert($instance->foo())->equals('foo');
				}
		]
];
