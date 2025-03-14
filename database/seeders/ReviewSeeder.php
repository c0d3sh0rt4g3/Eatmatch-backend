<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Restaurant;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Array of reviews with restaurant place_ids and Spanish-themed content
        $reviews = [
            [
                'reviewer_id'   => 1,
                'restaurant_id' => '51ae547daa47a818c0598d2dd37080334240f00102f901c2f2821a0000000092030a43617361204d61797465', // Casa Mayte
                'rating'        => 5,
                'title'         => 'Comida casera excepcional',
                'body'          => 'El pollo asado estaba perfecto, jugoso por dentro y crujiente por fuera. Ambiente familiar y servicio atento.',
            ],
            [
                'reviewer_id'   => 2,
                'restaurant_id' => '51785ff0c407a918c0593ab980c75c334240f00103f901ad3b0ba702000000920310c3817469636f2047616474726f626172', // Ático Gadtrobar
                'rating'        => 4,
                'title'         => 'Vistas increíbles',
                'body'          => 'La terraza del ático ofrece unas vistas espectaculares. Los platos estaban buenos aunque un poco pequeños para el precio.',
            ],
            [
                'reviewer_id'   => 3,
                'restaurant_id' => '5145042f0c1ea718c059398652068e334240f00102f901dafdf4150000000092031646656e6720536875692053616e637469205065747269', // Feng Shui Sancti Petri
                'rating'        => 3,
                'title'         => 'Fusión interesante',
                'body'          => 'La mezcla de sabores asiáticos es buena, pero esperaba un poco más autenticidad en los platos tradicionales.',
            ],
            [
                'reviewer_id'   => 4,
                'restaurant_id' => '51d53cec2a49ab18c059b88b4157c7324240f00103f9017504ee330100000092030c50617a6f2064652049726961', // Pazo de Iria
                'rating'        => 5,
                'title'         => 'Cocina gallega espectacular',
                'body'          => 'Los mariscos fresquísimos y el pulpo a feira como en Galicia. Volveré sin duda.',
            ],
            [
                'reviewer_id'   => 5,
                'restaurant_id' => '5140a9f023beb418c0591c37de034f324240f00102f90109f6821a0000000092030c417a6168617220436f737461', // Azahar Costa
                'rating'        => 4,
                'title'         => 'Buena relación calidad-precio',
                'body'          => 'Comida regional bien elaborada y porciones generosas. El servicio podría mejorar un poco en los días concurridos.',
            ],
            [
                'reviewer_id'   => 6,
                'restaurant_id' => '51357a90f9dba118c0593224222ccf344240f00103f901b92bd0a10200000092030a456c2063616d7069746f', // El campito
                'rating'        => 5,
                'title'         => 'El mejor café de la zona',
                'body'          => 'Además de los platos principales, su café es excepcional. El ambiente rústico le da un encanto especial.',
            ],
            [
                'reviewer_id'   => 7,
                'restaurant_id' => '514ba0d2d226a018c05966dfbc6834354240f00103f9019242b9f40000000092031254616265726e61204c61204d6f6465726e61', // Taberna La Moderna
                'rating'        => 4,
                'title'         => 'Tapas modernas con toque tradicional',
                'body'          => 'Buena selección de tapas y raciones. El solomillo con salsa de cabrales delicioso. Recomendable reservar.',
            ],
            [
                'reviewer_id'   => 8,
                'restaurant_id' => '51e4bace2b43a118c05986df9a1084354240f00103f901886ba0bd0200000092031352657374617572616e7465204d6920416c6d61', // Restaurante Mi Alma
                'rating'        => 3,
                'title'         => 'Platos correctos',
                'body'          => 'La comida estaba bien, pero esperaba algo más especial por el nombre tan sugerente del restaurante.',
            ],
            [
                'reviewer_id'   => 9,
                'restaurant_id' => '51652607a2dd9f18c059b08c713f96354240f00103f901f7651675000000009203084d616e6775697461', // Manguita
                'rating'        => 5,
                'title'         => 'Sabor auténtico',
                'body'          => 'Cocina tradicional con toques modernos. Las croquetas caseras son las mejores que he probado en años.',
            ],
            [
                'reviewer_id'   => 10,
                'restaurant_id' => '51f409eaa5739f18c0592e84b6cc8e354240f00103f901e3d2ca62000000009203154c612045737175696e612064656c204a616dc3b36e', // La Esquina del Jamón
                'rating'        => 5,
                'title'         => 'Paraíso del jamón ibérico',
                'body'          => 'Selección de jamones impresionante. La ración de Jabugo 5J con pan con tomate merece la pena el viaje desde cualquier lugar.',
            ],
            [
                'reviewer_id'   => 11,
                'restaurant_id' => '51e9a3e77173bd18c059761471207f314240f00103f90131da95110100000092031252657374617572616e746520506f70657965', // Restaurante Popeye
                'rating'        => 4,
                'title'         => 'Mariscos frescos',
                'body'          => 'Excelente lugar para disfrutar de pescado y marisco. Las gambas al ajillo son espectaculares.',
            ],
            [
                'reviewer_id'   => 12,
                'restaurant_id' => '51ae547daa47a818c0598d2dd37080334240f00102f901c2f2821a0000000092030a43617361204d61797465', // Casa Mayte
                'rating'        => 4,
                'title'         => 'Tradición familiar',
                'body'          => 'Se nota que es un negocio familiar con recetas pasadas de generación en generación. El pollo asado es su especialidad.',
            ],
            [
                'reviewer_id'   => 14,
                'restaurant_id' => '5145042f0c1ea718c059398652068e334240f00102f901dafdf4150000000092031646656e6720536875692053616e637469205065747269', // Feng Shui
                'rating'        => 5,
                'title'         => 'Gran experiencia asiática',
                'body'          => 'No esperaba encontrar comida asiática tan auténtica en Chiclana. Los dumplings y el pato laqueado son extraordinarios.',
            ],
            [
                'reviewer_id'   => 16,
                'restaurant_id' => '51357a90f9dba118c0593224222ccf344240f00103f901b92bd0a10200000092030a456c2063616d7069746f', // El campito
                'rating'        => 3,
                'title'         => 'Bonito lugar pero servicio lento',
                'body'          => 'La comida está bien y el sitio es encantador, pero esperamos casi una hora para ser atendidos en hora punta.',
            ],
            [
                'reviewer_id'   => 18,
                'restaurant_id' => '51785ff0c407a918c0593ab980c75c334240f00103f901ad3b0ba702000000920310c3817469636f2047616474726f626172', // Ático Gadtrobar
                'rating'        => 5,
                'title'         => 'Cena romántica perfecta',
                'body'          => 'Celebramos nuestro aniversario y fue una velada mágica. Las vistas al atardecer desde la terraza son inmejorables.',
            ]
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
