<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->enum('hr_approval', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            $table->enum('manager_approval', ['pending', 'approved', 'rejected'])->default('pending')->after('hr_approval');
        });
    }

    public function down()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn(['hr_approval', 'manager_approval']);
        });
    }

};
