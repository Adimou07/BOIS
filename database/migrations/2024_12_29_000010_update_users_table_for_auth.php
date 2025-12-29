<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['individual', 'professional'])->default('individual')->after('email_verified_at');
            $table->string('company_name')->nullable()->after('type');
            $table->string('siret', 14)->nullable()->after('company_name');
            $table->string('phone')->nullable()->after('siret');
            $table->boolean('is_active')->default(true)->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['type', 'company_name', 'siret', 'phone', 'is_active']);
        });
    }
};