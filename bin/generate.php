<?php

declare(strict_types=1);

use Yogarine\OpenAPI\Generator;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * @noinspection PhpUnhandledExceptionInspection
 */
exit(Generator::main($argc, $argv));
