<?php

namespace App;

use App\Filters\Filter;
use App\Support\PhotoPath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    /**
     * @var string
     */
    protected $table = 'persons';

    /**
     * Attributed that are massassignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'age', 'city', 'photo'];

    /**
     * Scope persons by the given filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param Filter $filter
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }

    /**
     * Generate relative path to the photo.
     *
     * @return string
     */
    public function photoRelativePath()
    {
        return PhotoPath::relative($this->photo);
    }

    /**
     * Generate relative path to the image.
     *
     * @return string
     */
    public function photoAbsolutePath()
    {
        return PhotoPath::absolute($this->photo);
    }

    /**
     * return boolean
     */
    public function hasPhoto()
    {
        return (bool) $this->photo;
    }

    /**
     * Add photo for person
     *
     * @param $path
     * @return void
     */
    public function addPhoto($path)
    {
        $this->update(['photo' => $path]);
    }

    /**
     * Remove photo of person from filesystem
     *
     * @return void
     */
    public function removePhoto()
    {
        Storage::delete($this->photoRelativePath());
    }

    /**
     * Remove previous photo.
     *
     * @param string value
     * @return void
     */
    public function setPhotoAttribute($value)
    {
        if ($this->hasPhoto()) {
            $this->removePhoto();
        }

        $this->attributes['photo'] = $value;
    }
}
