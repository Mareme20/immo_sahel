<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->foreignId('owner_contact_id')->nullable()->after('user_id')->constrained('contacts')->nullOnDelete();
            $table->foreignId('tenant_contact_id')->nullable()->after('owner_contact_id')->constrained('contacts')->nullOnDelete();
            $table->string('address_line')->nullable()->after('location');
            $table->string('city')->nullable()->after('address_line');
            $table->string('district')->nullable()->after('city');
            $table->decimal('latitude', 10, 7)->nullable()->after('district');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->unsignedInteger('parking_spaces')->nullable()->after('bathrooms');
            $table->string('seo_title')->nullable()->after('is_published');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->timestamp('published_at')->nullable()->after('seo_description');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropConstrainedForeignId('owner_contact_id');
            $table->dropConstrainedForeignId('tenant_contact_id');
            $table->dropColumn([
                'address_line',
                'city',
                'district',
                'latitude',
                'longitude',
                'parking_spaces',
                'seo_title',
                'seo_description',
                'published_at',
            ]);
        });
    }
};
