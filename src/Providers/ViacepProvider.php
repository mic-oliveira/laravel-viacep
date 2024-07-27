<?php

namespace DominusDev\LaravelViacep\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ViacepProvider extends ServiceProvider
{
	public function boot(): void
	{
		Http::macro('viaCep', function () {
			return Http::baseUrl('https://viacep.com.br/ws/');
		});
	}
}