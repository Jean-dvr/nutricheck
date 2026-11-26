<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tablas Maestras
        $this->call('UsersSeeder');
        $this->call('HealthConditionsSeeder');
        $this->call('IngredientsSeeder');
        $this->call('RecipesSeeder');
        $this->call('TagsSeeder');
        $this->call('BannersSeeder');

        // Tablas Dependientes
        $this->call('HealthProfilesSeeder');
        $this->call('MealLogsSeeder');
        $this->call('PostsSeeder');

        // Tablas Pivote
        $this->call('UserConditionsSeeder');
        $this->call('IngredientConditionsSeeder');
        $this->call('RecipeIngredientsSeeder');
        $this->call('RecipeConditionsSeeder');
        $this->call('RecipeTagsSeeder');
        $this->call('UserPantriesSeeder');
    }
}