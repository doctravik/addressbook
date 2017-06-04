<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Support\Avatar;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UploadAvatarTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_upload_avatar_to_the_store_with_the_right_sizes()
    {
        $avatar = Avatar::upload(UploadedFile::fake()->image('avatar.jpg', 200, 200));

        $this->storage->assertExists($avatar->path());
        $this->assertEquals(100, Image::make($this->storage->get($avatar->path()))->width());
        $this->assertEquals(100, Image::make($this->storage->get($avatar->path()))->height());
    }
}
