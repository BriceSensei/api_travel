<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('destinations', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->text('description');
        $table->string('image');
        $table->string('emplacement');
        $table->decimal('prix', 10, 2);
        $table->decimal('lat', 10, 7);
        $table->decimal('lng', 10, 7);
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
    Schema::dropIfExists('destinations');
}

}
