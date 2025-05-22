<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // auto-increment ID
            $table->enum('user_type', ['hod', 'staff', 'security']); // Enum for user types
            $table->string('department')->nullable(); // Nullable for non-HOD users
            $table->string('password'); // Password field
            $table->timestamps(); // Timestamps (created_at and updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
