<?php

use App\Person;
use Illuminate\Database\Seeder;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persons')->truncate();

        factory(Person::class, 35)->create();
    }
}
