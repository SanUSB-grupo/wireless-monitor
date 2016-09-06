<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonitorPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitor_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path')->unique();
            $table->string('description');
            $table->string('icon');
            $table->boolean('enabled');
            $table->timestamps();
        });

        // TODO: move to migration packages!
        DB::table('monitor_packages')->insert([
            'path' => 'temperature',
            'description' => 'Temperature',
            'icon' => 'dashboard',
            'enabled' => true,
            'created_at' => 'now()',
            'updated_at' => 'now()',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('monitor_packages')
            ->where('path', '=', 'temperature')
            ->delete();

        Schema::drop('monitor_packages');
    }
}
