<?php

namespace Tests\Feature;

use App\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdatePersonTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_update_person_info()
    {
        $person = factory(Person::class)->create([
            'name' => 'John Doe',
            'age' => 32,
            'city' => 'Kyev'
        ]);

        $response = $this->json('put', "/api/persons/{$person->id}", [
            'name' => 'John Johns',
            'age' => 33,
            'city' => 'Washington DC'
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, Person::all());
        $this->assertDatabaseHas('persons', [
            'name' => 'John Johns',
            'age' => 33,
            'city' => 'Washington DC'
        ]);
    }

    /** @test */
    public function it_cannot_update_person_with_empty_attributes()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('post', '/api/persons', [
            'name' => '',
            'city' => '',
            'age' => ''
        ]);

        $response->assertStatus(422);
        $this->assertCount(1, Person::all());
        $this->assertArrayHasKey('age', $response->json());
        $this->assertArrayHasKey('name', $response->json());
        $this->assertArrayHasKey('city', $response->json());
    }
}
