<?php

namespace DominusDev\LaravelViacep\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class QueryZipcode
{
	public function handle(string $zipcode = ''): Collection
	{
		$addresses = collect();
		Str::of($zipcode)->trim()->explode(',')->each(function ($zipcode) use (&$addresses) {
			$addresses->push(Http::viaCep()->get("$zipcode/json")->object());
		});
		return $addresses;
	}
}