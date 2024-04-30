<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('stripe_payment_id');
            $table->string('payment_gateway')->default('paypal')->after('plan_id');
            $table->string('payment_id')->unique()->after('payment_gateway');
            $table->string('status')->nullable()->after('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_gateway', 'payment_id', 'status']);
            $table->string('stripe_payment_id')->unique()->after('plan_id');
        });
    }
};
