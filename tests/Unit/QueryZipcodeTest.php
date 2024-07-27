<?php

namespace DominusDev\LaravelViacep\Tests\Unit;

use DominusDev\LaravelViacep\Actions\QueryZipcode;
use DominusDev\LaravelViacep\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;

class QueryZipcodeTest extends TestCase
{
	#[DataProvider('zipcodeProvider')]
	public function testSearchZipCode($zipcode, $mockedResponse, $expectedResult)
	{
		$url = "https://viacep.com.br/ws/*";
		Http::preventStrayRequests();
		Http::fake([
			$url => Http::sequence($mockedResponse),
		]);
		$query = new QueryZipcode();
		$result = $query->handle($zipcode);
		$this->assertEquals(count($expectedResult), $result->count());
		$result->each(function ($item, $key) use ($expectedResult) {
			$this->assertEquals($item->cep, $expectedResult[$key]['cep']);
			$this->assertEquals($item->logradouro, $expectedResult[$key]['logradouro']);
			$this->assertEquals($item->ibge, $expectedResult[$key]['ibge']);
		});
	}

	public static function zipcodeProvider(): array
	{
		return [
			'busca 1 cep' => [
				'01001000',
				[
					[
						"cep" => "01001-000",
						"logradouro" => "Praça da Sé",
						"complemento" => "lado ímpar",
						"unidade" => "",
						"bairro" => "Sé",
						"localidade" => "São Paulo",
						"uf" => "SP",
						"ibge" => "3550308",
						"gia" => "1004",
						"ddd" => "11",
						"siafi" => "7107",
					],
				],
				[
					[
						'cep' => '01001-000',
						'logradouro' => 'Praça da Sé',
						'ibge' => '3550308',
						"ddd" => "11",
					],
				]
			],
			'busca 2 cep' => [
				'01001000,28981-546',
				[
					[
						"cep" => "01001-000",
						"logradouro" => "Praça da Sé",
						"complemento" => "lado ímpar",
						"unidade" => "",
						"bairro" => "Sé",
						"localidade" => "São Paulo",
						"uf" => "SP",
						"ibge" => "3550308",
						"gia" => "1004",
						"ddd" => "11",
						"siafi" => "7107",
					],
					[
						"cep" => "28981-546",
						"logradouro" => "Rua Senador Pompeu",
						"complemento" => "",
						"unidade" => "",
						"bairro" => "Parque Hotel",
						"localidade" => "Araruama",
						"uf" => "RJ",
						"ibge" => "3300209",
						"gia" => "",
						"ddd" => "22",
						"siafi" => "5803",
					]
				],
				[
					[
						'cep' => '01001-000',
						'logradouro' => 'Praça da Sé',
						'ibge' => '3550308',
						"ddd" => "11",
					],
					[
						'cep' => '28981-546',
						'logradouro' => 'Rua Senador Pompeu',
						'ibge' => '3300209',
						"ddd" => "22",
					],
				]
			],
		];
	}
}