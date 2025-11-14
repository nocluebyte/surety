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
        Schema::rename('rating_agencies', 'agencies');
        Schema::rename('ratings', 'agency_ratings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('agencies', 'rating_agencies');
        Schema::rename('agency_ratings', 'ratings');
    }
};
