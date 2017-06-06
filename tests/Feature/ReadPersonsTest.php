<?php

namespace Tests\Feature;

use App\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadPersonsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_read_persons()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('get', '/api/persons');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $person->id]);
    }

    /** @test */
    public function it_paginates_persons()
    {
        factory(Person::class, 10)->create();
        $john = factory(Person::class)->create();

        $response = $this->json('get', '/api/persons?page=2');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json()['data']);
        $response->assertJsonFragment(['id' => $john->id]);
    }

    /** @test */
    public function it_filters_persons_by_name()
    {
        $emma = factory(Person::class)->create(['name' => 'emma']);
        $leon = factory(Person::class)->create(['name' => 'leon']);

        $response = $this->json('get', '/api/persons?name=emma');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $emma->id]);
        $response->assertJsonMissing(['id' => $leon->id]);
    }

    /** @test */
    public function it_filters_persons_by_the_min_age()
    {
        $emma = factory(Person::class)->create(['age' => 30]);
        $leon = factory(Person::class)->create(['age' => 25]);

        $response = $this->json('get', '/api/persons?minAge=30');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $emma->id]);
        $response->assertJsonMissing(['id' => $leon->id]);
    }

    /** @test */
    public function it_filters_persons_by_the_max_age()
    {
        $emma = factory(Person::class)->create(['age' => 30]);
        $leon = factory(Person::class)->create(['age' => 35]);

        $response = $this->json('get', '/api/persons?maxAge=30');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $emma->id]);
        $response->assertJsonMissing(['id' => $leon->id]);
    }

    /** @test */
    public function it_filters_persons_by_city()
    {
        $kyiv = factory(Person::class)->create(['city' => 'kyiv']);
        $lviv = factory(Person::class)->create(['city' => 'lviv']);

        $response = $this->json('get', '/api/persons?city=kyiv');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $kyiv->id]);
        $response->assertJsonMissing(['id' => $lviv->id]);
    }

    /** @test */
    public function it_sort_persons_by_the_city_by_desc_order_by_default()
    {
        $kyiv = factory(Person::class)->create(['city' => 'kyiv']);
        $lviv = factory(Person::class)->create(['city' => 'lviv']);

        $response = $this->json('get', '/api/persons?sort=city');
        $ordered = collect($response->json()['data']);

        $response->assertStatus(200);
        $this->assertEquals('lviv', $ordered->first()['city']);
        $this->assertEquals('kyiv', $ordered->last()['city']);
    }

    /** @test */
    public function it_sort_persons_by_the_city_by_asc_order()
    {
        factory(Person::class)->create(['city' => 'kyiv']);
        factory(Person::class)->create(['city' => 'lviv']);

        $response = $this->json('get', '/api/persons?sort=city&order=asc');
        $ordered = collect($response->json()['data']);

        $response->assertStatus(200);
        $this->assertEquals('kyiv', $ordered->first()['city']);
        $this->assertEquals('lviv', $ordered->last()['city']);
    }

    /** @test */
    public function it_sort_persons_by_the_age_by_desc_order()
    {
        factory(Person::class)->create(['age' => 30]);
        factory(Person::class)->create(['age' => 35]);

        $response = $this->json('get', '/api/persons?sort=age&order=desc');
        $ordered = collect($response->json()['data']);

        $response->assertStatus(200);
        $this->assertEquals(35, $ordered->first()['age']);
        $this->assertEquals(30, $ordered->last()['age']);
    }

    /** @test */
    public function it_sort_persons_by_the_age_by_asc_order()
    {
        factory(Person::class)->create(['age' => 30]);
        factory(Person::class)->create(['age' => 35]);

        $response = $this->json('get', '/api/persons?sort=age&order=asc');
        $ordered = collect($response->json()['data']);

        $response->assertStatus(200);
        $this->assertEquals(30, $ordered->first()['age']);
        $this->assertEquals(35, $ordered->last()['age']);
    }

    /** @test */
    public function it_sort_persons_by_the_name_by_desc_order()
    {
        factory(Person::class)->create(['name' => 'emma']);
        factory(Person::class)->create(['name' => 'leon']);

        $response = $this->json('get', '/api/persons?sort=name&order=desc');
        $ordered = collect($response->json()['data']);

        $response->assertStatus(200);
        $this->assertEquals('leon', $ordered->first()['name']);
        $this->assertEquals('emma', $ordered->last()['name']);
    }

    /** @test */
    public function it_sort_persons_by_the_name_by_asc_order()
    {
        factory(Person::class)->create(['name' => 'emma']);
        factory(Person::class)->create(['name' => 'leon']);

        $response = $this->json('get', '/api/persons?sort=name&order=asc');
        $ordered = collect($response->json()['data']);

        $response->assertStatus(200);
        $this->assertEquals('emma', $ordered->first()['name']);
        $this->assertEquals('leon', $ordered->last()['name']);
    }

    /** @test */
    public function it_cannot_sort_persons_if_minAge_is_not_integer()
    {
        $response = $this->json('get', '/api/persons?minAge=young');

        $response->assertStatus(422);
        $this->assertArrayHasKey('minAge', $response->json());
    }

    /** @test */
    public function it_cannot_sort_persons_if_maxAge_is_not_integer()
    {
        $response = $this->json('get', '/api/persons?maxAge=young');

        $response->assertStatus(422);
        $this->assertArrayHasKey('maxAge', $response->json());
    }

    /** @test */
    public function it_cannot_sort_persons_if_order_has_niether_asc_no_desc_values()
    {
        $response = $this->json('get', '/api/persons?order=more');

        $response->assertStatus(422);
        $this->assertArrayHasKey('order', $response->json());
    }

    /** @test */
    public function it_cannot_sort_persons_if_sort_has_no_valid_values()
    {
        $response = $this->json('get', '/api/persons?sort=anything');

        $response->assertStatus(422);
        $this->assertArrayHasKey('sort', $response->json());
    }
}
