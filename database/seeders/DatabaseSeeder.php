<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {        
        $this->call([
            UsersAdminSeeder::class,
            AcademyListSeeder::class,
            MarjorsSeeder::class,
            BlockAdminssionsSeeder::class,
            ConfigSemestersSeeder::class,
            CreateNationsSeeder::class,            
            EducationTypesSeeder::class,
            EmailTemplateTypeSeeder::class,            
            FormAdminssionsSeeder::class,
            LeadsStatusSeeder::class,
            MethodAdminssionsSeeder::class,
            PermissionSeeder::class,            
            RolesSeeder::class,
            SourcesSeeder::class,
            SupportsStatusSeeder::class,
            TagsSeeder::class,            
            TransactionStatusSeeder::class,
            TransactionTypeSeeder::class,
            LineVoipSeeder::class,
            // RolesPermissionSeeder::class
        ]);
    }
}
