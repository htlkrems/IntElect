<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteTable extends Migration {
    public function up() {
        Schema::create('vote', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->tinyInteger('points')->nullable($value = false);
            $table->unsignedInteger('election_group_id')->nullable($value = false);
            $table->unsignedInteger('candidate_id')->nullable($value = false);
            $table->foreign('election_group_id')->references('id')->on('election_group')->onDelete('cascade');
            $table->foreign('candidate_id')->references('id')->on('candidate')->onDelete('cascade');
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('vote');
    }
}

?>
