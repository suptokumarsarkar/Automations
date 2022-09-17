<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZapRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zap_records', function (Blueprint $table) {
            $table->id();
            $table->text('zapId');
            $table->text('userId')->nullable();
            $table->text('triggerData')->nullable();
            $table->text('beforeActionData')->nullable();
            $table->text('ActionData')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zap_records');
    }
}
