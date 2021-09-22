<?php namespace BizMark\Hamovniky\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('bizmark_hamovniky_properties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bizmark_hamovniky_properties');
    }
}
