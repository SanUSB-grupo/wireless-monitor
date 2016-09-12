<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPhotoresistorMonitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('monitor_packages')->insert([
            'path' => 'photoresistor',
            'description' => 'Photoresistor',
            'icon' => 'photoresistor',
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
            ->where('path', '=', 'photoresistor')
            ->delete();
    }
}
