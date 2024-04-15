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
        Schema::table('auditions', function (Blueprint $table) {
            $table->enum('status', config('app.audition_status'))->default('pending')->after('plan_id');
            $table->enum('state', config('app.audition_status'))->default('pending')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auditions', function (Blueprint $table) {
            $table->removeColumn('status');
            $table->removeColumn('state');
        });
    }
};
