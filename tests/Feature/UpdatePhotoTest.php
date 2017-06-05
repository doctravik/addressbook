<?php

namespace Tests\Feature;

use App\Person;
use Tests\TestCase;
use App\Support\Avatar;
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

        $response = $this->json('post', "/api/persons/{$person->id}/avatar", [
            'photo' => UploadedFile::fake()->image('avatar.png')
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($person->fresh()->photo);
    }

    /** @test */
    public function it_cannot_update_photo_if_photo_is_empty()
    {
        $person = factory(Person::class)->create();

        $response = $this->json('post', "/api/persons/{$person->id}/avatar", [
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

        $response = $this->json('post', "/api/persons/{$person->id}/avatar", [
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

        $response = $this->json('post', "/api/persons/{$person->id}/avatar", [
            'photo' => UploadedFile::fake()->image('avatar.pdf')->size(2049)
        ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('photo', $response->json());
        $this->assertNull($person->fresh()->photo);
    }


    /** @test */
    public function it_deletes_previous_file_from_filesystem_when_new_photo_is_uploaded()
    {
        $person = factory(Person::class)->create();
        $avatar = Avatar::upload(UploadedFile::fake()->image('firstImage.jpg'));
        $person->addPhoto($avatar->name());

        $response = $this->json('post', "/api/persons/{$person->id}/avatar", [
            'photo' => UploadedFile::fake()->image('avatar.png')
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($person->fresh()->photo);
        $this->assertCount(1, $this->storage->allFiles());
    }

    /** @test */
    public function it_deletes_photo_from_filesystem_when_person_is_deleted()
    {
        $person = factory(Person::class)->create();
        $avatar = Avatar::upload(UploadedFile::fake()->image('firstImage.jpg'));
        $person->addPhoto($avatar->name());

        $response = $this->json('delete', "/api/persons/{$person->id}");

        $response->assertStatus(200);
        $this->assertCount(0, Person::all());
        $this->assertCount(0, $this->storage->allFiles());
    }
}
