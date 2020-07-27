<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Sknmk\LibraryOperations\Models\Label;


class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 30; $i++) {
            Label::updateOrCreate([
                'name' => "Label " . $i,
                'bit_value' => pow(2, $i)
            ]);
        }
    }
}
