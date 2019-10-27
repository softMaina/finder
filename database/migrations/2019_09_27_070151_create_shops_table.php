<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 255);
            $table->text('description');
            $table->unsignedBigInteger('shop_location_id');
            $table->foreign('shop_location_id')->references('id')->on('shop_locations')->onDelete('cascade');
            $table->unsignedBigInteger('shop_size_id');
            $table->foreign('shop_size_id')->references('id')->on('shop_sizes')->onDelete('cascade');
            $table->unsignedBigInteger('shop_status_id');
            $table->foreign('shop_status_id')->references('id')->on('shop_statuses')->onDelete('cascade');
            $table->unsignedInteger('shop_type_id');
            $table->foreign('shop_type_id')->references('id')->on('property_types')->onDelete('cascade');
            $table->float('price')->default(0.00);
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
        Schema::dropIfExists('shops');
    }
}
