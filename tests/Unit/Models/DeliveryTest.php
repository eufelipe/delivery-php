<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Delivery;

class DeliveryTest extends TestCase
{

    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * Teste para criação de nova entrega.
     */

     public function test_if_is_possible_create_an_new_delivery()
     {

        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $delivery = Delivery::create($data);

        $actual = Delivery::all();
        $expected = 1;
        $this->assertCount($expected, $actual);

        $actual = $delivery->client;
        $expected = "João das Couves";
        $this->assertEquals($expected, $actual);

        $actual = $delivery->delivery_date;
        $expected = "2020-02-10 10:00:00";
        $this->assertEquals($expected, $actual);

        $actual = $delivery->target_start;
        $expected = "Av. Claudio Besserman Vianna, 3";
        $this->assertEquals($expected, $actual);

        $actual = $delivery->target_end;
        $expected = "Av Governador Amaral Peixoto, 4";
        $this->assertEquals($expected, $actual);

     }


     /**
      * Teste para saber se é  possivel atualizar um delivery.
      */

      public function test_if_is_possible_update_an_delivery()
      {

        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $delivery  = Delivery::create($data);

        $actual = Delivery::all();
        $expected = 1;
        $this->assertCount($expected, $actual);

        $data =[
            "client" => "Fulano Beutrano",
            "delivery_date" => '2020-03-20 20:00:00',
            "target_start" => "Rua Ambrosio, 383",
            "target_end" => "Rua Embaixador Martins, 200",
        ];

        Delivery::whereId($delivery->id)->update($data);

        $delivery = Delivery::find(1);

        $expected = $delivery->client;
        $actual = "Fulano Beutrano";
        $this->assertEquals($expected, $actual);

        $expected = $delivery->delivery_date;
        $actual = "2020-03-20 20:00:00";
        $this->assertEquals($expected, $actual);

        $expected = $delivery->target_start;
        $actual = "Rua Ambrosio, 383";
        $this->assertEquals($expected, $actual);

        $expected = $delivery->target_end;
        $actual = "Rua Embaixador Martins, 200";
        $this->assertEquals($expected, $actual);

      }


      /**
       * Teste para saber se é possivel deletar um delivery.
       */

       public function test_if_is_possible_delete_an_delivery() {

        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $delivery  = Delivery::create($data);

        $actual = Delivery::all();
        $expected = 1;
        $this->assertCount($expected, $actual);

        $delivery->delete();

        $actual = Delivery::all();
        $expected = 0;
        $this->assertCount($expected, $actual);

        $actual = $delivery->trashed();
        $expected = true;
        $this->assertEquals($expected, $actual);

        $actual = Delivery::withTrashed()->get();
        $expected = 1;
        $this->assertCount($expected, $actual);

        $delivery->forceDelete();

        $actual = Delivery::withTrashed()->get();
        $expected = 0;
        $this->assertCount($expected, $actual);

       }
}
