<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\Referable;
use Yogarine\OpenAPI\ReferableObjectInterface;

/**
 * @phpstan-import-type OperationSpec from Operation
 * @phpstan-import-type ReferenceSpec from Reference
 * @phpstan-import-type ServerSpec    from Server
 *
 * @phpstan-type PathItemSpec array{
 *                                summary?:     string,
 *                                description?: string,
 *                                get?:         OperationSpec,
 *                                put?:         OperationSpec,
 *                                post?:        OperationSpec,
 *                                delete?:      OperationSpec,
 *                                options?:     OperationSpec,
 *                                head?:        OperationSpec,
 *                                patch?:       OperationSpec,
 *                                trace?:       OperationSpec,
 *                                servers?:     ServerSpec[],
 *                            }
 */
readonly class PathItem implements ReferableObjectInterface
{
    use Referable;

    /**
     * @var Operation[]
     */
    public array $operations;

    public function __construct(
        public string|null    $summary     = null,
        public string|null    $description = null,
        public Operation|null $get         = null,
        public Operation|null $put         = null,
        public Operation|null $post        = null,
        public Operation|null $delete      = null,
        public Operation|null $options     = null,
        public Operation|null $head        = null,
        public Operation|null $patch       = null,
        public Operation|null $trace       = null,
        public array|null     $servers     = null,
    ) {
        $this->operations = array_filter([
            'get'     => $get,
            'put'     => $put,
            'post'    => $post,
            'delete'  => $delete,
            'options' => $options,
            'head'    => $head,
            'patch'   => $patch,
            'trace'   => $trace,
        ]);
    }

    /**
     * @param  PathItemSpec  $spec
     * @return self|Reference<self>
     */
    public static function fromSpec(array $spec): self|Reference
    {
        return self::tryFromReferenceSpec($spec) ?? new self(
            summary:     $spec['summary'],
            description: $spec['description'],
            get:         isset($spec['get'])     ? Operation::fromSpec($spec['get'])     : null,
            put:         isset($spec['put'])     ? Operation::fromSpec($spec['put'])     : null,
            post:        isset($spec['post'])    ? Operation::fromSpec($spec['post'])    : null,
            delete:      isset($spec['delete'])  ? Operation::fromSpec($spec['delete'])  : null,
            options:     isset($spec['options']) ? Operation::fromSpec($spec['options']) : null,
            head:        isset($spec['head'])    ? Operation::fromSpec($spec['head'])    : null,
            patch:       isset($spec['patch'])   ? Operation::fromSpec($spec['patch'])   : null,
            trace:       isset($spec['trace'])   ? Operation::fromSpec($spec['trace'])   : null,
            servers:     isset($spec['servers']) ? Server::fromSpecs($spec['servers'])   : null,
        );
    }
}
