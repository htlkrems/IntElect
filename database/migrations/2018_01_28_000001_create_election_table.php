<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionTable extends Migration {
    public function up() {
        Schema::create('election', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id');
            $table->string('name', 45)->nullable($value = false);
            $table->text('description')->nullable($value = true);
            $table->boolean('type')->nullable($value = false);
            $table->dateTime('candidate_registration_begin')->nullable($value = true);
            $table->dateTime('candidate_registragion_end')->nullable($value = true);
            $table->dateTime('election_begin')->nullable($value = true);
            $table->dateTime('election_end')->nullable($value = true);
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('election');
    }
}

?>
