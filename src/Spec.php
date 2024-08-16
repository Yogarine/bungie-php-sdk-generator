<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI;

use Yogarine\OpenAPI\Spec\Reference;

/**
 * @phpstan-import-type ReferenceSpec from Reference
 */
class Spec
{
    /**
     * @param  array  $spec
     * @return ($spec is ReferenceSpec ? true : false)
     */
    public static function isReference(array $spec): bool
    {
        return isset($spec['$ref']);
    }

    /**
     * @template T of ObjectInterface
     *
     * @param  array<string, array|ReferenceSpec>  $specs
     * @param  string                              $component
     * @param  class-string<T>                     $class
     * @return null|array<string, T>
     */
    public static function fromSpecs(array $specs, string $component, string $class): ?array
    {
        if (isset($specs[$component])) {
            $results = [];
            foreach ($specs[$component] as $key => $spec) {
                $results[$key] = $class::fromSpec($spec);
            }

            return $results;
        }

        return null;
    }
}
