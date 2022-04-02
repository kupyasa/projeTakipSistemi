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
        Schema::create('benzer_konus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yeni_proje_id')->constrained('konus')->cascadeOnUpdate();
            $table->foreignId('eski_proje_id')->constrained('konus')->cascadeOnUpdate();
            $table->foreignId('yeni_ogrenci_id')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('yeni_danisman_id')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('eski_ogrenci_id')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('eski_danisman_id')->constrained('users')->cascadeOnUpdate();
            $table->string('yil');
            $table->string('donem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benzer_konus');
    }
};
