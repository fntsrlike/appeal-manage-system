<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFormToCase extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeal_forms', function($table)
        {
             $table->renameColumn('f_id'        , 'case_id');
             $table->renameColumn('f_title'     , 'case_title');
             $table->renameColumn('f_date'      , 'case_date');
             $table->renameColumn('f_place'     , 'case_place');
             $table->renameColumn('f_target'    , 'case_target');
             $table->renameColumn('f_content'   , 'case_content');
             $table->renameColumn('f_report'    , 'case_report');
             $table->renameColumn('f_status'    , 'case_status');
             $table->renameColumn('f_privacy'   , 'case_privacy');
        });

        Schema::rename('appeal_forms', 'appeal_cases');

        Schema::table('appeal_replies', function($table)
        {
             $table->renameColumn('f_id', 'case_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appeal_cases', function($table)
        {
             $table->renameColumn('case_id'        , 'f_id');
             $table->renameColumn('case_title'     , 'f_title');
             $table->renameColumn('case_date'      , 'f_date');
             $table->renameColumn('case_place'     , 'f_place');
             $table->renameColumn('case_target'    , 'f_target');
             $table->renameColumn('case_content'   , 'f_content');
             $table->renameColumn('case_report'    , 'f_report');
             $table->renameColumn('case_status'    , 'f_status');
             $table->renameColumn('case_privacy'   , 'f_privacy');
        });

        Schema::rename('appeal_cases', 'appeal_forms');

        Schema::table('appeal_replies', function($table)
        {
             $table->renameColumn('case_id', 'f_id');
        });
    }

}
