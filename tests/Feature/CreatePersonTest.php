<?php

namespace Tests\Feature;

use App\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreatePersonTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_create_person()
    {
        $person = factory(Person::class)->make();

        $response = $this->json('post', '/api/persons',
            $person->toArray()
        );

        $response->assertStatus(200);
        $this->assertCount(1, Person::all());
    }

    /** @test */
    public function it_cannot_create_person_with_empty_attributes()
    {
        $response = $this->json('post', '/api/persons', [
            'name' => '',
            'city' => '',
            'age' => ''
        ]);

        $response->assertStatus(422);
        $this->assertCount(0, Person::all());
        $this->assertArrayHasKey('age', $response->json());
        $this->assertArrayHasKey('name', $response->json());
        $this->assertArrayHasKey('city', $response->json());
    }
}
