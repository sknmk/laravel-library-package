<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Sknmk\LibraryOperations\Models\Reader;


class ReaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 30; $i++) {
            Reader::create([
                'name' => "Reader " . $i,
                'email' => "reader_" . $i . "@mail.com",
                'status' => 1,
            ]);
        }
    }
}
