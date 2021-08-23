<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleasedCardsTable extends Migration
{
    public function up(): void
    {
        Schema::create('released_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('set_id');
            $table->unsignedBigInteger('rarity_id');
            $table->string('name');
            $table->string('number');
            $table->string('image')->nullable();
            $table->string('data_source_url');

            $table->foreign('set_id')
                ->references('id')
                ->on('sets');

            $table->foreign('rarity_id')
                ->references('id')
                ->on('rarities');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('released_cards');
    }
}
