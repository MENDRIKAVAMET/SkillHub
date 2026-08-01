<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'Laravel', 'description' => 'Framework PHP pour applications modernes'],
            ['name' => 'PHP', 'description' => 'Langage de programmation back-end'],
            ['name' => 'Java', 'description' => 'Langage orienté objet et plateforme JVM'],
            ['name' => 'Python', 'description' => 'Langage polyvalent de programmation'],
            ['name' => 'JavaScript', 'description' => 'Langage de programmation front-end'],
            ['name' => 'HTML', 'description' => 'Langage de structuration de contenu web'],
            ['name' => 'CSS', 'description' => 'Langage de mise en forme web'],
            ['name' => 'Excel', 'description' => 'Tableur et automatisation de données'],
            ['name' => 'Photoshop', 'description' => 'Édition et retouche d’images'],
            ['name' => 'Illustrator', 'description' => 'Création vectorielle et design'],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['name' => $skill['name']],
                ['description' => $skill['description']]
            );
        }
    }
}
