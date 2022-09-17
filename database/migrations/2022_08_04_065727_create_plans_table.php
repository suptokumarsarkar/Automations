<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("type");
            $table->text("description");
            $table->text("price");
            $table->text("taskPerMonth");
            $table->text("maxConnections");
            $table->text("taskTime");
            $table->text("multiZaps")->nullable();
            $table->text("premiumApps")->nullable();
            $table->text("webHooks")->nullable();
            $table->text("logics")->nullable();
            $table->text("autoReply")->nullable();
            $table->text("premiumSupport")->nullable();
            $table->text("sharedAppConnection")->nullable();
            $table->text("sharedAccountConnection")->nullable();
            $table->text("folderPermission")->nullable();
            $table->text("formatters")->nullable();
            $table->text("filters")->nullable();
            $table->text("advancedAdminPermission")->nullable();
            $table->text("appsRestrictions")->nullable();
            $table->text("customDataRetention")->nullable();
            $table->text("userProvisioning")->nullable();
            $table->text("transferBeta")->nullable();
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
        Schema::dropIfExists('plans');
    }
}
