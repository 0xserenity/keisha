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
        Schema::table('sneakers', function (Blueprint $table) {
            $table->unsignedTinyInteger('efficiency_socket')->default(0);
            $table->unsignedTinyInteger('luck_socket')->default(0);
            $table->unsignedTinyInteger('comfort_socket')->default(0);
            $table->unsignedTinyInteger('resilience_socket')->default(0);
            $table->unsignedBigInteger('efficiency_base')->default(0);
            $table->unsignedBigInteger('luck_base')->default(0);
            $table->unsignedBigInteger('comfort_base')->default(0);
            $table->unsignedBigInteger('resilience_base')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sneakers', function (Blueprint $table) {
            $table->dropColumn('efficiency_socket');
            $table->dropColumn('luck_socket');
            $table->dropColumn('comfort_socket');
            $table->dropColumn('resilience_socket');
            $table->dropColumn('efficiency_base');
            $table->dropColumn('luck_base');
            $table->dropColumn('comfort_base');
            $table->dropColumn('resilience_base');
        });
    }
};
