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
        Schema::table('users', function (Blueprint $table) {
            // Consent columns
            $table->boolean('usage_analytics_consent')->default(false)->after('deletion_requested_at');
            $table->boolean('location_data_consent')->default(false)->after('usage_analytics_consent');
            $table->boolean('marketing_consent')->default(false)->after('location_data_consent');
            $table->boolean('data_sharing_consent')->default(false)->after('marketing_consent');
            
            // Terms and privacy acceptance
            $table->boolean('privacy_policy_accepted')->default(false)->after('data_sharing_consent');
            $table->boolean('terms_accepted')->default(false)->after('privacy_policy_accepted');
            $table->timestamp('privacy_policy_accepted_at')->nullable()->after('terms_accepted');
            $table->timestamp('terms_accepted_at')->nullable()->after('privacy_policy_accepted_at');
            $table->timestamp('consent_updated_at')->nullable()->after('terms_accepted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'usage_analytics_consent',
                'location_data_consent',
                'marketing_consent',
                'data_sharing_consent',
                'privacy_policy_accepted',
                'terms_accepted',
                'privacy_policy_accepted_at',
                'terms_accepted_at',
                'consent_updated_at'
            ]);
        });
    }
};
