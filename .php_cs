<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

return PhpCsFixer\Config::create()
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setIndent('    ')
    ->setRules([
        '@Symfony' => true,
        'binary_operator_spaces' => ['operators' => ['=>' => null]],
        'array_syntax' => ['syntax' => 'short'],
        'linebreak_after_opening_tag' => true,
        'not_operator_with_successor_space' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
    ])
    ->setFinder($finder)
;
