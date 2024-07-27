<?php

namespace DominusDev\LaravelViacep\Facades;

use Illuminate\Support\Facades\Facade;

class QueryZipcodeFacade extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return 'queryViacep';
	}

}