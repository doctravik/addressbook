<?php

namespace Tests\Feature;

use App\Person;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdatePhotoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_update_photo_attribute_of_the_person()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('patch', "/api/persons/{$person->id}/avatar", [
            'photo' => UploadedFile::fake()->image('avatar.png')
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($person->fresh()->photo);
    }

    /** @test */
    public function it_cannot_update_photo_if_photo_is_empty()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('patch', "/api/persons/{$person->id}/avatar", [
            'photo' => ''
        ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('photo', $response->json());
        $this->assertNull($person->fresh()->photo);
    }

    /** @test */
    public function it_cannot_update_photo_if_photo_size_is_more_than_2MB()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('patch', "/api/persons/{$person->id}/avatar", [
            'photo' => UploadedFile::fake()->image('avatar.jpg')->size(2049)
        ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('photo', $response->json());
        $this->assertNull($person->fresh()->photo);
    }

    /** @test */
    public function it_cannot_update_photo_if_photo_type_is_not_image()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('patch', "/api/persons/{$person->id}/avatar", [
            'photo' => UploadedFile::fake()->image('avatar.pdf')->size(2049)
        ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('photo', $response->json());
        $this->assertNull($person->fresh()->photo);
    }
}
