<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
            ["label"=>"HTML", "color"=>"red"],
            ["label"=>"CSS", "color"=>"aqua"],
            ["label"=>"JavaScript", "color"=>"yellow"],
            ["label"=>"Bootstrap", "color"=>"purple"],
            ["label"=>"Vue", "color"=>"green"],
            ["label"=>"PHP", "color"=>"blue"],
            ["label"=>"SASS", "color"=>"pink"],
            ["label"=>"Laravel", "color"=>"orange"],
            ["label"=>"mySQL", "color"=>"gray"]
        ];
        foreach($technologies as $technology){
            $new_technology=new Technology();
            $new_technology->label = $technology["label"];
            $new_technology->color = $technology["color"];
            $new_technology->save();
        }
    }
}