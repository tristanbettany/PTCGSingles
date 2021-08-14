<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaritiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('rarities', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rarities');
    }
}
