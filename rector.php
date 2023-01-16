<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $dir = getcwd();

    $rectorConfig->sets([
        SetList::PRIVATIZATION,
        SetList::EARLY_RETURN,
        SetList::CODING_STYLE,
        LaravelSetList::LARAVEL_90,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
    ]);

    /*
     * We added a custom bootstrap file to avoid Rector processing errors.
     * For more info: https://github.com/rectorphp/rector/issues/6607#issuecomment-891677145
     * and https://github.com/rectorphp/rector/issues/3902.
     * Bootstrap file source: https://github.com/samsonasik/example-app/blob/922ea0e43a50d9b3eb9e71f57c0af41b8ad97226/rector-bootstrap.php
     */
    $rectorConfig->bootstrapFiles([$dir.'/vendor/arkecosystem/foundation/rector-bootstrap.php']);

    $rectorConfig->paths([
        $dir.'/app',
    ]);

    $rectorConfig->skip([
        // skip Livewire
        $dir.'/app/Http/Livewire',
        $dir.'/app/App/Collaborator/Components',
        $dir.'/app/App/Http/Components',
        $dir.'/app/App/SecureShell/Components',
        $dir.'/app/App/Server/Components',
        $dir.'/app/App/Token/Components',
        $dir.'/app/App/User/Components',
        $dir.'/app/App/View/Components',

        // skip Nova
        $dir.'/app/App/Nova',
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_81);

    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);

    if (file_exists($neon = $dir.'/vendor/arkecosystem/foundation/phpstan.neon')) {
        $rectorConfig->phpstanConfig($neon);
    }

    $rectorConfig->skip([
        \Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class,
        \Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class,
        \Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class,
        \Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class,
        \Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class,
        \Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class,
        \Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class,
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
        \Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class,
        \Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector::class,
        \Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector::class,
    ]);

    // Restoration
    $rectorConfig->rule(\Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector::class);

    // php5.5
    $rectorConfig->rule(\Rector\Php55\Rector\FuncCall\GetCalledClassToStaticClassRector::class);

    // php7.4
    $rectorConfig->rule(\Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector::class);
    $rectorConfig->rule(\Rector\Php74\Rector\Assign\NullCoalescingOperatorRector::class);
    $rectorConfig->rule(\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector::class);

    // php8.0
    $rectorConfig->rule(\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
    $rectorConfig->rule(\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
    $rectorConfig->rule(\Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\FuncCall\Php8ResourceReturnToObjectRector::class);

    // php8.1
    $rectorConfig->rule(\Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector::class);
    $rectorConfig->rule(\Rector\Php81\Rector\Property\ReadOnlyPropertyRector::class);
    $rectorConfig->rule(\Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector::class);
    $rectorConfig->rule(\Rector\Php81\Rector\FuncCall\Php81ResourceReturnToObjectRector::class);
    $rectorConfig->rule(\Rector\Php81\Rector\FunctionLike\IntersectionTypesRector::class);
};
