<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrderedItems extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('ordered_items', function (Blueprint $table) {
      $table->string('expected_arrival')->nullable();
      $table->string('no_of_children')->nullable();
      $table->string('no_of_adult')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('ordered_items', function (Blueprint $table) {
      //
    });
  }
}
