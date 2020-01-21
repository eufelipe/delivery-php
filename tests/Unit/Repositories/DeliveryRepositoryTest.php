<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\DeliveryRepository;
use App\Models\Delivery;
use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Mockery;

class DeliveryRepositoryTest extends TestCase
{

    /**
     * Testa se a DeliveryRepository implementa um RepositoryInterface
     */

    public function test_if_delivery_repository_implements_repository_interface()
    {
        $mock = Mockery::mock(DeliveryRepository::class);

        $actual = $mock;
        $expected = RepositoryInterface::class;
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * Testa se o método ->all() retornou corretamente
     */
    public function test_if_delivery_repository_return_records()
    {

        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $repository = resolve(DeliveryRepository::class);

        $repository->create($data);
        $repository->create($data);
        $repository->create($data);


        $actual = $repository->all();
        $expected = 3;
        $this->assertCount($expected, $actual);

        $actual = $repository->all()[0];
        $expected = Delivery::class;
        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * Testa se o método ->all( ['client', 'delivery_date'] ) retornou corretamente (com parametros)
     */

    public function test_if_delivery_repository_return_records_with_only_argments_client_and_link()
    {
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $repository = resolve(DeliveryRepository::class);
        $repository->create($data);

        $delivery = $repository->all()[0];

        $actual = $delivery->client;
        $expected = "João das Couves";
        $this->assertEquals($expected, $actual);

        $delivery = $repository->all('delivery_date')[0];

        $actual = $delivery->client;
        $expected = null;
        $this->assertEquals($expected, $actual);

        $delivery = $repository->all('client')[0];

        $actual = $delivery->client;
        $expected = "João das Couves";
        $this->assertEquals($expected, $actual);
    }


    /**
     *  Testa se é possivel criar uma nova Delivery
     */

    public function test_if_is_possible_create_an_new_delivery_record()
    {

        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $repository = resolve(DeliveryRepository::class);
        $delivery = $repository->create($data);
        $delivery = $repository->create($data);

        $actual = $repository->all();
        $expected = 2;
        $this->assertCount($expected, $actual);

        $actual = $delivery->client;
        $expected = "João das Couves";
        $this->assertEquals($expected, $actual);
    }


    /**
     *  Testa se é possivel atualizar um delivery
     */

    public function test_if_it_is_possible_to_update_an_delivery_record()
    {

        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $repository = resolve(DeliveryRepository::class);
        $delivery = $repository->create($data);

        $actual = $delivery->client;
        $expected = "João das Couves";
        $this->assertEquals($expected, $actual);

        $data =[
            "client" => "João das Couves updated",
            "delivery_date" => '2020-03-20 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3 updated",
            "target_end" => "Av Governador Amaral Peixoto, 4 updated",
        ];

        $updated = $repository->update($data, $delivery->id);

        $actual = $updated->client;
        $expected = "João das Couves updated";
        $this->assertEquals($expected, $actual);

        $actual = $updated->delivery_date;
        $expected = "2020-03-20 10:00:00";
        $this->assertEquals($expected, $actual);

        $actual = $updated->target_start;
        $expected = "Av. Claudio Besserman Vianna, 3 updated";
        $this->assertEquals($expected, $actual);

        $actual = $updated->target_end;
        $expected = "Av Governador Amaral Peixoto, 4 updated";
        $this->assertEquals($expected, $actual);
    }

    /**
     * Testa se ocorre uma Exception ao tentar atualizar um registro que não existe.
     */

    public function test_if_it_is_possible_to_update_a_delivery_record_and_a_failure_occurs()
    {
        $id = 0;
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $repository = resolve(DeliveryRepository::class);

        $this->expectException(ModelNotFoundException::class);

        $repository->update($data, $id);
    }


    /**
     * Testa se é possivel deletar um registro
     */
    public function test_if_it_is_possible_to_delete_a_delivery_record()
    {

        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $repository = resolve(DeliveryRepository::class);
        $delivery = $repository->create($data);

        $result = $repository->delete($delivery->id);

        $actual = $result;
        $expected = true;
        $this->assertEquals($expected, $actual);
    }

    /**
     * Testa se ocorre uma Exception ao tentar deletar um delivery que não existe
     */

    public function test_if_it_is_possible_to_delete_a_delivery_and_a_failure_occurs()
    {

        $id = 1;

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $repository = resolve(DeliveryRepository::class);

        $this->expectException(ModelNotFoundException::class);

        $repository->delete($id);
    }

    /**
     * Testa se é possivel buscar uma Delivery
     */
    public function test_if_it_is_possible_to_find_a_delivery()
    {

        $id = 1;
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $repository = resolve(DeliveryRepository::class);
        $repository->create($data);

        $result = $repository->find($id);

        $actual = $result;
        $expected = Delivery::class;
        $this->assertInstanceOf($expected, $actual);

        $actual = $result->client;
        $expected = "João das Couves";
        $this->assertEquals($expected, $actual);
    }

    /**
     * Testa se é possivel buscar um Delivery pela coluna client
     */
    public function test_if_it_is_possible_to_findBy_an_delivery_record()
    {
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $field = 'client';
        $value = "João das Couves";

        $repository = resolve(DeliveryRepository::class);
        $repository->create($data);

        $result = $repository->findBy($field, $value);

        $actual = $result;
        $expected = 1;
        $this->assertCount($expected, $actual);

        $actual = $result[0];
        $expected = Delivery::class;
        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * Testa se é possivel buscar um Delivery pela coluna client
     */
    public function test_if_it_is_possible_to_find_like_an_delivery_record()
    {
        $data =[
            "client" => "João das Couves",
            "delivery_date" => '2020-02-10 10:00:00',
            "target_start" => "Av. Claudio Besserman Vianna, 3",
            "target_end" => "Av Governador Amaral Peixoto, 4",
        ];

        $field = 'client';
        $value = "João das Couves";

        $repository = resolve(DeliveryRepository::class);
        $repository->create($data);

        $result = $repository->like($field, $value);

        $actual = $result;
        $expected = 1;
        $this->assertCount($expected, $actual);

        $actual = $result[0];
        $expected = Delivery::class;
        $this->assertInstanceOf($expected, $actual);
    }
}
