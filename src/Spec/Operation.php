<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * @phpstan-import-type ParameterSpec           from Parameter
 * @phpstan-import-type ReferenceSpec           from Reference
 * @phpstan-import-type RequestBodySpec         from RequestBody
 * @phpstan-import-type SecurityRequirementSpec from SecurityRequirement
 *
 * @phpstan-type OperationSpec array{
 *                                 tags?:        string[],
 *                                 description?: string,
 *                                 operationId?: string,
 *                                 parameters?:  (ParameterSpec|ReferenceSpec)[],
 *                                 requestBody?: RequestBodySpec|ReferenceSpec,
 *                                 responses?:   ResponsesSpec,
 *                                 deprecated?:  bool,
 *                                 security?:    SecurityRequirementSpec[],
 *                             }
 * @phpstan-type ResponsesSpec array
 */
readonly class Operation implements ObjectInterface
{
    /**
     * @param  string[]|null                            $tags         A list of tags for API documentation control. Tags can be used for logical grouping of operations by resources or any other qualifier.
     * @param  string|null                              $description
     * @param  string|null                              $operationId
     * @param  (Parameter|Reference<Parameter>)[]|null  $parameters
     * @param  RequestBody|Reference<RequestBody>|null  $requestBody
     * @param  Responses|null                           $responses
     * @param  bool|null                                $deprecated
     * @param  SecurityRequirement[]|null               $security
     */
    public function __construct(
        public array|null  $tags        = null,
        public string|null $description = null,
        public string|null $operationId = null,
        public array|null  $parameters  = null,
        public array|null  $requestBody = null,
        public array|null  $responses   = null,
        public bool|null   $deprecated  = null,
        public array|null  $security    = null,
    ) {}

    public static function fromSpec(array $spec): static
    {

    }
}
