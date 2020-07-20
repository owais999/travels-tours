<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFrom170To180 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_flight_translations', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale', 10)->nullable();

            //Flight info
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->charset('utf8')->index();
            $table->text('content')->nullable();
            $table->text('short_desc')->nullable();
            $table->string('address', 255)->nullable();
            $table->text('faqs')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });
        Schema::create('bravo_flight_category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale', 10)->nullable();

            $table->string('name', 255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
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
        Schema::table('bravo_flight_translations', function (Blueprint $table) {
            //
        });
        Schema::dropIfExists('bravo_flight_category_translations');
    }
}
