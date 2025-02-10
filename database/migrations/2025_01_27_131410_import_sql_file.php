<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $path = base_path('database/sql/import_data_address.sql');
        $sql = File::get($path);
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
