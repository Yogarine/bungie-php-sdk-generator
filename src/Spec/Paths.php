<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use ArrayObject;
use Yogarine\OpenAPI\ObjectInterface;

/**
 * Holds the relative paths to the individual endpoints and their operations.
 *
 * The path is appended to the URL from the Server Object in order to construct
 * the full URL. The Paths MAY be empty, due to Access Control List (ACL) constraints.
 *
 * @phpstan-import-type PathItemSpec  from PathItem
 * @phpstan-import-type ReferenceSpec from Reference
 *
 * @phpstan-type PathsSpec array<string, PathItemSpec|ReferenceSpec>
 *
 * @template-extends ArrayObject<string, PathItem|Reference<PathItem>
 */
class Paths extends ArrayObject implements ObjectInterface
{
    /**
     * @param  PathsSpec  $spec
     * @return self
     */
    public static function fromSpec(array $spec): self
    {
        $paths = [];
        foreach ($spec as $path => $pathItemSpec) {
            $paths[$path] = PathItem::fromSpec($pathItemSpec);
        }

        return new self($paths);
    }
}
