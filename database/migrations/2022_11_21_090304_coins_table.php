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
        Schema::create('coins', function (Blueprint $table) {
           $table->id();
           $table->bigInteger('user_id')->index()->nullable();
           $table->integer('quantity');
           $table->enum('type',  ['buy', 'follower', 'following'])->default('buy');
           $table->timestamp();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
