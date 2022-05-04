<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Laravel\Set\LaravelSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (RectorConfig $rectorConfig): void
{
    $dir = getcwd();

    $rectorConfig->sets([
        SetList::PRIVATIZATION,
        SetList::EARLY_RETURN,
        SetList::CODING_STYLE,
        LaravelSetList::LARAVEL_80,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,

        // Restoration
        \Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector::class),

        // php5.5
        \Rector\Php55\Rector\FuncCall\GetCalledClassToStaticClassRector::class),

        // php7.4
        \Rector\Php74\Rector\Property\TypedPropertyRector::class),
        \Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector::class),
        \Rector\Php74\Rector\Assign\NullCoalescingOperatorRector::class),
        \Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector::class),

        // php8.0
        \Rector\Php80\Rector\FunctionLike\UnionTypesRector::class),
        \Rector\Php80\Rector\NotIdentical\StrContainsRector::class),
        \Rector\Php80\Rector\Identical\StrStartsWithRector::class),
        \Rector\Php80\Rector\Identical\StrEndsWithRector::class),
        \Rector\Php80\Rector\Class_\StringableForToStringRector::class),
        \Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class),
        \Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class),
        \Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class),
        \Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class),
        \Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class),
        \Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class),
        \Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector::class),
        \Rector\Php80\Rector\FuncCall\Php8ResourceReturnToObjectRector::class),

        // php8.1
        \Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector::class),
        \Rector\Php81\Rector\Property\ReadOnlyPropertyRector::class),
        \Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector::class),
        \Rector\Php81\Rector\FuncCall\Php81ResourceReturnToObjectRector::class),
        \Rector\Php81\Rector\FunctionLike\IntersectionTypesRector::class),
    ]);

    // $rectorConfig->rule(TypedPropertyRector::class);

    $rectorConfig->bootstrapFiles($dir.'/vendor/arkecosystem/foundation/rector-bootstrap.php');

    $rectorConfig->set(Option::PATHS, [
        $dir.'/app',
    ]);

    $rectorConfig->set(Option::SKIP, [
        // skip Livewire
        $dir.'/app/Http/Livewire',
        $dir.'/app/App/Blog/Components',
        $dir.'/app/App/Collaborator/Components',
        $dir.'/app/App/Http/Components',
        $dir.'/app/App/Platform/Components',
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
    $rectorConfig->disableImportShortClasses();

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
};
