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
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 10)->unique();
            $table->string('nom', 190);
            $table->unsignedInteger('superficie');
            $table->unsignedInteger('montant_location');
            $table->unsignedInteger('montant_investit');
            $table->string('pays', 50);
            $table->string('ville', 50);
            $table->string('quartier', 70);
            $table->string('proprietaire', 190);
            $table->boolean('attestation_villageoise')->default(false);
            $table->boolean('titre_foncier')->default(false);
            $table->boolean('document_cession')->default(false);
            $table->boolean('arreter_approbation')->default(false);
            $table->foreignId('type_terrain_id')->constrained('type_terrains')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('terrains');
    }
};
