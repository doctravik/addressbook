<?php

namespace App\Observers;

use App\Person;

class PersonObserver
{
    /**
     * Listen to the Person deleted event.
     *
     * @param Person $person
     * @return void
     */
    public function deleted(Person $person)
    {
        if ($person->hasPhoto()) {
            $person->removePhoto();
        }
    }
}
