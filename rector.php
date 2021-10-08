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

    if (file_exists($dir.'/vendor/arkecosystem/foundation/phpstan.neon')) {
        $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, $dir.'/vendor/arkecosystem/foundation/phpstan.neon');
    }

    $containerConfigurator->import(SetList::CARBON_2);
    $containerConfigurator->import(SetList::CODE_QUALITY);
//    $containerConfigurator->import(SetList::CODING_STYLE);
//    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL);
    $containerConfigurator->import(LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL);
    $containerConfigurator->import(LaravelSetList::LARAVEL_CODE_QUALITY);
//    $containerConfigurator->import(LaravelSetList::LARAVEL_STATIC_TO_INJECTION);
//    $containerConfigurator->import(SetList::NAMING);
    $containerConfigurator->import(SetList::ORDER);
    $containerConfigurator->import(SetList::PHP_74);
    $containerConfigurator->import(SetList::PSR_4);
//    $containerConfigurator->import(SetList::TYPE_DECLARATION);
//    $containerConfigurator->import(SetList::PRIVATIZATION);

    $services = $containerConfigurator->services();

    // Coding Style
    // https://github.com/rectorphp/rector/blob/master/docs/rector_rules_overview.md#codingstyle
    $services->set(\Rector\CodingStyle\Rector\If_\NullableCompareToNullRector::class);
    $services->set(\Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector::class);
    $services->set(\Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector::class);
    $services->set(\Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class);
    $services->set(\Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector::class);
    $services->set(\Rector\CodingStyle\Rector\String_\SplitStringClassConstantToClassConstFetchRector::class);
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
    $services->set(\Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector::class);
    $services->set(\Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector::class);
    $services->set(\Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector::class);
    $services->set(\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class);
    $services->set(\Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class);

    // Dead Code
    // https://github.com/rectorphp/rector/blob/master/docs/rector_rules_overview.md#deadcode
    $services->set(\Rector\DeadCode\Rector\Cast\RecastingRemovalRector::class);
    $services->set(\Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector::class);
    $services->set(\Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector::class);
    $services->set(\Rector\DeadCode\Rector\Assign\RemoveAssignOfVoidReturnFunctionRector::class);
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
//    $services->set(\Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class);
//    $services->set(\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class);
    $services->set(\Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class);
    $services->set(\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
    $services->set(\Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector::class);

    // Php70
    // https://github.com/rectorphp/rector/blob/master/docs/rector_rules_overview.md#php70
    $services->set(\Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector::class);
    $services->set(\Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector::class);
    $services->set(\Rector\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector::class);

    // Php73
    // https://github.com/rectorphp/rector/blob/master/docs/rector_rules_overview.md#php73
    $services->set(\Rector\Php73\Rector\String_\SensitiveHereNowDocRector::class);

    // Php80
    // https://github.com/rectorphp/rector/blob/master/docs/rector_rules_overview.md#php80
    $services->set(\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class);
    $services->set(\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
    $services->set(\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
    $services->set(\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
    $services->set(\Rector\Php80\Rector\Ternary\GetDebugTypeRector::class);
    $services->set(\Rector\Php80\Rector\ClassMethod\OptionalParametersAfterRequiredRector::class);
    $services->set(\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
    $services->set(\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class);
    $services->set(\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
    $services->set(\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
    $services->set(\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
    $services->set(\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
    $services->set(\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector::class);
    $services->set(\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);
    // @see https://php.watch/versions/8.0/pgsql-aliases-deprecated
    $services
        ->set(\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)
        ->call('configure', [[
            Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => [
                'pg_clientencoding'    => 'pg_client_encoding',
                'pg_cmdtuples'         => 'pg_affected_rows',
                'pg_errormessage'      => 'pg_last_error',
                'pg_fieldisnull'       => 'pg_field_is_null',
                'pg_fieldname'         => 'pg_field_name',
                'pg_fieldnum'          => 'pg_field_num',
                'pg_fieldprtlen'       => 'pg_field_prtlen',
                'pg_fieldsize'         => 'pg_field_size',
                'pg_fieldtype'         => 'pg_field_type',
                'pg_freeresult'        => 'pg_free_result',
                'pg_getlastoid'        => 'pg_last_oid',
                'pg_loclose'           => 'pg_lo_close',
                'pg_locreate'          => 'pg_lo_create',
                'pg_loexport'          => 'pg_lo_export',
                'pg_loimport'          => 'pg_lo_import',
                'pg_loopen'            => 'pg_lo_open',
                'pg_loread'            => 'pg_lo_read',
                'pg_loreadall'         => 'pg_lo_read_all',
                'pg_lounlink'          => 'pg_lo_unlink',
                'pg_lowrite'           => 'pg_lo_write',
                'pg_numfields'         => 'pg_num_fields',
                'pg_numrows'           => 'pg_num_rows',
                'pg_result'            => 'pg_fetch_result',
                'pg_setclientencoding' => 'pg_set_client_encoding',
            ],
        ]]);

    // Type Declaration
    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
//    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector::class);
    $services->set(\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);

    // Restoration
    // https://github.com/rectorphp/rector/blob/master/docs/rector_rules_overview.md#restoration
    $services->set(\Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector::class);

    // Privatization
    $services->set(\Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->set(\Rector\Privatization\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector::class);
    $services->set(\Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->set(\Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
//    $services->set(\Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
    $services->set(\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class);
    $services->set(\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector::class);
    $services->set(\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector::class);
};
