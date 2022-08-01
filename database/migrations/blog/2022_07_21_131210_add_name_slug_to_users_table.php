<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddNameSlugToUsersTable extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('users', 'name_slug')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('name_slug')->nullable()->unique();
            });
        }
    }
}
