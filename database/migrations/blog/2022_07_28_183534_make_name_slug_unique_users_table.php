<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        // Re-save existing users to fill the name_slug entry for them
        User::withTrashed()->get()->each(function ($user) {
            $user->generateSlug();
            $user->save();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name_slug')->nullable(false)->change();
        });
    }
};
