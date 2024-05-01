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
            $table->text('contract')->nullable();
            $table->text('rolemodel')->nullable();
            $table->text('group_together')->nullable();
            $table->text('how_long_group_together')->nullable();
            $table->text('members')->nullable();
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
            $table->dropColumn(['contract', 'rolemodel', 'group_together', 'how_long_group_together', 'members']);
        });
    }
};
