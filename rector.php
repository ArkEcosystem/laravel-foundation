<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Laravel\Set\LaravelSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $dir = getcwd();

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        $dir.'/app',
    ]);
    $parameters->set(Option::SKIP, [
        $dir.'/app/Providers',
        $dir.'/app/Exceptions',
    ]);
    $parameters->set(Option::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::IMPORT_SHORT_CLASSES, true);
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);

//    if (file_exists($dir.'/vendor/arkecosystem/foundation/phpstan.neon')) {
//        $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, $dir.'/vendor/arkecosystem/foundation/phpstan.neon');
//    }

    $containerConfigurator->import(SetList::PSR_4);
    $containerConfigurator->import(SetList::ORDER);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL);
    $containerConfigurator->import(LaravelSetList::LARAVEL_CODE_QUALITY);
//    $containerConfigurator->import(LaravelSetList::LARAVEL_STATIC_TO_INJECTION);
    $containerConfigurator->import(LaravelSetList::LARAVEL_80);

    $services = $containerConfigurator->services();

    // Coding Style
    $services->set(\Rector\CodingStyle\Rector\If_\NullableCompareToNullRector::class);
    $services->set(\Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector::class);
    $services->set(\Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector::class);
    $services->set(\Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector::class);
    $services->set(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector::class);
    $services->set(\Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector::class);
    $services->set(\Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class);
    $services->set(\Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector::class);
    $services->set(\Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class);
    $services->set(\Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class);
    $services->set(\Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector::class);
    $services->set(\Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector::class);
    $services->set(\Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class);
    $services->set(\Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class);

    // Dead Code
    $services->set(\Rector\DeadCode\Rector\Cast\RecastingRemovalRector::class);
    $services->set(\Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector::class);
    $services->set(\Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector::class);
    $services->set(\Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector::class);
    $services->set(\Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector::class);
    $services->set(\Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector::class);
    $services->set(\Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector::class);
    $services->set(\Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector::class);
    $services->set(\Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector::class);
    $services->set(\Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector::class);
    $services->set(\Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector::class);
    $services->set(\Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector::class);
    $services->set(\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    $services->set(\Rector\DeadCode\Rector\Assign\RemoveUnusedAssignVariableRector::class);
    $services->set(\Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector::class);

    // Naming
    $services->set(\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector::class);

    // Php70
    $services->set(\Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector::class);
    $services->set(\Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector::class);

    // Php80
    $services->set(\Rector\Php80\Rector\ClassMethod\AddParamBasedOnParentClassMethodRector::class);
    $services->set(\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);
    $services->set(\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
    $services->set(\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
    $services->set(\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
    $services->set(\Rector\Php80\Rector\Ternary\GetDebugTypeRector::class);
    $services->set(\Rector\Php80\Rector\ClassMethod\OptionalParametersAfterRequiredRector::class);
    $services->set(\Rector\Php80\Rector\FuncCall\Php8ResourceReturnToObjectRector::class);
    $services->set(\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
    $services->set(\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class);
    $services->set(\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
    $services->set(\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
    $services->set(\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
    $services->set(\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
    $services->set(\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);

    // Php 8.1
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector::class);
    $services->set(\Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector::class);
    $services->set(\Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector::class);
    $services->set(\Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector::class);
    $services->set(\Rector\Php81\Rector\Property\ReadOnlyPropertyRector::class);
    $services->set(\Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector::class);
    $services->set(\Rector\Php81\Rector\FuncCall\Php81ResourceReturnToObjectRector::class);
    $services->set(\Rector\Php81\Rector\FunctionLike\IntersectionTypesRector::class);

    // Type Declaration
    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);

    // Restoration
    $services->set(\Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector::class);

    // Privatization
    $services->set(\Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->set(\Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->set(\Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
    $services->set(\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class);
    $services->set(\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector::class);

    // Post Rector
    $services->set(\Rector\PostRector\Rector\ClassRenamingPostRector::class);
    $services->set(\Rector\PostRector\Rector\NameImportingPostRector::class);
    $services->set(\Rector\PostRector\Rector\UseAddingPostRector::class);
};
