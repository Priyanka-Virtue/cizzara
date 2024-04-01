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
        // Create the pivot table
Schema::create('plan_guru', function (Blueprint $table) {
    $table->unsignedBigInteger('plan_id');
    $table->unsignedBigInteger('guru_id');
    $table->timestamps();

    $table->primary(['plan_id', 'guru_id']);

    $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
    $table->foreign('guru_id')->references('id')->on('users')->onDelete('cascade');
});

// Update the plans table
// Schema::table('plans', function (Blueprint $table) {
//     $table->dropColumn('gurus');
// });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_guru');
        // Schema::table('plans', function (Blueprint $table) {
        //     $table->addColumn('text', 'gurus')->nullable();
        // });
    }
};
