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
        Schema::create('chat_message', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();
            $table->bigInteger('message_index_id')->unsigned()->index();
            $table->bigInteger('uuid')->unsigned()->index();
            $table->bigInteger('to_uuid')->unsigned()->index();
            $table->text('content');
            $table->tinyInteger('is_read')->default(0);
            $table->bigInteger('delete_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_message');
    }
};
