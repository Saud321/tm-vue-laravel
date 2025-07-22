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
        Schema::create('tasks', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('user_id');

            $table->string('title');
            $table->string('description');
            $table->date('deadline');
            $table->enum('status', ['pending', 'in-progress', 'completed', 'over-due'])
                ->default('pending');
            $table->enum('category', [ 'personal','work','low','medium', 'high', 'urgent'])
                ->default('low');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
