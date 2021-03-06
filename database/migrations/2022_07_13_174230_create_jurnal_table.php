<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jurnal', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('jurnal_id');
            $table->string('no_jurnal', 20);
            $table->string('kd_brg', 5);
            $table->string('nm_brg', 30);
            $table->integer('qty');
            $table->integer('subtotal');
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
        Schema::dropIfExists('detail_jurnal');
    }
}
