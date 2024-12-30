<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class ApproverSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $now = Carbon::now();

        // User ID 01 can approve users 03, 04, 05, 06
        $user01 = User::find(1);
        $user01->approvals()->attach([
            3 => ['created_at' => $now, 'updated_at' => $now],
            4 => ['created_at' => $now, 'updated_at' => $now],
            5 => ['created_at' => $now, 'updated_at' => $now],
            6 => ['created_at' => $now, 'updated_at' => $now],
        ]);

        // User ID 03 can approve user 06
        $user03 = User::find(3);
        $user03->approvals()->attach([
            6 => ['created_at' => $now, 'updated_at' => $now],
        ]);

        // User ID 04 can approve users 05, 06
        $user04 = User::find(4);
        $user04->approvals()->attach([
            5 => ['created_at' => $now, 'updated_at' => $now],
            6 => ['created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('Approver relationships with timestamps have been seeded!');
    }
}