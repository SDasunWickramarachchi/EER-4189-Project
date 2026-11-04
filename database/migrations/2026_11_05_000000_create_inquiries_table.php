<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void 
    {
        Schema::create('inquiries', function(Blueprint $table){
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone')->nullable();
            $table->string('inquiry_type')->nullable();
            $table->string('message');
            $table->string('location')->nullable();
            $table->string('session_date')->nullable();
            $table->string('priority')->default('normal');
            $table->string('status')->default('new');
            $table->string('replied_at')->nullable();
            $table->string('history')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Cshema::dropIfExists('inquiries');
    }
};
