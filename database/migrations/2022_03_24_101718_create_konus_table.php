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
        Schema::create('konus', function (Blueprint $table) {
            $table->id();
            $table->string('proje_baslik')->nullable();
            $table->text('proje_amac')->nullable();
            $table->text('proje_onem')->nullable();
            $table->text('proje_kapsam')->nullable();
            $table->string('proje_anahtar_kelimeler')->nullable();
            $table->text('proje_materyal')->nullable();
            $table->text('proje_yontem')->nullable();
            $table->text('proje_arastirma')->nullable();
            $table->string('konu_onay_durumu')->nullable();
            $table->text('red_nedeni')->nullable();
            $table->string('proje_durumu')->nullable();
            $table->foreignId('ogrenci_id')->nullable()->constrained('users')->cascadeOnUpdate();
            $table->foreignId('danisman_id')->constrained('users')->cascadeOnUpdate();
            $table->string('proje_yil');
            $table->string('proje_donem');
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
        Schema::dropIfExists('konus');
    }
};
