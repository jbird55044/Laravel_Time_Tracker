<?php

// /database/migrations/xxxx_xx_xx_xxxxxx_create_approver_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approver_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // The user who needs approval
            $table->unsignedBigInteger('approver_id'); // The approver
            
            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
            
            // Prevent duplicate relationships
            $table->unique(['user_id', 'approver_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approver_user');
    }
};
