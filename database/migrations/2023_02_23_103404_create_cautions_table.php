<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cautions', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('nombre_mois');
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->morphs('possedable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cautions');
    }
};
