<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ctl_productos', function (Blueprint $table) {
            //
            
            $table->id();
            $table->string('name');
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->boolean('activo')->default(true);
            

        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ctl_productos', function (Blueprint $table) {
            //
        });
    }
};
