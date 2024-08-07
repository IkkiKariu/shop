<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertCategory([
            'name' => 'диски отрезные',
            'description' => 'Отрезные диски - это оснастка для электроинструмента, они предназначены для быстрой и аккуратной резки различных заготовок и конструкций из разного материала'
        ]);

        $this->insertCategory([
            'name' => 'металлические рубанки',
            'description' => null
        ]);
        
        $this->insertCategory([
            'name' => 'эксцентриковые полировальные машинки',
            'description' => null
        ]);

        $this->insertCategory([
            'name' => 'пистолеты для герметика ручные',
            'description' => null
        ]);

        $this->insertCategory([
            'name' => 'разное',
            'description' => 'товары самого разного назначения'
        ]);

        $this->insertCategory([
            'name' => 'автомобильные краски',
            'description' => 'краски для авто всех моделей'
        ]);
    }

    private function insertCategory(array $categoryData)
    {
        DB::table('categories')->insert([
            'id' => Str::uuid(),
            'name' => $categoryData['name'],
            'description' => $categoryData['description'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
