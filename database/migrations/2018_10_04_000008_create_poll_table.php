<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollTable extends Migration {
    public function up() {
        Schema::create('poll', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->string('token', 10)->nullable($value = false);
            $table->string('title', 45)->nullable($value = false);
            $table->text('description')->nullable($value = true);
            $table->dateTime('begin')->nullable($value = false);
            $table->datetime('end')->nullable($value = false);
            $table->unsignedInteger('max_participants')->nullable($value = false);
            $table->unsignedInteger('current_participants')->nullable($value = false)->default(0);
	    $table->primary('token');
            $table->unsignedInteger('user_id')->nullable($value = false);
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('poll');
    }
}

?>
