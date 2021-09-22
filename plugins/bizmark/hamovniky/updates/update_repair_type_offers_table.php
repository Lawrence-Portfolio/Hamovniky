<?php namespace BizMark\Hamovniky\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateRepairTypeOffersTable extends Migration
{
    public function up()
    {
        Schema::table('bizmark_hamovniky_offers', function ($table) {
            $table->dropColumn('repairs_type');
        });
    }
    public function down()
    {
    }
}
