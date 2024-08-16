<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

enum ParameterLocation: string
{
    case Path = 'path';
    case Query = 'query';
    case Header = 'header';
    case Cookie = 'cookie';
}
