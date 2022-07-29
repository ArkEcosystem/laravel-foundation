<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class RenameArticlesMorphClass extends Migration
{
    public function up()
    {
        Media::where('model_type', "App\Models\User")->update(['model_type' => (new User())->getMorphClass()]);
        Media::where('model_type', "App\Models\Article")->update(['model_type' => (new Article())->getMorphClass()]);
    }
}
