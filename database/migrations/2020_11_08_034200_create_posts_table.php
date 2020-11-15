<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("desc");
            $table->text("content");
            $table->unsignedBigInteger("cat_id");
            $table->foreign("cat_id")->references("id")->on("cat_posts")->onDelete("cascade");
            $table->unsignedBigInteger("creator");
            $table->foreign("creator")->references("id")->on("users")->onDelete("cascade");
            $table->text("thumbnail")->nullable();
            $table->unsignedBigInteger("sort")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
