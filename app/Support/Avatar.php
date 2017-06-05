<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Avatar
{
    CONST WIDTH = 100;
    CONST HEIGHT = 100;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $name;

    /**
     * @param UploadedFile $file
     * @return void
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->name = $file->hashName();
    }

    /**
     * @param  UploadedFile $file
     * @return string path
     */
    public static function upload(UploadedFile $file) {
        return (new static($file))->process();
    }

    /**
     * Generate relative path to the avatar.
     *
     * @return string
     */
    public function path()
    {
        return config('image.path.relative') . '/' . $this->name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Upload file to the storage.
     *
     * @return this
     */
    private function process()
    {
        Storage::put($path = $this->path(), (string) $this->resizeImage()->encode());

        return $this;
    }

    /**
     * @return \Intervention\Image\Image
     */
    private function resizeImage()
    {
        return Image::make($this->file)
            ->fit(self::WIDTH, self::HEIGHT, function ($c) {
                $c->aspectRatio();
            });
    }
}
