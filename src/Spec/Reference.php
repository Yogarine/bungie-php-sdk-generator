<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * @phpstan-type ReferenceSpec array{"$ref": string, x-destiny-component-type-dependency?: string}
 *
 * @template T
 */
readonly class Reference implements ObjectInterface
{
    /**
     * @param  string       $ref                              The reference identifier.
     * @param  string|null  $summary                          A short summary which by overrides that of the referenced
     *                                                        component. If the referenced object-type does not allow a
     *                                                        summary field, then this field has no effect.
     * @param  string|null  $description                      A description which overrides that of the referenced
     *                                                        component. CommonMark syntax MAY be used for rich text
     *                                                        representation. If the referenced object-type does not
     *                                                        allow a description field, then this field has no effect.
     * @param  string|null  $xDestinyComponentTypeDependency  A new concept in the Destiny 2 API is "Components". You
     *                                                        will see that the Destiny Profile/Character calls have
     *                                                        been mostly simplified down to just GetProfile/
     *                                                        GetCharacter/GetItem. This simplification is made possible
     *                                                        by Components, which are identifiers you pass into the
     *                                                        requests to specify how much data you want back. An entity
     *                                                        with this property will only be returned if you've passed
     *                                                        the named Component Identifier into the GetProfile/
     *                                                        GetCharacter/GetItem methods.
     */
    public function __construct(
        public string      $ref,
        public string|null $summary                         = null,
        public string|null $description                     = null,
        public string|null $xDestinyComponentTypeDependency = null,
    ) {}

    /**
     * @param  ReferenceSpec  $spec
     * @return static
     */
    public static function fromSpec(array $spec): static
    {
        return new self(
            $spec['$ref'],
            $spec['summary'] ?? null,
            $spec['description'] ?? null,
            $spec['x-destiny-component-type-dependency'] ?? null,
        );
    }
}
