<?php

namespace DominusDev\LaravelViacep\Tests;

use DominusDev\LaravelViacep\Providers\ViacepProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
	protected function getPackageProviders($app): array
	{
		return [
			ViacepProvider::class
		];
	}

}