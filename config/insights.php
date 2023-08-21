<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\UselessFunctionDocCommentSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;

return [

    'preset' => 'laravel',

    'ide' => 'phpstorm',

    'exclude' => [
        'app/Providers'
    ],

    'add' => [],

    'remove' => [
        // Code
        DeclareStrictTypesSniff::class,          // Declare strict types
        ForbiddenPublicPropertySniff::class,       // Forbidden public property
        VisibilityRequiredFixer::class,                   // Visibility required
        ClassConstantVisibilitySniff::class,       // Class constant visibility
        DisallowEmptySniff::class,       // Disallow empty
        NoEmptyCommentFixer::class,                             // No empty comment
        UselessFunctionDocCommentSniff::class,  // Useless function doc comment

        // Architecture
        ForbiddenNormalClasses::class,            //Normal classes are forbidden

        // Style
        SpaceAfterCastSniff::class,  // Space after cast
        SpaceAfterNotSniff::class,   // Space after not
        AlphabeticallySortedUsesSniff::class,   // Alphabetically sorted uses
        DocCommentSpacingSniff::class,          // Doc comment spacing
        OrderedClassElementsFixer::class,                 // Ordered class elements
        SingleQuoteFixer::class,                         // Single quote
    ],

    'config' => [
        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 8,
        ],
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => false,
        ],
        OrderedImportsFixer::class => [
            'imports_order' => ['class', 'const', 'function'],
            'sort_algorithm' => 'length',
        ]
    ],

    'requirements' => [
        'min-quality' => 75,
        'min-complexity' => 75,
        'min-architecture' => 75,
        'min-style' => 75,
        'disable-security-check' => false,
    ],
];
