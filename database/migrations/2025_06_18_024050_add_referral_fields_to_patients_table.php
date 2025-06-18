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
        Schema::table('patients', function (Blueprint $table) {
            $table->date('referral_date')->nullable();
            $table->string('referral_professional')->nullable();
            $table->string('referral_specialty')->nullable();
            $table->string('referral_institution')->nullable();
            $table->text('referral_reason')->nullable();
            $table->date('referral_return_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'referral_date',
                'referral_professional',
                'referral_specialty',
                'referral_institution',
                'referral_reason',
                'referral_return_date'
            ]);
        });
    }
};
