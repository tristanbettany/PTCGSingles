<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetsTable extends Migration
{
    public function up(): void
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('release_date');
            $table->integer('base_card_count');
            $table->integer('secret_card_count');
            $table->string('symbol')->nullable();
            $table->string('logo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sets');
    }
}
