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
        $users = [
            [
                'name' => 'James Bird', 
                'email' => 'jbird@example.com',
                'password' => Hash::make('Password#1'),
                'admin' => true,
            ],
            [
                'name' => 'Administrator', 
                'email' => 'admin@example.com',
                'password' => Hash::make('Password#1'),
                'admin' => true,
            ],
            [
                'name' => 'Normal User 3', 
                'email' => 'user3@example.com',
                'password' => Hash::make('Password#1'),
                'admin' => false,
            ],
            [
                'name' => 'Normal User 4', 
                'email' => 'user4@example.com',
                'password' => Hash::make('Password#1'),
                'admin' => false,
            ],
            [
                'name' => 'Normal User 5', 
                'email' => 'user5@example.com',
                'password' => Hash::make('Password#1'),
                'admin' => false,
            ],
            [
                'name' => 'Normal User 6', 
                'email' => 'user6@example.com',
                'password' => Hash::make('Password#1'),
                'admin' => false,
            ],
        ];
    
        foreach ($users as $userData) {
            $user = User::factory()->create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);
    
            DB::table('user_infos')->insert([
                'user_id' => $user->id,
                'admin' => $userData['admin'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

