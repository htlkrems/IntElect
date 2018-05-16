<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {
    public function up() {
        Schema::create('user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id')->autoIncrement();
            $table->string('username', 45)->nullable($value = false)->unique();
            $table->string('password', 60)->nullable($value = false);
            $table->boolean('type')->nullable($value = false);
            $table->softDeletes();
            }
        );
    }

    public function down() {
        Schema::drop('user');
    }
}

?>
