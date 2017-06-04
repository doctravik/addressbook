<?php

namespace App;

use App\Filters\Filter;
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
        return config('image.path.relative') . '/' . $this->photo;
    }

    /**
     * Generate relative path to the image.
     *
     * @return string
     */
    public function photoAbsolutePath()
    {
        return Storage::url($this->photoRelativePath());
    }
}
