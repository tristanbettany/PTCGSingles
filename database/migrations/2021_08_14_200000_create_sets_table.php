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
            $table->unsignedBigInteger('series_id');
            $table->dateTime('release_date')->nullable();
            $table->integer('base_card_count')->default(0);
            $table->integer('secret_card_count')->default(0);
            $table->string('symbol')->nullable();
            $table->string('logo')->nullable();
            $table->string('data_source_url');

            $table->foreign('series_id')
                ->references('id')
                ->on('series');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sets');
    }
}
