<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zaps', function (Blueprint $table) {
            $table->id();
            $table->text("userId")->nullable();
            $table->text("status")->default('active')->nullable();
            $table->text("zapData")->default('[]')->nullable();
            $table->text("database")->default('[]')->nullable();
            $table->text("func")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zaps');
    }
}
