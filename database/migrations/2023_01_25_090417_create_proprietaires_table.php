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
        Schema::create('proprietaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet');
            $table->string('telephone', 20)->unique();
            $table->string('email', 255)->unique();
            $table->string('cni', 15)->unique();
            $table->unsignedTinyInteger('commission_terrain');
            $table->unsignedTinyInteger('commission_appartement');
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
        Schema::dropIfExists('proprietaires');
    }
};
