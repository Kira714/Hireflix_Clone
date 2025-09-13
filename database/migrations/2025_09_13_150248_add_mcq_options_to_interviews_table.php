<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->json('mcq_options')->nullable()->after('question_types');
            $table->json('rating_labels')->nullable()->after('mcq_options');
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn(['mcq_options', 'rating_labels']);
        });
    }
};
