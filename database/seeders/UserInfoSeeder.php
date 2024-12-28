<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_infos')->insert([
            'user_id' => User::factory()->create([
                'name' => 'James Bird', 
                'email' => 'jbird.m1@jamesdbird.com',
                'password'=> Hash::make('Password#1')
            ])->id,
            'admin' => false,
            'created_at' => date('Y/m/d H:i:s'),
            'updated_at' => date('Y/m/d H:i:s'),
        ]);

        DB::table('user_infos')->insert([
            'user_id' => User::factory()->create([
                'name' => 'Normal User 2', 
                'email' => 'user2@example.com',
                'password'=> Hash::make('Password#1')
            ])->id,
            'admin' => false,
            'created_at' => date('Y/m/d H:i:s'),
            'updated_at' => date('Y/m/d H:i:s'),
        ]);

        DB::table('user_infos')->insert([
            'user_id' => User::factory()->create([
                'name' => 'Administrator', 
                'email' => 'admin@example.com',
                'password'=> Hash::make('Password#1')
            ])->id,
            'admin' => true,
            'created_at' => date('Y/m/d H:i:s'),
            'updated_at' => date('Y/m/d H:i:s'),
        ]); 
    }   
}
