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
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedBigInteger('status')->default(0)->comment('0=unapproved,1=approved');
            $table->unsignedBigInteger('is_featured')->default(0)->comment('0=not_featured,1=featured');
            $table->unsignedBigInteger('count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->drop('status');
            $table->drop('is_featured');
            $table->drop('count');
        });
    }
};
