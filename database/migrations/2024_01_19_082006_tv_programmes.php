<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tv_programmes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('channel_id');
            $table->foreign('channel_id')
                ->references('channel_id')->on('channels')
                ->onDelete('cascade');
            $table->string('name', 100);
            $table->dateTime('begin_date_time')->default(NULL);
            $table->dateTime('end_date_time')->default(NULL);
            $table->index('begin_date_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('tv_programmes');
    }
};
