<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInHandCardsTable extends Migration
{
    public function up(): void
    {
        Schema::create('in_hand_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('released_card_id');
            $table->integer('quantity');
            $table->integer('tradeable_quantity');

            $table->foreign('released_card_id')
                ->references('id')
                ->on('released_cards');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('in_hand_cards');
    }
}
