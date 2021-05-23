<?php

namespace Tests\Unit;

use App\Repositories\HomeActionsRepo;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    private $data;

    private $expect;

    private $result;

    protected function setUp(): void
    {
        parent::setUp();

        $data         = $this->additionProvider();
        $this->data   = $data[0];
        $this->expect = $data[1];
        $this->result = HomeActionsRepo::splitInputs($this->data);

    }
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testBasicTest()
    {
        $this->assertEquals(json_encode($this->result), json_encode($this->expect));
    }

    public function additionProvider()
    {
        return [

            [
                "sender_name" => "Alex",
                "recipient"   => "Nadya",
                "product"     => "computer",
                "price"       => 11.55,
                "endpoint"    => "sarai",
                "phone"       => 1083842,
            ],
            [
                "bank"   => [
                    "sender_name" => "Alex",
                    "recipient"   => "Nadya",
                    "product"     => "computer",
                    "endpoint"    => "sarai",
                ],
                "parcel" => [
                    "price" => 11.55,
                    "phone" => 1083842,
                ],
            ],

        ];
    }
}
