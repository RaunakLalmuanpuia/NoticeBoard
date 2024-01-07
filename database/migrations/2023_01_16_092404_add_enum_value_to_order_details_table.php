<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddEnumValueToOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            DB::statement("ALTER TABLE order_details CHANGE COLUMN status status ENUM('Visited', 'Not Visited', 'Cancelled', 'Refunded', 'Checked Out')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            DB::statement("ALTER TABLE order_details CHANGE COLUMN status status ENUM('Visited', 'Not Visited', 'Cancelled', 'Refunded')");
        });
    }
}
