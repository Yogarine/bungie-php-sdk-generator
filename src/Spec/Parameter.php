<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\JsonSchema\Schema;
use Yogarine\OpenAPI\Referable;
use Yogarine\OpenAPI\ReferableObjectInterface;

/**
 * Describes a single operation parameter.
 *
 * @phpstan-type ParameterSpec array{
 *                                 name:             string,
 *                                 in:               value-of<ParameterLocation>,
 *                                 description?:     string,
 *                                 required?:        bool,
 *                                 deprecated?:      bool,
 *                                 allowEmptyValue?: bool,
 *                                 style?:           value-of<ParameterStyle>,
 *                                 explode?:         bool,
 *                                 allowReserved?:   bool,
 *                                 schema?:          SchemaSpec,
 *                                 example?:         mixed,
 *                                 examples?:        array<string, ExampleSpec|RefrenceSpec>,
 *                             }
 *
 * @extends ReferableObjectInterface<self>
 */
readonly class Parameter implements ReferableObjectInterface
{
    use Referable;

    /**
     * @param string                                               $name             The name of the parameter.
     *                                                                               Parameter names are case-sensitive.
     * @param ParameterLocation                                    $in               The location of the parameter.
     * @param null|string                                          $description      Brief description of the parameter.
     * @param ($in is ParameterLocation::Path ? true : null|bool)  $required         Determines whether this parameter
     *                                                                               is mandatory.
     * @param null|bool                                            $deprecated       Specifies that a parameter is
     *                                                                               deprecated and SHOULD be
     *                                                                               transitioned out of usage.
     * @param null|bool                                            $allowEmptyValue  Sets the ability to pass
     *                                                                               empty-valued parameters.
     * @param null|ParameterStyle                                  $style
     * @param null|bool                                            $explode
     * @param ($in is ParameterLocation::Query)                                            $allowReserved
     * @param null|Schema                                          $schema
     * @param null|mixed                                           $example
     * @param null|array                                           $examples
     */
    public function __construct(
        public string $name,
        public ParameterLocation $in,
        public null|string         $description      = null,
        public null|bool           $required         = null,
        public null|bool           $deprecated       = null,
        public null|bool           $allowEmptyValue  = null,
        public null|ParameterStyle $style            = null,
        public null|bool           $explode          = null,
        public null|bool           $allowReserved    = null,
        public null|Schema         $schema           = null,
        public mixed               $example          = null,
        public null|array          $examples         = null,
    ) {}

    public static function fromSpec(array $spec): self|Reference
    {
        // TODO: Implement fromSpec() method.
    }
}
