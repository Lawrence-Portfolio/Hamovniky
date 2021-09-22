<?php namespace BizMark\Hamovniky\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOffersTable extends Migration
{
    public function up()
    {
        Schema::create('bizmark_hamovniky_offers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->enum('type', ['APARTMENT', 'ESTATE', 'COMMERCIAL'])->index();
            $table->enum('ad_type', ['RENT', 'SALE'])->index();
            $table->enum('flat_type', ['FLAT', 'ROOM', 'STUDIO', 'APARTS', 'CONDOMIN'])->nullable();
            $table->enum('house_type', ['HOUSE', 'PART_HOUSE', 'COUNTRY', 'COTTAGE', 'TOWNHOUSE', 'PLOT'])->nullable();
            $table->enum('commercial_type', ['OFFICE', 'BUILDING', 'SALES_AREA', 'FREE_SQUARE', 'PRODUCTION', 'STOCK', 'READY_BUSINESS', 'GARAGE'])->nullable()->index();
            $table->enum('repairs_type', ['WITHOUT', 'COSMETIC', 'EURO', 'DESIGN'])->nullable();
            $table->enum('bath_type', ['BATH', 'SHOWER', 'BATH&SHOWER'])->nullable();

            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('mkad_address')->nullable();
            $table->decimal('longitude', 11, 6);
            $table->decimal('latitude', 10, 6);

            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('price_per_square', 15, 2)->nullable();
            $table->integer('area_size')->nullable();
            $table->integer('living_size')->nullable();
            $table->integer('rooms')->default(1);
            $table->integer('floor')->default(1);
            $table->integer('max_floor')->default(1);

            $table->text('lead_properties')->nullable();
            $table->text('common_properties')->nullable();
            $table->text('house_properties')->nullable();

            $table->boolean('is_top_floor')->default(0);
            $table->boolean('with_furniture')->default(0);
            $table->boolean('with_parking')->default(0);
            $table->boolean('with_pets')->default(0);
            $table->boolean('with_children')->default(0);
            $table->boolean('with_elevator')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bizmark_hamovniky_offers');
    }
}
