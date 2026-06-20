<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Tablas Maestras
        $this->call('UsersSeeder');
        $this->call('HealthConditionsSeeder');
        $this->call('IngredientsSeeder');
        $this->call('RecipesSeeder');

        // 2. Tablas Dependientes
        $this->call('HealthProfilesSeeder');
        $this->call('MealLogsSeeder');
        $this->call('PostsSeeder'); // Corregido a PostsSeeder (antes decía PostSeeder)

        // 3. Tablas Pivote
        $this->call('UserConditionsSeeder');
        $this->call('IngredientConditionsSeeder');
        $this->call('RecipeIngredientsSeeder');
        $this->call('RecipeConditionsSeeder');
        $this->call('UserPantriesSeeder');
    }
}