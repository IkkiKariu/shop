<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newProductsDataList = [
            [
                'name' => 'Металлический рубанок Gigant GMJP-1',
                'description' => 'Металлический рубанок Gigant GMJP-1 - это универсальный инструмент для обработки древесины. ' .
                    'Изготовлен из высококачественных материалов с соблюдением ГОСТ. Лезвие выполнено из прочной высокоуглеродистой стали, ' .
                    'не оставляет дефектов на обрабатываемой поверхности.',
                'properties' => [
                    [
                        'name' => 'Длина подошвы',
                        'value' => '235 мм'
                    ],
                    [
                        'name' => 'Ширина ножа',
                        'value' => '45 мм'
                    ],
                    [
                        'name' => 'Материал ножа',
                        'value' => 'высокоуглеродистая сталь'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '920.00'
                    ]
                ],
                'categories' => ['металлические рубанки', 'разное']
            ],
            [
                'name' => 'Полуоткрытый пистолет для герметика Inforce 01-13-02',
                'description' => 'Полуоткрытый пистолет для герметика Inforce 01-13-02 пригодится при монтажных и строительных работах. ' .
                    'Используется для нанесения герметика при герметизации различных отверстий и швов.',
                'properties' => [
                    [
                        'name' => 'Материал корпуса',
                        'value' => 'ударопрочный пластик'
                    ],
                    [
                        'name' => 'Конструкция',
                        'value' => 'полузакрытый'
                    ],
                    [
                        'name' => 'Объем баллона',
                        'value' => '0.31 л'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '432.00'
                    ]
                ],
                'categories' => ['пистолеты для герметика ручные']
            ],
            [
                'name' => 'Диск отрезной по металлу (125х1.2х22.23 мм) Inforce IN125x1,2',
                'description' => 'Диск отрезной Inforce IN125x1,2 является сменным элементом для угловых шлифовальных машин. ' .
                    'Применяется для резки металлических изделий. Диск обладает высокой производительностью и большим ресурсом работы',
                'properties' => [
                    [
                        'name' => 'Max число оборотов',
                        'value' => '12250 об/мин' 
                    ],
                    [
                        'name' => 'Назначение',
                        'value' => 'по металлу'
                    ],
                    [
                        'name' => 'Толщина',
                        'value' => '1.2 мм'
                    ],
                    [
                        'name' => 'Материал абразива',
                        'value' => 'оксид алюминия'
                    ],
                    [
                        'name' => 'Тип диска',
                        'value' => 'отрезной'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '86.00'
                    ],
                    [
                        'condition' => 'за 10 шт.',
                        'value' => '700.00'
                    ]
                ],
                'categories' => ['диски отрезные', 'разное']
            ],
            [
                'name' => 'L 1506 VR2/140 Эксцентриковая полировальная машина с двумя дисками 407283',
                'description' => 'Эксцентриковая полировальная машина FLEX L1506 VR2 с двойным полировальным узлом мощностью 1200 Вт ' .
                    'Специализированный инструмент для полировки лаковых покрытий на плоских и изогнутых поверхностях, применяется при полировке автомобилей.',
                'properties' => [
                    [
                        'name' => 'Диаметр опорного диска',
                        'value' => '100 мм' 
                    ],
                    [
                        'name' => 'Частота вращения на холостом ходу',
                        'value' => '1200-5400/мин'
                    ],
                    [
                        'name' => 'Потребляемая мощность',
                        'value' => '1200 вт'
                    ],
                    [
                        'name' => 'Ход эксцентрика',
                        'value' => '16 мм'
                    ],
                    [
                        'name' => 'Вес',
                        'value' => '3,6 кг'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '93500.00'
                    ]
                ],
                'categories' => ['эксцентриковые полировальные машинки', 'разное']
            ],
            [
                'name' => 'Металлический рубанок STAYER 235х50 мм 1865_z02',
                'description' => 'Металлический рубанок STAYER 235х50 мм 1865_z02 применяется для чистового ручного строгания древесины различных пород, ' . 
                    'а также для строгания торцов заготовок или торцов деталей в собранных изделиях (рамках, коробках и др.)',
                'properties' => [
                    [
                        'name' => 'Длина подошвы',
                        'value' => '235 мм'
                    ],
                    [
                        'name' => 'Ширина ножа',
                        'value' => '45 мм'
                    ],
                    [
                        'name' => 'Материал ножа',
                        'value' => 'высокоуглеродистая сталь'
                    ],
                    [
                        'name' => 'Вес нетто',
                        'value' => '0.57 кг'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '1420.00'
                    ]
                ],
                'categories' => ['металлические рубанки', 'разное']
            ],
            [
                'name' => 'Полировальная машинка эксцентриковая Au-061251100',
                'description' => null,
                'properties' => [
                    [
                        'name' => 'Вольтаж',
                        'value' => '110V ~ 220V' 
                    ],
                    [
                        'name' => 'Частота',
                        'value' => '60 HZ ~ 50 HZ'
                    ],
                    [
                        'name' => 'Мощность',
                        'value' => '1100 W'
                    ],
                    [
                        'name' => 'Обороты кручения',
                        'value' => '2000-4800 rpm'
                    ],
                    [
                        'name' => 'Диаметр подложки',
                        'value' => 'до 125 мм'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '93500.00'
                    ]
                ],
                'categories' => ['эксцентриковые полировальные машинки', 'разное']
            ],
            [
                'name' => 'Пистолет для герметиков Gigant 310мл GCG-3',
                'description' => 'Пистолет для герметиков Gigant 310мл GCG-3 подходит для работы с картриджами объемом 310 мл, ' .
                    'имеет усиленную скелетную конструкцию из стали, ручку из алюминиевого сплава, которые способствуют равномерной подачи клея либо герметика. ' . 
                    'Это обеспечивает прочность и надежность конструкции пистолета при использовании.',
                'properties' => [
                    [
                        'name' => 'Материал корпуса',
                        'value' => 'металл'
                    ],
                    [
                        'name' => 'Конструкция',
                        'value' => 'полузакрытый'
                    ],
                    [
                        'name' => 'Объем баллона',
                        'value' => '0.31 л'
                    ],
                    [
                        'name' => 'Питание',
                        'value' => 'механический'
                    ],
                    [
                        'name' => 'Производительность',
                        'value' => '200 г/мин'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '621.00'
                    ]
                ],
                'categories' => ['пистолеты для герметика ручные']
            ],
            [
                'name' => 'Круг отрезной по металлу и нержавеющей стали (125х1,0х22 мм, A 54 S BF L) Tsunami D16101251022000',
                'description' => 'Предлагаем Вашему вниманию высококачественные отрезные круги Tsunami. ' .
                    'Круги производят на современном заводе в России из качественного сырья. ' .
                    'Всё сырьё проходит строгий входной контроль на соответствие требований стандарта. ' . 
                    'Жесткий контроль качества на каждом этапе производства, применение современных материалов и строгое соблюдение всех требований и норм производства, ' . 
                    'обеспечивают кругам Tsunami высокую производительность и безопасность.',
                'properties' => [
                    [
                        'name' => 'Max число оборотов',
                        'value' => '12250 об/мин' 
                    ],
                    [
                        'name' => 'Назначение',
                        'value' => 'по металлу'
                    ],
                    [
                        'name' => 'Толщина',
                        'value' => '1 мм'
                    ],
                    [
                        'name' => 'Посадочный диаметр',
                        'value' => '22.2 мм'
                    ],
                    [
                        'name' => 'Тип диска',
                        'value' => 'отрезной'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '41.00'
                    ],
                    [
                        'condition' => 'за 10 шт.',
                        'value' => '350.00'
                    ]
                ],
                'categories' => ['диски отрезные', 'разное']
            ],
            [
                'name' => 'Пистолет для герметиков AI-Ueight',
                'description' => null,
                'properties' => [
                    [
                        'name' => 'Материал корпуса',
                        'value' => 'металл'
                    ],
                    [
                        'name' => 'Конструкция',
                        'value' => 'полузакрытый'
                    ],
                    [
                        'name' => 'Объем баллона',
                        'value' => '0.43 л'
                    ],
                    [
                        'name' => 'Питание',
                        'value' => 'механический'
                    ],
                    [
                        'name' => 'Производительность',
                        'value' => '150 г/мин'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 шт.',
                        'value' => '721.00'
                    ]
                ],
                'categories' => ['пистолеты для герметика ручные']
            ],
            [
                'name' => 'Автомобильная краска NISSAN, цвет ZVJ - MOONLIGHT VIOLET',
                'description' => null,
                'properties' => [
                    [
                        'name' => 'Применение',
                        'value' => 'для окрашивания металлов, пластика, стекла'
                    ],
                    [
                        'name' => 'Объем',
                        'value' => '1 л'
                    ],
                    [
                        'name' => 'Цвет',
                        'value' => ' zvj - moonlight violet'
                    ]
                ],
                'prices' =>  [
                    [
                        'condition' => 'за 1 л.',
                        'value' => '4500.00'
                    ],
                    [
                        'condition' => 'за 5 л.',
                        'value' => '22500.00'
                    ]
                ],
                'categories' => ['автомобильные краски', 'разное']
            ]
        ];

        foreach ($newProductsDataList as $newProductData)
        {
            $this->insertAllProductData($newProductData);
        }        
    }

    private function insertAllProductData(array $productData)
    {
        $newProductId = Str::uuid();

        DB::table('products')->insert([
            'id' => $newProductId,
            'name' => $productData['name'],
            'description' => $productData['description'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($productData['properties'] as $property)
        {
            DB::table('properties')->insert([
                'id' => Str::uuid(),
                'product_id' => $newProductId,
                'name' => $property['name'],
                'value' => $property['value']        
            ]);
        }

        foreach ($productData['prices'] as $price)
        {
            DB::table('prices')->insert([
                'id' => Str::uuid(),
                'product_id' => $newProductId,
                'condition' => $price['condition'],
                'value' =>  $price['value'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        foreach ($productData['categories'] as $categoryName)
        {
            $category = DB::table('categories')->where('name', $categoryName)->first();

            if($category)
            {
                DB::table('product_category_relationships')->insert([
                    'id' => Str::uuid(),
                    'product_id' => $newProductId,
                    'category_id' => $category->id 
                ]);
            }
            
        }
    }
}
