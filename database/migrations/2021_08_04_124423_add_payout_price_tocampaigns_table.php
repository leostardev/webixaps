<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayoutPriceToCampaignsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table(
      'campaigns',
      function (Blueprint $table) {
        $table->string('payout_price')->nullable();
      }
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table(
      'campaigns',
      function (Blueprint $table) {
        $table->dropColumn('payout_price');
      }
    );
  }
}
