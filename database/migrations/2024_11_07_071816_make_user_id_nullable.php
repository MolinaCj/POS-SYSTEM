<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeUserIdNullable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->change();
        });
    }
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('employee_id')->nullable(false)->change();
        });
    }
}
