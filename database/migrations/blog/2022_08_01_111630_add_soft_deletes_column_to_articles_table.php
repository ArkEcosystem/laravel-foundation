<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('articles', 'deleted_at')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }
};
