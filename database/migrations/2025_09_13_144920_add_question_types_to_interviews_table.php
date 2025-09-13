<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->json('question_types')->nullable()->after('questions');
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('question_types');
        });
    }
};
