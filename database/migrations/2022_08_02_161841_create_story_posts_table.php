<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_posts', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug');
            $table->text('categoryIds');
            $table->text('sortDescription');
            $table->longText('longDescription');
            $table->text('thumbnail');
            $table->text('postAddedBy');
            $table->text('view');
            $table->text('likes');
            $table->text('tags');
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
        Schema::dropIfExists('story_posts');
    }
}
