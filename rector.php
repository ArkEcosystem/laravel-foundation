<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Laravel\Set\LaravelSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $services   = $containerConfigurator->services();
    $dir        = getcwd();

    $parameters->set(Option::BOOTSTRAP_FILES, [
        $dir.'/bootstrap/app.php',
    ]);

    $parameters->set(Option::PATHS, [
        $dir.'/app',
    ]);

    $parameters->set(Option::SKIP, [
        //
    ]);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_81);

    $parameters->set(Option::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::IMPORT_SHORT_CLASSES, false);
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);

    if (file_exists($neon = $dir.'/vendor/arkecosystem/foundation/phpstan.neon')) {
        $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, $neon);
    }

//    $containerConfigurator->import(SetList::CODE_QUALITY);
//    $services->remove(\Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class);

//    $containerConfigurator->import(SetList::PRIVATIZATION);
//    $services->remove(\Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
//    $services->remove(\Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
//    $services->remove(\Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);

//    $containerConfigurator->import(SetList::TYPE_DECLARATION);
//    $containerConfigurator->import(SetList::TYPE_DECLARATION_STRICT);
//    $containerConfigurator->import(SetList::EARLY_RETURN);
//    $containerConfigurator->import(SetList::CODING_STYLE);
//    $services->remove(\Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class);
//    $services->remove(\Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class);
//    $services->remove(\Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class);

//    $containerConfigurator->import(SetList::DEAD_CODE);

//    $containerConfigurator->import(LaravelSetList::LARAVEL_80);
//    $containerConfigurator->import(LaravelSetList::LARAVEL_CODE_QUALITY);
//    $containerConfigurator->import(LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL);

    // Restoration
//    $services->set(\Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector::class);

    // php7.4
//    $services->set(\Rector\Php74\Rector\Property\TypedPropertyRector::class);
//    $services->set(\Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector::class);
//    $services->set(\Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector::class);
//    $services->set(\Rector\Php74\Rector\Assign\NullCoalescingOperatorRector::class);
//    $services->set(\Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector::class);
//    $services->set(\Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector::class);
//    $services->set(\Rector\Php74\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector::class);
//    $services->set(\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector::class);
//    $services->set(\Rector\Php74\Rector\ArrayDimFetch\CurlyToSquareBracketArrayStringRector::class);

    // php8.0
//    $services->set(\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);
//    $services->set(\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
//    $services->set(\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
//    $services->set(\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
//    $services->set(\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
//    $services->set(\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
//    $services->set(\Rector\Php80\Rector\Ternary\GetDebugTypeRector::class);
//    $services->set(\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector::class);
//    $services->set(\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
//    $services->set(\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);
//    $services->set(\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
//    $services->set(\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
//    $services->set(\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class);
//    $services->set(\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
//    $services->set(\Rector\Php80\Rector\ClassMethod\OptionalParametersAfterRequiredRector::class);
//    $services->set(\Rector\Php80\Rector\FuncCall\Php8ResourceReturnToObjectRector::class);

    // php8.1
//    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector::class);
    $services->set(\Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector::class);
    $services->set(\Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector::class);
    $services->set(\Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector::class);
    $services->set(\Rector\Php81\Rector\Property\ReadOnlyPropertyRector::class);
    $services->set(\Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector::class);
    $services->set(\Rector\Php81\Rector\FuncCall\Php81ResourceReturnToObjectRector::class);
    $services->set(\Rector\Php81\Rector\FunctionLike\IntersectionTypesRector::class);
};
