<?php

namespace Tests\Unit;

use App\Http\Requests\ConvertCurrencyRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class ConvertCurrencyTest extends TestCase
{

    use CreatesApplication;

    /** @test */
    public function it_should_contain_all_the_expected_validation_rules()
    {
        $request = new ConvertCurrencyRequest();

        $this->assertEquals([
            'amount' => ['required', 'numeric'],
            'source_currency' => ['required', 'string', 'size:'. ConvertCurrencyRequest::CURRENCY_STR_SIZE],
            'target_currency' => ['required', 'string', 'size:'. ConvertCurrencyRequest::CURRENCY_STR_SIZE],
        ], $request->rules());
    }

    /** @test */
    public function it_should_fail_validation_if_the_amount_is_not_provided()
    {
        $request = new ConvertCurrencyRequest();

        $validator = Validator::make([
            'source_currency' => 'USD',
            'target_currency' => 'ARS',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('amount', $validator->errors()->keys());
    }

    /** @test */
    public function it_should_fail_validation_if_the_target_currency_not_have_the_right_size()
    {
        $request = new ConvertCurrencyRequest();
        $target_currency = 'AR';

        $validator = Validator::make([
            'amount' => 10,
            'source_currency' => 'USD',
            'target_currency' => $target_currency,
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertFalse(strlen($target_currency) === 3);
    }

    public function test_endpoint_post()
    {
        // create our http client (Guzzle)
        $client = new Client([
            'base_uri' => 'http://0.0.0.0:80'
        ]);

        $options = [
            'form_params' => [
                'amount' => 10,
                'source_currency' => 'USD',
                'target_currency' => 'ARS'
            ]
        ];

        $response = $client->post('/', $options);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(201, $response->getStatusCode());
        $this->assertTrue($response->getBody()->getContents() !== null);
    }

}
