<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ── Wattpad Books ──────────────────────────────────────────
            [
                'title'       => 'Project Loki',
                'category'    => 'wattpad',
                'description' => "Moving to Pampanga to start anew, Lorelei Rios only wants to focus on her new life and live in peace. But when she crosses paths with the ever-mysterious Loki Mendez, she's suddenly dragged into a world of mysteries, changing her life in ways she didn't expect. Joining a detective club is the last thing on high school student Lorelei Rios' mind. However, after being pressured into joining the QED Club by the cold and mysterious Loki Mendez, she unexpectedly finds herself solving mysteries one after another. As they tackle cases and work to decode puzzles and codes, Lorelei realizes that her high school life will never be the same. But when lives and safety are suddenly at risk, can Lorelei and Loki find the courage to face the challenges ahead? Or will their pasts impact their present, causing them to lose focus and ultimately fail?",
                'price'       => 199.00,
                'rating'      => 4.80,
                'is_active'   => true,
            ],
            [
                'title'       => 'Ang Mutya Ng Section E',
                'category'    => 'wattpad',
                'description' => "Simple lang ang gusto ni Jay-jay sa buhay: ang malayo na sa gulo at magkaroon ng normal na high school life. Pero kung gulo na mismo ang lumalapit sa kaniya, mapaninindigan pa rin ba ni Jay-jay ang pangako niya?",
                'price'       => 199.00,
                'rating'      => 4.50,
                'is_active'   => true,
            ],
            [
                'title'       => "Hell University",
                'category'    => 'wattpad',
                'description' => "Sucker for adventures, Zein and her friends try to find Hell University to satisfy their curiosity... Little did they know that once they enter that place, there is no turning back.",
                'price'       => 210.00,
                'rating'      => 4.90,
                'is_active'   => true,
            ],
            [
                'title'       => 'Chasing the Sun',
                'category'    => 'wattpad',
                'description' => "Solene Clemente was a typical Civil Engineering student who struggled to put up with her studies. Kung pwede ngang i-bake na lang ang napakaraming itlog sa test papers niya, ginawa niya na. At a young age, she experienced the harsh reality of life-poverty, abuse, and a broken family. But, as someone who could see the bright side of everything, she knew she could make it with only her mother and best friend, Duke Laurence Sanders, whom she secretly loved.",
                'price'       => 159.00,
                'rating'      => 4.30,
                'is_active'   => true,
            ],
            [
                'title'       => 'Dosage of Serotonin',
                'category'    => 'wattpad',
                'description' => "Siya ang ginhawa, pahinga, at kasiyahan ko. Dumating man ang araw na tanaw ko na ang dulo. Dumating man ang araw na wala na kaming sagot sa lahat ng bakit at paano. Dumating man ang araw na pareho na kaming talo.",
                'price'       => 189.00,
                'rating'      => 4.70,
                'is_active'   => true,
            ],
            [
                'title'       => 'Loving the Sky',
                'category'    => 'wattpad',
                'description' => "How far would you go for someone? How many hailstorms and dark clouds would you endure? How many falling stars would you wait for to make a single wish come true?",
                'price'       => 175.00,
                'rating'      => 4.60,
                'is_active'   => true,
            ],

            // ── Manga ──────────────────────────────────────────────────
            [
                'title'       => 'One Piece Vol. 1',
                'category'    => 'manga',
                'description' => 'Follow Monkey D. Luffy and his pirate crew on an epic adventure to find the legendary treasure, the One Piece, and become King of the Pirates.',
                'price'       => 250.00,
                'rating'      => 5.00,
                'is_active'   => true,
            ],
            [
                'title'       => 'Demon Slayer Vol. 3',
                'category'    => 'manga',
                'description' => 'Tanjiro Kamado continues his quest to avenge his family and cure his sister Nezuko. The battle against demons grows fiercer with every chapter.',
                'price'       => 275.00,
                'rating'      => 4.90,
                'is_active'   => true,
            ],
            [
                'title'       => 'Jujutsu Kaisen Vol. 1',
                'category'    => 'manga',
                'description' => 'Yuji Itadori swallows a cursed finger and joins a secret organization of Jujutsu Sorcerers to eliminate a powerful Curse named Ryomen Sukuna.',
                'price'       => 260.00,
                'rating'      => 4.70,
                'is_active'   => true,
            ],
            [
                'title'       => 'My Hero Academia Vol. 2',
                'category'    => 'manga',
                'description' => 'Izuku Midoriya continues his journey at U.A. High School, training to become the world\'s greatest hero while facing increasingly powerful villains.',
                'price'       => 240.00,
                'rating'      => 4.60,
                'is_active'   => true,
            ],
            [
                'title'       => 'Attack on Titan Vol. 1',
                'category'    => 'manga',
                'description' => 'Humanity lives behind enormous walls to protect themselves from the Titans. When the walls are breached, young Eren Yeager vows to exterminate all Titans.',
                'price'       => 265.00,
                'rating'      => 4.95,
                'is_active'   => true,
            ],
            [
                'title'       => 'Chainsaw Man Vol. 1',
                'category'    => 'manga',
                'description' => 'Denji is a young man burdened with his father\'s debt. When he merges with his devil dog Pochita, he becomes Chainsaw Man — a Devil Hunter for the government.',
                'price'       => 255.00,
                'rating'      => 4.80,
                'is_active'   => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['title' => $product['title']],
                $product
            );
        }

        $this->command->info(count($products) . ' products seeded successfully.');
    }
}
