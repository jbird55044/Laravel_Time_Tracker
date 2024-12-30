<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // The user who needs approval
            $table->unsignedBigInteger('approver_id'); // The approver
            
            // Add foreign key constraints
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Deletes approvals if the user is deleted

            $table->foreign('approver_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Deletes approvals if the approver is deleted
            
            // Prevent duplicate relationships
            $table->unique(['user_id', 'approver_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvers');
    }
};