<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;

use App\Repositories\AbstractRepository;
use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AbstractRepositoryTest extends TestCase
{
    /**
     * Testa se a AbstractRepository implementa um RepositoryInterface
     */

    public function test_if_abstract_repository_implements_repository_interface()
    {
        $mock = Mockery::mock(AbstractRepository::class);

        $actual = $mock;
        $expected = RepositoryInterface::class;
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * Testa se o método ->all() retornou corretamente
     */
    public function test_if_all_records_are_being_returned_without_argments_and_are_instances_of_stdClass()
    {

        $stdClass = Mockery::mock(\stdClass::class);
        $stdClass->id = 1;
        $stdClass->title = "Title 1";

        $mock = Mockery::mock(AbstractRepository::class);
        $mock->shouldReceive('all')
            ->andReturn([$stdClass, $stdClass, $stdClass]);

        $actual = $mock->all();
        $expected = 3;
        $this->assertCount($expected, $actual);

        $actual = $mock->all()[0];
        $expected = \stdClass::class;
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * Testa se o método ->all( ['id', 'title'] ) retornou corretamente (com parametros)
     */

    public function test_if_all_records_are_being_returned_with_argments_and_are_instances_of_stdClass()
    {
        $arguments = ['id', 'title'];

        $stdClass = Mockery::mock(\stdClass::class);
        $stdClass->id = 1;
        $stdClass->title = "Title 1";

        $mock = Mockery::mock(AbstractRepository::class);
        $mock->shouldReceive('all')
            ->with($arguments)
            ->andReturn([$stdClass, $stdClass, $stdClass]);

        $actual =  $mock->all($arguments);
        $expected = 3;
        $this->assertCount($expected, $actual);
    }


    /**
     * Testa se é possivel criar um registro
     */

    public function test_if_it_is_possible_to_create_a_record()
    {
        $data = [
            'title' => 'Title 1',
            'description' => 'Description 1',
        ];

        $stdClass = Mockery::mock(\stdClass::class);
        $stdClass->id = 1;
        $stdClass->title = "Title 1";

        $mock = Mockery::mock(AbstractRepository::class);
        $mock->shouldReceive('create')
            ->with($data)
            ->andReturn($stdClass);

        $result = $mock->create($data);

        $actual = $result->id;
        $expected = 1;
        $this->assertEquals($expected, $actual);
    }



    /**
     * Testa se é possivel atualizar um registro
     */
    public function test_if_it_is_possible_to_update_a_record()
    {
        $data = [
            'title' => 'Title 1',
            'description' => 'Description 1',
        ];

        $id = 1;

        $stdClass = Mockery::mock(\stdClass::class);
        $stdClass->id = 1;
        $stdClass->title = "Title 1";

        $mock = Mockery::mock(AbstractRepository::class);
        $mock->shouldReceive('update')
            ->with($data, $id)
            ->andReturn($stdClass);

        $result = $mock->update($data, $id);

        $actual = $result->id;
        $expected = $id;
        $this->assertEquals($expected, $actual);

        $actual = $result;
        $expected = \stdClass::class;
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * Testa se ocorre uma Exception ao tentar atualizar um registro que não existe.
     */

    public function test_if_it_is_possible_to_update_a_record_and_a_failure_occurs()
    {
        $data = [
            'title' => 'Title 1',
            'description' => 'Description 1',
        ];

        $id = 0;

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('update')
            ->with($data, $id)
            ->andThrow($throw);

        $this->expectException(ModelNotFoundException::class);

        $mock->update($data, $id);
    }



    /**
     * Testa se é possivel deletar um registro
     */
    public function test_if_it_is_possible_to_delete_a_record()
    {

        $id = 1;
        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('delete')
            ->with($id)
            ->andReturn(true);

        $result = $mock->delete($id);

        $actual = $result;
        $expected = true;
        $this->assertEquals($expected, $actual);
    }


    /**
     * Testa se ocorre uma Exception ao tentar deletar um registro que não existe
     */

    public function test_if_it_is_possible_to_delete_a_record_and_a_failure_occurs()
    {

        $id = 1;

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('delete')
            ->with($id)
            ->andThrow($throw);

        $this->expectException(ModelNotFoundException::class);

        $mock->delete($id);
    }



    /**
     * Testa se é possivel buscar um registro
     */
    public function test_if_it_is_possible_to_find_a_record()
    {

        $id = 1;
        $stdClass = Mockery::mock(\stdClass::class);
        $stdClass->id = 1;
        $stdClass->title = "Title 1";

        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('find')
            ->with($id)
            ->andReturn($stdClass);

        $result = $mock->find($id);

        $actual = $result;
        $expected = \stdClass::class;
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * Testa se é possivel buscar um registro (passando parametros)
     */
    public function test_if_it_is_possible_to_find_a_record_with_colums()
    {

        $id = 1;
        $stdClass = Mockery::mock(\stdClass::class);
        $stdClass->id = 1;
        $stdClass->title = "Title 1";

        $argments = ['id', 'title'];
        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('find')
            ->with($id, $argments)
            ->andReturn($stdClass);

        $result = $mock->find($id, $argments);

        $actual = $result;
        $expected = \stdClass::class;
        $this->assertInstanceOf($expected, $actual);
    }




    /**
     * Testa se ocorre uma Exception ao buscar um registro que não existe
     */

    public function test_if_it_is_possible_to_find_a_record_and_a_failure_occurs()
    {

        $id = 0;

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('find')
            ->with($id)
            ->andThrow($throw);

        $this->expectException(ModelNotFoundException::class);

        $mock->find($id);
    }



    /**
     * Testa se é possivel buscar um registro pela coluna
     */
    public function test_if_it_is_possible_to_findBy_a_record()
    {
        $field = 'title';
        $value = "value";
        $columns = ['id', 'title'];

        $stdClass = Mockery::mock(\stdClass::class);
        $stdClass->id = 1;
        $stdClass->title = "Title 1";

        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('findBy')
            ->with($field, $value, $columns)
            ->andReturn([$stdClass, $stdClass, $stdClass]);

        $result = $mock->findBy($field, $value, $columns);

        $actual = $result;
        $expected = 3;
        $this->assertCount($expected, $actual);

        $actual = $result[0];
        $expected = \stdClass::class;
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * Testa se é possivel buscar um registro pela coluna, porém sem obter resultados
     */

    public function test_if_it_is_possible_to_findBy_a_record_empty_result()
    {

        $field = 'title';
        $value = "";
        $columns = ['id', 'title'];

        $mock = Mockery::mock(AbstractRepository::class);
        $mock
            ->shouldReceive('findBy')
            ->with($field, $value, $columns)
            ->andReturn([]);

        $result = $mock->findBy($field, $value, $columns);

        $actual = $result;
        $expected = 0;
        $this->assertCount($expected, $actual);
    }

}
