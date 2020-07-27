<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Sknmk\LibraryOperations\Models\Author;


class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 30; $i++) {
            Author::updateOrCreate([
                'name' => "Author " . $i
            ]);
        }
    }
}
