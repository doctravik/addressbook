<?php

namespace App\Http\Controllers\Api;

use App\Person;
use Illuminate\Http\Request;
use App\Filters\PersonFilter;
use App\Http\Requests\PersonRequest;
use App\Http\Controllers\Controller;
use App\Transformers\PersonTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PersonController extends Controller
{
    /**
     * Read persons from db.
     *
     * @param Filter $filters
     * @return array
     */
    public function index(PersonFilter $filters)
    {
        $persons = Person::filter($filters)->paginate(10);

        return fractal()
            ->collection($persons->getCollection())
            ->transformWith(new PersonTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($persons))
            ->toArray();
    }

    /**
     * Store person in db.
     *
     * @param PersonRequest $request
     * @return array
     */
    public function store(PersonRequest $request)
    {
        $person = Person::create(request()->only('name', 'age', 'city'));

        return fractal()
            ->item($person)
            ->transformWith(new PersonTransformer())
            ->toArray();
    }

    /**
     * Update person in db.
     *
     * @param PersonRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PersonRequest $request, Person $person)
    {
        $person->update(request()->only('name', 'age', 'city'));

        return fractal()
            ->item($person->fresh())
            ->transformWith(new PersonTransformer())
            ->toArray();
    }

    /**
     * Remove person from db.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Person $person)
    {
        $person->delete();

        return response()->json(null, 200);
    }
}
