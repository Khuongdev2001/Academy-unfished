<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_courses', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("desc");
            $table->unsignedBigInteger("course_id");
            $table->foreign("course_id")->references("id")->on("courses")->onDelete("cascade");
            $table->unsignedBigInteger("parent_id")->default(0);
            $table->enum("status", ["show", "hidden"]);
            $table->enum("view", ["pay", "free"]);
            $table->text("content");
            $table->enum("type_content", ["vimeo", "pdf"]);
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
        Schema::dropIfExists('product_courses');
    }
}
