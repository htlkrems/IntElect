<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateTable extends Migration {
    public function up() {
        Schema::create('candidate', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id');
            $table->string('name', 45)->nullable($value = false);
            $table->string('party', 45)->nullable($value = true);
            $table->string('picture')->nullable($value = true);
            $table->text('description')->nullable($value = false);
            $table->boolean('verified')->nullable($value = false);
            $table->unsignedInteger('election_id')->nullable($value = false);
            $table->foreign('election_id')->references('id')->on('election')->onDelete('cascade');
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('candidate');
    }
}

?>