<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

enum ParameterStyle: string
{
    case Form   = 'form';
    case Simple = 'simple';
}
