<?php

namespace Tests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * File storage.
     *
     * @var Illuminate\Filesystem\FilesystemAdapter
     */
    protected $storage;

    public function setUp()
    {
        parent::setUp();

        $this->storage = $this->fakeStorage();
    }

    /**
     * Create fake storage.
     *
     * @param string $name
     * @return Illuminate\Filesystem\FilesystemAdapter
     */
    protected function fakeStorage($name = 'avatars')
    {
        Storage::fake($name);
        config(['filesystems.default' => $name]);

        return Storage::disk($name);
    }
}
