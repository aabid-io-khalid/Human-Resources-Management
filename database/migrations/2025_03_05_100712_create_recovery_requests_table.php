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
    Schema::create('recovery_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');  
        $table->date('recovery_date');
        $table->integer('hours_worked'); 
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('reason')->nullable();
        $table->foreignId('hr_id')->nullable()->constrained('employees'); 
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recovery_requests');
    }
};
