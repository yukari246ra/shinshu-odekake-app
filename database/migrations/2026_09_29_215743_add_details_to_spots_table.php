<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->string('business_hours')->nullable();
            $table->string('closed_days')->nullable();
            $table->string('phone')->nullable();
            $table->string('parking')->nullable();
            $table->string('website_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropColumn([
                'business_hours',
                'closed_days',
                'phone',
                'parking',
                'website_url',
            ]);
        });
    }
};
