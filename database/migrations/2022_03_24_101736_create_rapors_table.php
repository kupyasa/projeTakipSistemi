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
        Schema::create('rapors', function (Blueprint $table) {
            $table->id();
            $table->string('rapor_dosya_yolu')->nullable();
            $table->string('rapor_sayi_turu')->nullable();
            $table->string('rapor_gorulme_durumu')->nullable();
            $table->string('rapor_onay_durumu')->nullable();
            $table->string('proje_durumu')->nullable();
            $table->foreignId('ogrenci_id')->constrained('users')->cascadeOnUpdate();
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
        Schema::dropIfExists('rapors');
    }
};
