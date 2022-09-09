<?php

return (new PhpCsFixer\Config())
->setRules([
    '@PSR2' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'binary_operator_spaces' => true,
    'blank_line_after_opening_tag' => true,
    'cast_spaces' => [
        'space' => 'single',
    ],
    'class_attributes_separation' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'function_typehint_space' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_unused_imports' => true,
    'no_useless_return' => true,
    'no_whitespace_in_blank_line' => true,
    'ordered_imports' => true,
]);
