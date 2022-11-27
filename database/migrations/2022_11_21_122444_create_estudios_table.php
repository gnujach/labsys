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
        Schema::create('estudios', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('nombre')->nullable(false);
            $table->string('clave')->nullable(false);
            $table->decimal('precio_mostrador')->nullable(false);
            $table->decimal('precio_preferencial')->nullable(true)->default(0);
            $table->decimal('costo')->nullable(true)->default(0);
            $table->decimal('ganancia')->nullable(false)->default(0);
            $table->foreignId('tipoventa_id');
            $table->foreignId('grupo_id');
            $table->foreignId('categoria_id');
            $table->foreignId('corte_id')->default(1);
            $table->unsignedSmallInteger('by')->nullable(false);
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('estudios');
    }
};
