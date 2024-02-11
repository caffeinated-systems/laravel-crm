<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterLeadPipelineStagesTableTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_pipeline_stages', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('lead_pipeline_stages_lead_stage_id_foreign');
            }

            $table->dropColumn('lead_stage_id');

            $table->unique(['code', 'lead_pipeline_id']);
            $table->unique(['name', 'lead_pipeline_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_pipeline_stages', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('name');

            $table->integer('lead_stage_id')->unsigned();
            $table->foreign('lead_stage_id')->references('id')->on('lead_stages')->onDelete('cascade');

            $table->dropUnique(['lead_pipeline_stages_code_lead_pipeline_id_unique', 'lead_pipeline_stages_name_lead_pipeline_id_unique']);
        });
    }
}
