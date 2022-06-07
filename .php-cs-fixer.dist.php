<?php
require_once 'vendor/autoload.php';
/**
 * commande de lancement : 
 * php ./vendor/bin/php-cs-fixer fix --show-progress=estimating --allow-risky=yes
 */
$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
    ])
    ->setFinder($finder);
