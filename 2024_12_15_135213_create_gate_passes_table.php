<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatePassesTable extends Migration
{
    public function up()
    {
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->text('rollnos'); // Single or multiple roll numbers (comma-separated)
            $table->text('names');  // Single or multiple names (comma-separated)
            $table->string('department');
            $table->text('reason');
            $table->string('timing');
            $table->string('status')->default('waiting'); // Status column
            $table->text('info')->nullable(); // Add info column (nullable to allow no value initially)
            $table->timestamps(); // Automatically adds created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('gate_passes');
    }
}
