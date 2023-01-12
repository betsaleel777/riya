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
        Schema::create('appartements', function (Blueprint $table) {
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
            $table->boolean('cour_commune')->default(false);
            $table->boolean('placard')->default(false);
            $table->boolean('etage')->default(false);
            $table->boolean('toilette')->default(false);
            $table->boolean('cuisine')->default(false);
            $table->boolean('garage')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('cie')->default(false);
            $table->boolean('sodeci')->default(false);
            $table->boolean('cloture')->default(false);
            $table->longText('observation');
            $table->foreignId('type_appartement_id')->constrained('type_appartements')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appartements');
    }
};
