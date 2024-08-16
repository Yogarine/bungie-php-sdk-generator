<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\JsonSchema\Schema;
use Yogarine\OpenAPI\ObjectInterface;
use Yogarine\OpenAPI\Spec;

/**
 * Holds a set of reusable objects for different aspects of the OAS.
 *
 * All objects defined within the components object will have no effect on
 * the API unless they are explicitly referenced from properties outside the
 * components object.
 *
 * @phpstan-import-type CallbackSpec       from Callback
 * @phpstan-import-type ExampleSpec        from Example
 * @phpstan-import-type HeaderSpec         from Header
 * @phpstan-import-type LinkSpec           from Link
 * @phpstan-import-type ParameterSpec      from Parameter
 * @phpstan-import-type PathItemSpec       from PathItem
 * @phpstan-import-type ReferenceSpec      from Reference
 * @phpstan-import-type RequestBodySpec    from RequestBody
 * @phpstan-import-type ResponseSpec       from Response
 * @phpstan-import-type SchemaSpec         from Schema
 * @phpstan-import-type SecuritySchemeSpec from SecurityScheme
 *
 * @phpstan-type ComponentsSpec array{
 *                                  schemas?:         array<string,SchemaSpec>,
 *                                  responses?:       array<string,ResponseSpec|ReferenceSpec>,
 *                                  parameters?:      array<string,ParameterSpec|ReferenceSpec>,
 *                                  examples?:        array<string,ExampleSpec|ReferenceSpec>,
 *                                  requestBodies?:   array<string,RequestBodySpec|ReferenceSpec>,
 *                                  headers?:         array<string,HeaderSpec|ReferenceSpec>,
 *                                  securitySchemes?: array<string,SecuritySchemeSpec|ReferenceSpec>,
 *                                  links?:           array<string,LinkSpec|ReferenceSpec>,
 *                                  callbacks?:       array<string,CallbackSpec|ReferenceSpec>,
 *                                  pathItems?:       array<string,PathItemSpec|ReferenceSpec>,
 *                              }
 */
readonly class Components implements ObjectInterface
{
    /**
     * @param  null|array<string,Schema>                                    $schemas
     * @param  null|array<string,Response|Reference<Response>>              $responses
     * @param  null|array<string,Parameter|Reference<Parameter>>            $parameters
     * @param  null|array<string,Example|Reference<Example>>                $examples
     * @param  null|array<string,RequestBody|Reference<RequestBody>>        $requestBodies
     * @param  null|array<string,Header|Reference<Header>>                  $headers
     * @param  null|array<string,SecurityScheme|Reference<SecurityScheme>>  $securitySchemes
     * @param  null|array<string,Link|Reference<Link>>                      $links
     * @param  null|array<string,Callback|Reference<Callback>>              $callbacks
     * @param  null|array<string,PathItem|Reference<PathItem>>              $pathItems
     */
    public function __construct(
        public ?array $schemas         = null,
        public ?array $responses       = null,
        public ?array $parameters      = null,
        public ?array $examples        = null,
        public ?array $requestBodies   = null,
        public ?array $headers         = null,
        public ?array $securitySchemes = null,
        public ?array $links           = null,
        public ?array $callbacks       = null,
        public ?array $pathItems       = null,
    ) {}

    /**
     * @param  ComponentsSpec  $spec
     * @return self
     */
    public static function fromSpec(array $spec): self
    {
        return new self(
            schemas:         Spec::fromSpecs($spec, 'schemas',         Schema::class),
            responses:       Spec::fromSpecs($spec, 'responses',       Response::class),
            parameters:      Spec::fromSpecs($spec, 'parameters',      Parameter::class),
            examples:        Spec::fromSpecs($spec, 'examples',        Example::class),
            requestBodies:   Spec::fromSpecs($spec, 'requestBodies',   RequestBody::class),
            headers:         Spec::fromSpecs($spec, 'headers',         Header::class),
            securitySchemes: Spec::fromSpecs($spec, 'securitySchemes', SecurityScheme::class),
            links:           Spec::fromSpecs($spec, 'links',           Link::class),
            callbacks:       Spec::fromSpecs($spec, 'callbacks',       Callback::class),
            pathItems:       Spec::fromSpecs($spec, 'pathItems',       PathItem::class),
        );
    }
}
