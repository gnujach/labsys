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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('nombre')->nullable(false);
            $table->string('ap1')->nullable(true);
            $table->string('ap2')->nullable(true);
            $table->string('tel')->nullable(false);
            $table->string('correo')->nullable(false);
            $table->unsignedSmallInteger('edad')->nullable(true);
            $table->enum('genero', ['Másculino', 'Femenino'])->nullable(false);
            $table->string('direccion')->nullable(true);
            $table->boolean('activo')->default(true);
            $table->BigInteger('by')->nullable(true);
            $table->softDeletes();
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
        Schema::dropIfExists('pacientes');
    }
};
