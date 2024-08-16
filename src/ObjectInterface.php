<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI;

interface ObjectInterface
{
    /**
     * @param  array  $spec
     * @return self
     */
    public static function fromSpec(array $spec): self;
}
