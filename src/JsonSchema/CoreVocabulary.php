<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\JsonSchema;

/**
 * @phpstan-type  vocabulary  array<non-empty-string, bool>
 * @phpstan-type  defs        non-empty-array<non-empty-string, Schema>|null
 *
 * @property  string|null      $schema            The "$schema" keyword is both used as a JSON Schema dialect
 *                                                identifier and as the identifier of a resource which is itself a JSON
 *                                                Schema, which describes the set of valid schemas written for this
 *                                                particular dialect.
 * @property  vocabulary       $vocabulary        The "$vocabulary" keyword is used in meta-schemas to identify the
 *                                                vocabularies available for use in schemas described by that
 *                                                meta-schema.
 * @property  string|null      $id                The "$id" keyword identifies a schema resource with its canonical
 *                                                URI.
 * @property  string|null      $anchor            The "$anchor" keyword is an identifier keyword that can only be used
 *                                                to create plain name fragments, rather than absolute URIs as seen
 *                                                with "$id".
 * @property  string|null      $dynamicAnchor     The "$anchor" keyword is an identifier keyword that allows for
 *                                                deferring the full resolution until runtime, at which point it is
 *                                                resolved each time it is encountered while evaluating an instance.
 * @property  string|null      $ref               The "$ref" keyword is an applicator that is used to reference a
 *                                                statically identified schema. Its results are the results of the
 *                                                referenced schema.
 *                                                > **Note:** This definition of how the results are determined means
 *                                                >           that other keywords can appear alongside of "$ref" in the
 *                                                >           same schema object.
 * @property  string|null      $dynamicRef        The "$dynamicRef" keyword is an applicator that allows for deferring
 *                                                the full resolution until runtime, at which point it is resolved each
 *                                                time it is encountered while evaluating an instance.
 * @property  defs             $defs              The "$defs" keyword reserves a location for schema authors to inline
 *                                                re-usable JSON Schemas into a more general schema.
 * @property  string|null      $comment           This keyword reserves a location for comments from schema authors to
 *                                                readers or maintainers of the schema.
 */
interface CoreVocabulary
{

}
