<?php

namespace Tests\Feature;

use App\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeletePersonTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_delete_person()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('delete', "/api/persons/{$person->id}");

        $response->assertStatus(200);
        $this->assertCount(0, Person::all());
    }
}
