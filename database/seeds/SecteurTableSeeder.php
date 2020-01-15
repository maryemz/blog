<?php

use Illuminate\Database\Seeder;

class SecteurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $secteurs =[   ['title'       => 'Banque / Assurance',
                        'description'  => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry \'s standard  dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book'
                        ],
                        ['title'       => 'Informatique / Télécoms',
                         'description'  => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don \'t look even slightly believable'
                        ],
                       ['title'       => 'Transports / Logistique',
                        'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old'
                        ],
                       ['title'       => 'Textile / Habillement / Chaussure',
                        'description' => 'It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
                       ],
                        ['title'         => 'Études et conseils',
                         'description'  => 'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum  will uncover many web sites still in their infancy.'
                       ],
                        ['title'          => 'Industrie pharmaceutique',
                         'description'   => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don \'t look even slightly believable. If you are going to use a passage of Lorem Ipsum'
                       ],
                    ];

        DB::table('secteurs')->insert($secteurs);

    }
}
