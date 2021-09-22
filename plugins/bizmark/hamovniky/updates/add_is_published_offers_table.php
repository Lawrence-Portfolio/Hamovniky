<?php namespace BizMark\Hamovniky\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddIsPublishedOffersTable extends Migration
{
    public function up()
    {
        Schema::table('bizmark_hamovniky_offers', function($table)
        {
            $table->boolean('is_published')->default(1);
        });
    }
    
    public function down()
    {
    }
}
