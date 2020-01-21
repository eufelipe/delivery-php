<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Http\Controllers\Api\DeliveriesController;
use App\Http\Controllers\Controller;
use App\Models\Delivery;

class DeliveriesControllerTest extends TestCase
{

    use WithoutMiddleware;



    /**
     * Testa se implementa Controller
     */
    public function test_if_should_extends_abstract_controller()
    {
        $controller = new DeliveriesController();

        $actual = $controller;
        $expected = Controller::class;
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * Testa se esta retornando a listagem de deliveries.
     */
    public function test_if_can_list_deliveries()
    {
        $uri = route('api.deliveries.index');
        $this->json('GET', $uri)
            ->assertStatus(200)
            ->assertSee('[')
            ->assertSee(']');
    }


    /**
     * Testa se é possivel criar uma nova delivery.
     *
     * @return void
     */
    public function test_if_can_create_an_delivery_record()
    {
        $uri = route('api.deliveries.store');
        $unprocessableEntity = 422;
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $this->json('POST', $uri, $data)
            ->assertStatus(201)
            ->assertSee('id');

        $data = [];

        $this->json('POST', $uri, $data)
            ->assertSee('message')
            ->assertSee('description')
            ->assertStatus($unprocessableEntity);


        $data = ["client" => null];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.client.required')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "a"];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.client.min')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book It has survive."];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.client.max')))
            ->assertStatus($unprocessableEntity);


        $data = ["client" => "Felipe Rosas", "delivery_date" => null];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.delivery_date.required')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => 'a'];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.delivery_date.date')))
            ->assertStatus($unprocessableEntity);



        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => null];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.target_start.required')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "aa"];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.target_start.min')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book It has survive."];
        $this->json('POST', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.target_start.max')))
            ->assertStatus($unprocessableEntity);



        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Rua A", "target_end" => null];
            $this->json('POST', $uri, $data)
                ->assertSee(json_encode(trans('deliveries.validator.target_end.required')))
                ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Rua A", "target_end" => "aa"];
            $this->json('POST', $uri, $data)
                ->assertSee(json_encode(trans('deliveries.validator.target_end.min')))
                ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Rua A", "target_end" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book It has survive."];
            $this->json('POST', $uri, $data)
                ->assertSee(json_encode(trans('deliveries.validator.target_end.max')))
                ->assertStatus($unprocessableEntity);
    }


    /**
     * Testa se é possivel atualizar um delivery
     */
    public function test_if_can_update_a_delivery()
    {
        $unprocessableEntity = 422;
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $delivery = Delivery::create($data);

        $update = [
            "client" => "João das Couves Updated",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3, Updated",
            "target_end" => "Av Governador Amaral Peixoto, 4, Updated",
        ];

        $uri = route('api.deliveries.update', ['delivery' => $delivery]);
        $this->json('PUT', $uri, $update)
            ->assertStatus(200)
            ->assertSee(json_encode("João das Couves Updated"))
            ->assertSee("id");

        $data = ["client" => null];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.client.required')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "a"];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.client.min')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book It has survive."];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.client.max')))
            ->assertStatus($unprocessableEntity);


        $data = ["client" => "Felipe Rosas", "delivery_date" => null];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.delivery_date.required')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => 'a'];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.delivery_date.date')))
            ->assertStatus($unprocessableEntity);



        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => null];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.target_start.required')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "aa"];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.target_start.min')))
            ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book It has survive."];
        $this->json('PUT', $uri, $data)
            ->assertSee(json_encode(trans('deliveries.validator.target_start.max')))
            ->assertStatus($unprocessableEntity);



        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Rua A", "target_end" => null];
            $this->json('PUT', $uri, $data)
                ->assertSee(json_encode(trans('deliveries.validator.target_end.required')))
                ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Rua A", "target_end" => "aa"];
            $this->json('PUT', $uri, $data)
                ->assertSee(json_encode(trans('deliveries.validator.target_end.min')))
                ->assertStatus($unprocessableEntity);

        $data = ["client" => "Felipe Rosas", "delivery_date" => '2020-02-10 10:00:00', "target_start" => "Rua A", "target_end" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book It has survive."];
            $this->json('PUT', $uri, $data)
                ->assertSee(json_encode(trans('deliveries.validator.target_end.max')))
                ->assertStatus($unprocessableEntity);
    }



    /**
     * Testa se é possivel deletar um delivery.
     */
    public function test_if_can_delete_a_delivery()
    {
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $delivery = Delivery::create($data);

        $uri = route('api.deliveries.destroy', ['delivery' => $delivery]);

        $this->json('DELETE', $uri)
            ->assertStatus(204);
    }

    /**
     * Testa se ocorre erro ao deletar um delivery que nao existe.
     */
    public function test_if_delete_not_found_a_delivery()
    {
        $delivery = new Delivery();
        $delivery->id = -1;

        $uri = route('api.deliveries.destroy', ['delivery' => $delivery]);
        $this->json('DELETE', $uri)
            ->assertStatus(404);
    }

}
