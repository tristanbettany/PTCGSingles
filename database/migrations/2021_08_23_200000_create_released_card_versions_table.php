<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleasedCardVersionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('released_card_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('released_card_id');
            $table->boolean('is_standard')->default(true);
            $table->boolean('is_reverse_holo')->default(false);
            $table->float('value')->nullable();
            $table->integer('quantity')->default(0);

            $table->foreign('released_card_id')
                ->references('id')
                ->on('released_cards');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('released_card_versions');
    }
}
