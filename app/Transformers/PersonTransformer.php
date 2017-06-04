<?php

namespace App\Transformers;

use App\Person;
use League\Fractal\TransformerAbstract;

class PersonTransformer extends TransformerAbstract
{
    /**
     * Transform Person object to the generic array
     *
     * @param Person $person
     * @return array
     */
    public function transform(Person $person)
    {
        return [
            'id' => (int) $person->id,
            'name' => $person->name,
            'age' => (int) $person->age,
            'city' => $person->city,
            'photo' => $person->photoAbsolutePath()
        ];
    }
}
