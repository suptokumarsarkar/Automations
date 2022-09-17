<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps_data', function (Blueprint $table) {
            $table->id();
            $table->text("AppId");
            $table->text("AppName");
            $table->text("AppDescription");
            $table->text("AppLogo");
            $table->text("AppInfo");
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
        Schema::dropIfExists('apps_data');
    }
}
