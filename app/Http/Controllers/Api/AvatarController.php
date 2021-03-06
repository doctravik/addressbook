<?php

namespace App\Http\Controllers\Api;

use App\Person;
use App\Support\Avatar;
use App\Support\PhotoPath;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;

class AvatarController extends Controller
{
    /**
     * Update photo attribute of the Person.
     *
     * @param UpdateAvatarRequest $resuest
     * @param Person $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UpdateAvatarRequest $resuest, Person $person)
    {
        $avatar = Avatar::upload(request('photo'));

        $person->update(['photo' => $avatar->name()]);

        return response()->json([
            'path' => PhotoPath::absolute($avatar->name())
        ], 200);
    }
}
