<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatchOfActionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeal_actions', function($table)
        {
            $table->dropUnique('appeal_actions_operator_u_id_unique');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::tablbe('appeal_actions', function($table)
        {
            $table->unique('operator_u_id');
        });
    }

}
