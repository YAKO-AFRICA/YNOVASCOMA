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
        Schema::table('tbladherent', function (Blueprint $table) {
             $table->enum('situationMatrimoniale', [
                'celibataire',
                'marie',
                'divorce',
                'veuf',
                'separe',
                'union_libre',
                'pacs'
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbladherent', function (Blueprint $table) {
            //
        });
    }
};
