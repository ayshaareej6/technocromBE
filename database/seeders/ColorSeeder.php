<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([

            
            'primary_color' => '#FF0000',
            'secondary_color' => '#FF0000',
            'ternary_color' => '#FF0000',
            'other_color' => '#FF0000',
            'created_by' => '1',
            

            
            'primary_color' => '#FF007F',
            'secondary_color' => '#FF007F',
            'ternary_color' => '#FF007F',
            'other_color' => '#FF007F',
            'created_by' => '1',
            

            'primary_color' => '#FF33FF',
            'secondary_color' => '#FF33FF',
            'ternary_color' => '#FF33FF',
            'other_color' => '#FF33FF',
            'created_by' => '1',
            

            'primary_color' => '#0000FF',
            'secondary_color' => '#0000FF',
            'ternary_color' => '#0000FF',
            'other_color' => '#0000FF',
            'created_by' => '1',
            

            'primary_color' => '#00FFFF',
            'secondary_color' => '#00FFFF',
            'ternary_color' => '#00FFFF',
            'other_color' => '#00FFFF',
            'created_by' => '1',
            

            'primary_color' => '#00FF00',
            'secondary_color' => '#00FF00',
            'ternary_color' => '#00FF00',
            'other_color' => '#00FF00',
            'created_by' => '1',
            

            'primary_color' => '#FFA500',
            'secondary_color' => '#FFA500',
            'ternary_color' => '#FFA500',
            'other_color' => '#FFA500',
            'created_by' => '1',
            

            'primary_color' => '#808080',
            'secondary_color' => '#808080',
            'ternary_color' => '#808080',
            'other_color' => '#808080',
            'created_by' => '1',
            

            'primary_color' => '#A52A2A',
            'secondary_color' => '#A52A2A',
            'ternary_color' => '#A52A2A',
            'other_color' => '#A52A2A',
            'created_by' => '1',
            

            'primary_color' => '#FFFF00',
            'secondary_color' => '#FFFF00',
            'ternary_color' => '#FFFF00',
            'other_color' => '#FFFF00',
            'created_by' => '1',
            

            'primary_color' => '#B22222',
            'secondary_color' => '#B22222',
            'ternary_color' => '#B22222',
            'other_color' => '#B22222',
            'created_by' => '1',
            

        ]);
    }
}
