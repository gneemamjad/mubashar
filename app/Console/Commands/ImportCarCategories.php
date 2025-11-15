<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCarCategories extends Command
{
    protected $signature = 'import:car-categories';
    protected $description = 'Import car makes and models into category table';

    public function handle()
    {
        $files = [];

        // for ($year = 1992; $year <= 2026; $year++) {
        for ($year = 1992; $year <= 2026; $year++) {
            $files[] = $year . '.csv';
        }
        
        $carMakes = [];

        foreach ($files as $file) {
            $path = storage_path("app/public/us-car-models-data/{$file}");

            if (!file_exists($path)) {
                $this->error("File {$file} not found!");
                continue;
            }

            if (($handle = fopen($path, "r")) !== false) {
                $header = fgetcsv($handle);

                while (($row = fgetcsv($handle)) !== false) {
                    $make = trim($row[1]);
                    $model = trim($row[2]);

                    if (!$make || is_numeric($make)) {
                        continue;
                    }

                    if (!$model || is_numeric($model)) {
                        continue;
                    }

                    $carMakes[$make][] = $model;
                }

                fclose($handle);
            }
        }
        $carsCategoryId = 16;
        foreach ($carMakes as $make => $models) {
            $models = array_unique($models);

            $makeOther = "Other";
            // Check if Make already exists
            $existingOtherMake = DB::table('category')
            ->where('parent_id', $carsCategoryId)
            ->whereRaw("JSON_EXTRACT(name, '$.en') = ?", [$makeOther])
            ->first();
            
            if(!$existingOtherMake) {
                {
                    $catMakeID = DB::table('category')->insertGetId([
                        'parent_id' => $carsCategoryId,
                        'name' => json_encode([
                            'en' => $makeOther,
                            'ar' => $makeOther
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    
                    for ($j = 13; $j <= 33; $j++) {
                        if(
                            $j == 16
                            ||
                            $j == 18
                            ||
                            $j == 19
                            ||
                            $j == 20
                            ||
                            $j == 28
                            ||
                            $j == 29
                            ||
                            $j == 30
                            ||
                            $j == 31
                            ||
                            $j == 32
                        ) {
                            continue;
                        }
                        DB::table('categories_attributes')->insert([
                            'category_id' => $catMakeID,
                            'attribute_id' => $j,
                            'filter_enabled' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        
            
            // Check if Make already exists
            $existingMake = DB::table('category')
                ->where('parent_id', $carsCategoryId)
                ->whereRaw("JSON_EXTRACT(name, '$.en') = ?", [$make])
                ->first();
            

            if ($existingMake) {
                $makeSaleId = $existingMake->id;
            } else {
                $makeSaleId = DB::table('category')->insertGetId([
                    'parent_id' => $carsCategoryId,
                    'name' => json_encode([
                        'en' => $make,
                        'ar' => $make
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
            }

            foreach ($models as $model) {
                // Check if Model already exists under the Make
                $existingModel = DB::table('category')
                    ->where('parent_id', $makeSaleId)
                    ->whereRaw("JSON_EXTRACT(name, '$.en') = ?", [$model])
                    ->first();

                if (!$existingModel) {
                    $catID = DB::table('category')->insertGetId([
                        'parent_id' => $makeSaleId,
                        'name' => json_encode([
                            'en' => $model,
                            'ar' => $model,
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    for ($i = 13; $i <= 33; $i++) {
                        if(
                            $i == 16
                            ||
                            $i == 18
                            ||
                            $i == 19
                            ||
                            $i == 20
                            ||
                            $i == 28
                            ||
                            $i == 29
                            ||
                            $i == 30
                            ||
                            $i == 31
                            ||
                            $i == 32
                        ) {
                            continue;
                        }
                        DB::table('categories_attributes')->insert([
                            'category_id' => $catID,
                            'attribute_id' => $i,
                            'filter_enabled' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                $modelOther = "Other";
                // Check if Model already exists under the Make
                $existingModelOther = DB::table('category')
                ->where('parent_id', $makeSaleId)
                ->whereRaw("JSON_EXTRACT(name, '$.en') = ?", [$modelOther])
                ->first();
            
                if (!$existingModelOther) {
                    $catID = DB::table('category')->insertGetId([
                        'parent_id' => $makeSaleId,
                        'name' => json_encode([
                            'en' => $modelOther,
                            'ar' => $modelOther,
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    for ($i = 13; $i <= 33; $i++) {
                        if(
                            $i == 16
                            ||
                            $i == 18
                            ||
                            $i == 19
                            ||
                            $i == 20
                            ||
                            $i == 28
                            ||
                            $i == 29
                            ||
                            $i == 30
                            ||
                            $i == 31
                            ||
                            $i == 32
                        ) {
                            continue;
                        }
                        DB::table('categories_attributes')->insert([
                            'category_id' => $catID,
                            'attribute_id' => $i,
                            'filter_enabled' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        $this->info('Car categories imported successfully.');
    }
}
