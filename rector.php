<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $parameters = $rectorConfig->parameters();
    $services   = $rectorConfig->services();
    $dir        = getcwd();

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

    $services->remove(\Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->remove(\Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
    $services->remove(\Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->remove(\Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
    $services->remove(\Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class);
    $services->remove(\Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class);
    $services->remove(\Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class);
    $services->remove(\Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class);
    $services->remove(\Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class);
    $services->remove(\Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector::class);
    $services->remove(\Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector::class);

    // Restoration
    $services->set(\Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector::class);

    // php5.5
    $services->set(\Rector\Php55\Rector\FuncCall\GetCalledClassToStaticClassRector::class);

    // php7.4
    $services->set(\Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector::class);
    $services->set(\Rector\Php74\Rector\Assign\NullCoalescingOperatorRector::class);
    $services->set(\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector::class);

    // php8.0
    $services->set(\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);
    $services->set(\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
    $services->set(\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
    $services->set(\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
    $services->set(\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
    $services->set(\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
    $services->set(\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
    $services->set(\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);
    $services->set(\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
    $services->set(\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    $services->set(\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
    $services->set(\Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector::class);
    $services->set(\Rector\Php80\Rector\FuncCall\Php8ResourceReturnToObjectRector::class);

    // php8.1
    $services->set(\Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector::class);
    $services->set(\Rector\Php81\Rector\Property\ReadOnlyPropertyRector::class);
    $services->set(\Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector::class);
    $services->set(\Rector\Php81\Rector\FuncCall\Php81ResourceReturnToObjectRector::class);
    $services->set(\Rector\Php81\Rector\FunctionLike\IntersectionTypesRector::class);
};
