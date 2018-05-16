<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionElectionGroupTable extends Migration {
    public function up() {
        Schema::create('election_election_group', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->integer('election_id')->unsigned();
            $table->integer('election_group_id')->unsigned();
            $table->primary(['election_id', 'election_group_id']);
            $table->foreign('election_id')->references('id')->on('election')->onDelete('cascade');
            $table->foreign('election_group_id')->references('id')->on('election_group')->onDelete('cascade');
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('election_election_group');
    }
}

?>
