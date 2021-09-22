<?php namespace BizMark\Hamovniky\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddTypicalRepairOffersTable extends Migration
{
    public function up()
    {
        Schema::table('bizmark_hamovniky_offers', function ($table) {
            $table->enum('repairs_type', ['WITHOUT', 'COSMETIC', 'EURO', 'DESIGN', 'TYPICAL'])->nullable();
        });
    }
}
