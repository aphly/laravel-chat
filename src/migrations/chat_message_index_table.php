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
        Schema::create('chat_message_index', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uuid')->unsigned()->index();
            $table->string('min_max',41)->index();
            $table->text('last_author');
            $table->text('last_message');
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_message_index');
    }
};
