<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoMetaDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_meta_datas', function (Blueprint $table) {
            $table->id();
            $table->text('slug');
            $table->text('title');
            $table->text('description');
            $table->text('author');
            $table->text('keywords');
            $table->text('type');
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
        Schema::dropIfExists('seo_meta_datas');
    }
}
