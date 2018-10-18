<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionTable extends Migration {
    public function up() {
        Schema::create('poll', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id');
            $table->string('text', 120)->nullable($value = false);
            $table->string('poll_token', 10)->nullable($value = false);
            $table->foreign('poll_token')->references('token')->on('poll')->onDelete('cascade');
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('option');
    }
}

?>
