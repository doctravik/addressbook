<?php

namespace App\Filters;

use App\Filters\Filter;

class PersonFilter extends Filter
{
    /**
     * Registered filters.
     *
     * @var array
     */
    protected $filters = ['name', 'city', 'minAge', 'maxAge', 'sort'];

    /**
     * Filter the query by a name.
     *
     * @param  string $name
     * @return Builder
     */
    protected function name($name)
    {
        return $this->builder->where('name', 'ilike', "%$name%");
    }

    /**
     * Filter the query by a city.
     *
     * @param string $city
     * @return Builder
     */
    protected function city($city)
    {
        return $this->builder->where('city', 'ilike', "%$city%");
    }

    /**
     * Filter the query by the min age.
     *
     * @param int $age
     * @return Builder
     */
    protected function minAge($age)
    {
        return $this->builder->where('age', '>=', $age);
    }

    /**
     * Filter the query by the max age.
     *
     * @param int $age
     * @return Builder
     */
    protected function maxAge($age)
    {
        return $this->builder->where('age', '<=', $age);
    }


    /**
     * Sorting the query by the given attribute
     *
     * @param string $attribute
     * @return Builder
     */
    protected function sort($attribute)
    {
        $order = $this->request->has('order') ? $this->request->input('order') : 'desc';

        return $this->builder->orderBy($attribute, $order);
    }
}
