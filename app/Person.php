<?php

namespace App;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

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
}
