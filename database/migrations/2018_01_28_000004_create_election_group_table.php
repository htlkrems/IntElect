<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionGroupTable extends Migration {
    public function up() {
        Schema::create('election_group', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id');
            $table->string('name', 45)->nullable($value = false);
            $table->unsignedInteger('member_count')->nullable($value = false);
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('election_group');
    }
}

?>
