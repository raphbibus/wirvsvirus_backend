<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndicesToInoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inouts', function (Blueprint $table) {
            $table->index('entered');
            $table->index('left');
            $table->index('token');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inouts', function (Blueprint $table) {
            $table->dropIndex('inouts_entered_index');
            $table->dropIndex('inouts_left_index');
            $table->dropIndex('inouts_token_index');
            $table->dropIndex('inouts_created_at_index');
        });
    }
}
