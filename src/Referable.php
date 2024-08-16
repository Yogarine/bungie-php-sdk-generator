<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI;

use Yogarine\OpenAPI\Spec\Reference;

/**
 * @phpstan-import-type ReferenceSpec from Reference
 *
 * @implements ReferableObjectInterface<self>
 */
trait Referable
{
    /**
     * @param  ReferenceSpec  $referenceSpec
     * @return null|Reference<self>
     */
    public static function tryFromReferenceSpec(array $referenceSpec): ?Reference
    {
        if (Spec::isReference($referenceSpec)) {
            return self::fromReferenceSpec($referenceSpec);
        }

        return null;
    }

    /**
     * @param  ReferenceSpec  $referenceSpec
     * @return Reference<self>
     */
    public static function fromReferenceSpec(array $referenceSpec): Reference
    {
        return Reference::fromSpec($referenceSpec);
    }
}
