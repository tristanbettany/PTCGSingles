<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnHandCardsTable extends Migration
{
    public function up(): void
    {
        Schema::create('on_hand_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('released_card_version_id');
            $table->integer('quantity')->default(0);

            $table->foreign('released_card_version_id')
                ->references('id')
                ->on('released_card_versions');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('on_hand_cards');
    }
}
