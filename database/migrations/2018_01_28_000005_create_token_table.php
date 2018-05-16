<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenTable extends Migration {
    public function up() {
        Schema::create('token', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->string('token', 45)->nullable($value = false);
            $table->boolean('already_used')->nullable($value = false);
            $table->boolean('valid_vote')->nullable($value = false)->default(0);
            $table->unsignedInteger('election_group_id')->nullable($value = false);
            $table->unsignedInteger('election_id')->nullable($value = false);
            $table->primary('token');
            $table->foreign('election_group_id')->references('id')->on('election_group')->onDelete('cascade');
            $table->foreign('election_id')->references('id')->on('election')->onDelete('cascade');
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('token');
    }
}

?>
