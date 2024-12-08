<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cron_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservations')->onDelete('cascade')->index();
            $table->string('tipo_actualizacion', 50);
            $table->string('estado_anterior', 50);
            $table->string('estado_nuevo', 50);
            $table->text('mensaje')->nullable();
            $table->timestamp('fecha_actualizacion');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cron_logs');
    }
}
