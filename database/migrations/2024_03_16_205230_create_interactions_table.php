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
        Schema::connection('mongodb')->create('interactions', function (Blueprint $table) {
            $table->index('id');
            $table->unsignedBigInteger('user_id');
            $table->string('route');
            $table->string('interaction_type');
            $table->string('interaction_query');
            $table->date('interaction_date');
            $table->time('interaction_time');
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
        Schema::connection('mongodb')->dropIfExists('interactions');
    }
};
