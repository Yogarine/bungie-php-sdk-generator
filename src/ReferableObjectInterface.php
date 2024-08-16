<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI;

use Yogarine\OpenAPI\Spec\Reference;

/**
 * @phpstan-import-type ReferenceSpec from Reference
 *
 * @template-extends ObjectInterface
 */
interface ReferableObjectInterface extends ObjectInterface
{
    /**
     * @param  ReferenceSpec|array  $spec
     * @return ($spec is ReferenceSpec ? Reference<self> : self)
     */
    public static function fromSpec(array $spec): self|Reference;
}
