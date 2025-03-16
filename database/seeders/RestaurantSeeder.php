<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        // Array of restaurants with place_ids as their ids
        $restaurants = [
            [
                'id'             => '51ae547daa47a818c0598d2dd37080334240f00102f901c2f2821a0000000092030a43617361204d61797465',
                'name'           => 'Casa Mayte'
            ],
            [
                'id'             => '51785ff0c407a918c0593ab980c75c334240f00103f901ad3b0ba702000000920310c3817469636f2047616474726f626172',
                'name'           => 'Ático Gadtrobar'
            ],
            [
                'id'             => '5145042f0c1ea718c059398652068e334240f00102f901dafdf4150000000092031646656e6720536875692053616e637469205065747269',
                'name'           => 'Feng Shui Sancti Petri'
            ],
            [
                'id'             => '51d53cec2a49ab18c059b88b4157c7324240f00103f9017504ee330100000092030c50617a6f2064652049726961',
                'name'           => 'Pazo de Iria'
            ],
            [
                'id'             => '5140a9f023beb418c0591c37de034f324240f00102f90109f6821a0000000092030c417a6168617220436f737461',
                'name'           => 'Azahar Costa'
            ],
            [
                'id'             => '51357a90f9dba118c0593224222ccf344240f00103f901b92bd0a10200000092030a456c2063616d7069746f',
                'name'           => 'El campito'
            ],
            [
                'id'             => '514ba0d2d226a018c05966dfbc6834354240f00103f9019242b9f40000000092031254616265726e61204c61204d6f6465726e61',
                'name'           => 'Taberna La Moderna'
            ],
            [
                'id'             => '51e4bace2b43a118c05986df9a1084354240f00103f901886ba0bd0200000092031352657374617572616e7465204d6920416c6d61',
                'name'           => 'Restaurante Mi Alma'
            ],
            [
                'id'             => '51652607a2dd9f18c059b08c713f96354240f00103f901f7651675000000009203084d616e6775697461',
                'name'           => 'Manguita'
            ],
            [
                'id'             => '51f409eaa5739f18c0592e84b6cc8e354240f00103f901e3d2ca62000000009203154c612045737175696e612064656c204a616dc3b36e',
                'name'           => 'La Esquina del Jamón'
            ],
            [
                'id'             => '51e9a3e77173bd18c059761471207f314240f00103f90131da95110100000092031252657374617572616e746520506f70657965',
                'name'           => 'Restaurante Popeye'
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
