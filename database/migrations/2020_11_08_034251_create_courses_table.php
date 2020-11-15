<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("thumbnail");
            $table->unsignedBigInteger("parent_id")->default(0);
            $table->string("price", 200);
            $table->string("price_old", 200)->nullable();
            $table->unsignedBigInteger("cat_id");
            $table->string("time_end")->nullable();
            $table->foreign("cat_id")->references("id")->on("cat_courses")->onDelete("cascade");
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
        Schema::dropIfExists('courses');
    }
}
