<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coach_id')->nullable();
            $table->foreign('coach_id')->references('id')->on('coaches')->onDelete('cascade');
            $table->unsignedBigInteger('club_id')->nullable();
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
            $table->string('licence_name');
            $table->string('issuing_authority');
            $table->date('issue_date');
            $table->date('expire_date')->nullable();
            $table->string('licence_img')->nullable();
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
        Schema::dropIfExists('licences');
    }
};
