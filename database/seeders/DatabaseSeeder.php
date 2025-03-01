<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        
                
        // DB::table('roles')->insert(
        //     array_map(fn() => [
        //         'name' => $faker->jobTitle,
        //         'guard_name' => 'web', 
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ], range(1, 10))
        // );


            // DB::table('users')->insert([
            //     'name' => $faker->name,
            //     'email' => $faker->unique()->safeEmail,
            //     'password' => bcrypt('password'), 
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);

        
        // DB::table('departments')->insert(
        //     array_map(fn() => [
        //         'name' => $faker->word,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ], range(1, 10))
        // );


        // DB::table('employees')->insert(
        //     array_map(fn() => [
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'phone' => $faker->phoneNumber,  
        //         'department_id' => rand(1, 10),  
        //         'job_title' => $faker->jobTitle, 
        //         'salary' => $faker->randomFloat(2, 3000, 10000),  
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ], range(1, 10)));


        // DB::table('contracts')->insert(
        //     array_map(fn() => [
        //         'employee_id' => rand(1, 10),
        //         'start_date' => $faker->date,
        //         'end_date' => $faker->date,
        //         'salary' => $faker->randomFloat(2, 3000, 10000),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ], range(1, 10))
        // );

        // DB::table('employee_progress')->insert(
        //     array_map(fn() => [
        //         'employee_id' => rand(1, 10),
        //         'type' => ['Promotion', 'Training', 'New Contract'][rand(0, 2)],  // Randomly choose a type
        //         'description' => $faker->sentence,
        //         'date' => $faker->date,  // Random date
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ], range(1, 10))
        // );        
}
}