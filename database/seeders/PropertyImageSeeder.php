<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;

class PropertyImageSeeder extends Seeder
{
    public function run(): void
    {
        $imagesBySlug = [
            'magnifique-villa-aux-almadies' => [
                'properties/9n20d3npjXRcwnIRUEGUo454KH5WX3Hny9Wyw1ja.jpg',
                'properties/FXHc7Jqhzen6x6cWcjlDRxdI2HaT1lGDL6o4JnxI.jpg',
            ],
            'appartement-f4-avec-vue-mer' => [
                'properties/I4IO8s8jmv6PGO8IcI5qB2xVVu2t062lLBeDYo7N.webp',
            ],
            'villa-moderne-a-ngor' => [
                'properties/NSnw07czZXdn1aDrKWImLfUiUmQGMk2rluWUO57K.jpg',
                'properties/R26XiZfUBhJUlLRS57OTZTxCq0B6QM4vGlwljq2Q.jpg',
            ],
            'appartement-f3-a-mermoz' => [
                'properties/WW5fvqe1Xg8K5oPorhTrwZkuQcKDBcCMPIBmjtgl.jpg',
            ],
            'villa-de-luxe-a-fann' => [
                'properties/Wx2at5AwcfPTG1lCBDNmJ4gF3NkkuRuGgX1ByqaO.jpg',
                'properties/dAolecrjsba1HkJaxIU0fdGU95C77Z55d4KHaRAV.jpg',
            ],
            'appartement-f2-a-liberte' => [
                'properties/ek4xmTQEhSGa1Z5OHYBLbnw9Std3LukKlQmSkgrZ.jpg',
            ],
            'villa-contemporaine-a-point-e' => [
                'properties/eyAyrzArD6DGhvmdhfhMCu5E93awkUvzgUK1vmPa.webp',
                'properties/hNVJdZEJdYPyTcjG7JsBLLLRjSRp4pSj3dnqpsfl.webp',
            ],
            'appartement-f4-a-sacre-coeur' => [
                'properties/kX983BJQvZvmvtq9aFVwSu8Q381pGEeV1xBUvcX9.webp',
            ],
            'terrain-titre-a-saly' => [
                'properties/njbDFgxJchHi4tbPFSwM4Lqng3U9R5SPEXrAJiZ2.webp',
            ],
            'maison-de-vacances-a-somone' => [
                'properties/pAN3qHy2w5oWypRS4BiKKxdIkqfI6NpcbkXHTqRM.jpg',
            ],
            'immeuble-de-rapport-a-rufisque' => [
                'properties/uFzm7O6HMl3kWUDxbTrpa8G5UIpiGrh2Q03AwLbJ.jpg',
                'properties/xX76r3iuhPRLvUEn3guzP6qEWK1EvXl54oNhIWn1.jpg',
                'properties/xwU8p8oCjSzt0eTZyFw0ZfS7i16BDifjDWSZu9op.jpg',
            ],
        ];

        foreach ($imagesBySlug as $slug => $paths) {
            $property = Property::query()->where('slug', $slug)->first();

            if (! $property) {
                continue;
            }

            foreach ($paths as $index => $path) {
                PropertyImage::query()->updateOrCreate(
                    [
                        'property_id' => $property->id,
                        'image_path' => $path,
                    ],
                    [
                        'sort_order' => $index,
                        'is_main' => $index === 0,
                    ],
                );
            }
        }
    }
}
