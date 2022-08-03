<?php

declare(strict_types=1);

/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:3.0.0|configurator
 * you can change this configuration by importing this file.
 */
$config = new PhpCsFixer\Config();

return $config
    ->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PSR1' => true,
        '@PSR12' => true,
        '@PSR2' => true,
        '@PHP80Migration' => true,
        'align_multiline_comment' => ['comment_type' => 'phpdocs_only'],
        'declare_strict_types' => true,
        'global_namespace_import' => true,
        'heredoc_indentation' => true,
        'list_syntax' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'phpdoc_line_span' => ['const' => 'single', 'property' => 'single'],
        'self_static_accessor' => true,
        'simplified_null_return' => true,
        'single_line_throw' => true,
        'ternary_to_null_coalescing' => true,
        'void_return' => true,
        'no_unused_imports' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['storage', 'vendor'])
            ->in(__DIR__)
    );
