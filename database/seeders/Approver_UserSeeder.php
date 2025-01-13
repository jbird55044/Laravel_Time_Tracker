<?php

// /database/seeders/ApproverSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class Approver_UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // User ID 01 can be approved by users 05
        $user01 = User::find(1);
        $user01->approvers()->attach([
            4 => ['created_at' => $now, 'updated_at' => $now],
            5 => ['created_at' => $now, 'updated_at' => $now],
            6 => ['created_at' => $now, 'updated_at' => $now],
        ]);

         // User ID 02 can be approved by users 05
         $user02 = User::find(2);
         $user02->approvers()->attach([
             5 => ['created_at' => $now, 'updated_at' => $now],
        ]);
 
        
        // User ID 03 can approve user 01
        $user03 = User::find(3);
        $user03->approvers()->attach([
            5 => ['created_at' => $now, 'updated_at' => $now],
        ]);

        // User ID 04 can approve users 01
        $user04 = User::find(4);
        $user04->approvers()->attach([
            5 => ['created_at' => $now, 'updated_at' => $now],
        ]);

        // User ID 05 can approve users 01, 06
        $user05 = User::find(5);
        $user05->approvers()->attach([
            6 => ['created_at' => $now, 'updated_at' => $now],
        ]);

          // User ID 06 can approve users 01, 06
          $user06 = User::find(6);
          $user06->approvers()->attach([
              1 => ['created_at' => $now, 'updated_at' => $now],
              3 => ['created_at' => $now, 'updated_at' => $now],
          ]);

        $this->command->info('Approver relationships with timestamps have been seeded!');
    }
}
