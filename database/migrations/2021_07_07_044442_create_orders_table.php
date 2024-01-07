<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->string('order_id')->nullable();
      $table->string('tracking_id')->nullable();
      $table->string('bank_ref_no')->nullable();
      $table->string('order_status')->nullable();
      $table->string('payment_mode')->nullable();
      $table->string('card_name')->nullable();
      $table->string('currency')->nullable();
      $table->string('amount')->nullable();
      $table->string('billing_name')->nullable();
      $table->string('discount_value')->nullable();
      $table->string('mer_amount')->nullable();
      $table->string('billing_notes')->nullable();
      $table->string('trans_date')->nullable();
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
    Schema::dropIfExists('orders');
  }
}
