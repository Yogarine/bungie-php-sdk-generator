<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\JsonSchema;

/**
 * @phpstan-import-type vocabulary       from CoreVocabulary
 * @phpstan-import-type defs             from CoreVocabulary
 * 
 * @phpstan-import-type listOfSchema     from ApplicatorVocabulary
 * @phpstan-import-type then             from ApplicatorVocabulary
 * @phpstan-import-type dependentSchemas from ApplicatorVocabulary
 * 
 * @phpstan-type  SchemaType    Type|non-empty-list<Type>
 * @phpstan-type  number        int|float
 *
 * @phpstan-type  positive      ($type is Type::Number|Type::Integer ? positive-int|float|null : never)
 * @phpstan-type  numeric       ($type is Type::Number|Type::Integer ? number|null : never)
 *
 * @phpstan-type  maxLength     ($type is Type::String ? non-negative-int|null : never)
 * @phpstan-type  minLength     ($type is Type::String ? non-negative-int : never)
 * @phpstan-type  pattern       ($type is Type::String ? non-empty-string|null : never)
 *
 * @phpstan-type  items         ($type is Type::Array ? Schema|null : never)
 * @phpstan-type  prefixItems   ($type is Type::Array ? non-empty-list<Schema>|array{} : never)
 * @phpstan-type  numItems      ($type is Type::Array ? non-negative-int|float|null : never)
 */
readonly class Schema implements CoreVocabulary
{
    public const string VOCABULARY_CORE_URI = 'https://json-schema.org/draft/2020-12/vocab/core';
    
    /**
     * @param  string|null      $schema            The "$schema" keyword is both used as a JSON Schema dialect
     *                                             identifier and as the identifier of a resource which is itself a JSON
     *                                             Schema, which describes the set of valid schemas written for this
     *                                             particular dialect.
     * @param  vocabulary       $vocabulary        The "$vocabulary" keyword is used in meta-schemas to identify the
     *                                             vocabularies available for use in schemas described by that
     *                                             meta-schema.
     * @param  string|null      $id                The "$id" keyword identifies a schema resource with its canonical
     *                                             URI.
     * @param  string|null      $anchor            The "$anchor" keyword is an identifier keyword that can only be used
     *                                             to create plain name fragments, rather than absolute URIs as seen
     *                                             with "$id".
     * @param  string|null      $dynamicAnchor     The "$anchor" keyword is an identifier keyword that allows for
     *                                             deferring the full resolution until runtime, at which point it is
     *                                             resolved each time it is encountered while evaluating an instance.
     * @param  string|null      $ref               The "$ref" keyword is an applicator that is used to reference a
     *                                             statically identified schema. Its results are the results of the
     *                                             referenced schema.
     *                                             > **Note:** This definition of how the results are determined means
     *                                             >           that other keywords can appear alongside of "$ref" in the
     *                                             >           same schema object.
     * @param  string|null      $dynamicRef        The "$dynamicRef" keyword is an applicator that allows for deferring
     *                                             the full resolution until runtime, at which point it is resolved each
     *                                             time it is encountered while evaluating an instance.
     * @param  defs             $defs              The "$defs" keyword reserves a location for schema authors to inline
     *                                             re-usable JSON Schemas into a more general schema.
     * @param  string|null      $comment           This keyword reserves a location for comments from schema authors to
     *                                             readers or maintainers of the schema.
     *
     * @param  listOfSchema     $allOf             An instance validates successfully against this keyword if it
     *                                             validates successfully against all schemas defined by this keyword's
     *                                             value.
     * @param  listOfSchema     $anyOf             An instance validates successfully against this keyword if it
     *                                             validates successfully against at least one schema defined by this
     *                                             keyword's value.
     * @param  listOfSchema     $oneOf             An instance validates successfully against this keyword if it
     *                                             validates successfully against exactly one schema defined by this
     *                                             keyword's value.
     * @param  Schema|null      $not               An instance is valid against this keyword if it fails to validate
     *                                             successfully against the schema defined by this keyword.
     * @param  Schema|null      $if                This validation outcome of this keyword's subschema has no direct
     *                                             effect on the overall validation result. Rather, it controls which of
     *                                             the "then" or "else" keywords are evaluated.
     * @param  then             $then              When "if" is present, and the instance successfully validates against
     *                                             its subschema, then validation succeeds against this keyword if the
     *                                             instance also successfully validates against this keyword's
     *                                             subschema.
     * @param  then             $else              When "if" is present, and the instance fails to validate against its
     *                                             subschema, then validation succeeds against this keyword if the
     *                                             instance successfully validates against this keyword's subschema.
     * @param  dependentSchemas $dependentSchemas  This keyword specifies subschemas that are evaluated if the instance
     *                                             is an object and contains a certain property.
     *
     * @param  SchemaType|null  $type              An instance validates if and only if the instance is in any of the
     *                                             sets listed for this keyword.
     * @param  non-empty-list   $enum              An instance validates successfully against this keyword if its value
     *                                             is equal to one of the elements in this keyword's array value.
     * @param  mixed            $const             An instance validates successfully against this keyword if its value
     *                                             is equal to the value of the keyword.
     * @param  positive         $multipleOf        A numeric instance is valid only if division by this keyword's value
     *                                             results in an integer.
     * @param  numeric          $maximum           If the instance is a number, then this keyword validates only if the
     *                                             instance is less than or exactly equal to "maximum".
     * @param  numeric          $exclusiveMaximum  If the instance is a number, then the instance is valid only if it
     *                                             has a value strictly less than (not equal to) "exclusiveMaximum".
     * @param  numeric          $minimum           If the instance is a number, then this keyword validates only if the
     *                                             instance is greater than or exactly equal to "minimum".
     * @param  numeric          $exclusiveMinimum  If the instance is a number, then the instance is valid only if it
     *                                             has a value strictly greater than (not equal to) "exclusiveMinimum".
     * @param  maxLength        $maxLength         A string instance is valid against this keyword if its length is less
     *                                             than, or equal to, the value of this keyword.
     * @param  minLength        $minLength         A string instance is valid against this keyword if its length is
     *                                             greater than, or equal to, the value of this keyword.
     * @param  pattern          $pattern           A string instance is considered valid if the regular expression
     *                                             matches the instance successfully. Recall: regular expressions are
     *                                             not implicitly anchored.
     *                                             This string SHOULD be a valid regular expression, according to the
     *                                             ECMA-262 regular expression dialect.
     *
     * @param  prefixItems      $prefixItems       Validation succeeds if each element of the instance validates against
     *                                             the schema at the same position, if any.
     * @param  items            $items             This keyword applies its subschema to all instance elements at
     *                                             indexes greater than the length of the "prefixItems" array in the
     *                                             same schema object, as reported by the annotation result of that
     *                                             "prefixItems" keyword. If no such annotation result exists, "items"
     *                                             applies its subschema to all instance array elements.
     * @param  items            $contains          An array instance is valid against "contains" if at least one of its
     *                                             elements is valid against the given schema.
     * @param  numItems         $maxItems          An array instance is valid against "maxItems" if its size is less
     *                                             than, or equal to, the value of this keyword.
     * @param  numItems         $minItems          An array instance is valid against "minItems" if its size is greater
     *                                             than, or equal to, the value of this keyword.
     * @param  bool             $uniqueItems       If this keyword has boolean value false, the instance validates
     *                                             successfully. If it has boolean value true, the instance validates
     *                                             successfully if all of its elements are unique.
     * @param  null|int         $maxContains       An instance array is valid against "maxContains" in two ways,
     *                                             depending on the form of the annotation result of an adjacent
     *                                             "contains" keyword. The first way is if the annotation result is an
     *                                             array and the length of that array is less than or equal to the
     *                                             "maxContains" value. The second way is if the annotation result is a
     *                                             boolean "true" and the instance array length is less than or equal to
     *                                             the "maxContains" value.
     * @param  int              $minContains       An instance array is valid against "minContains" in two ways,
     *                                             depending on the form of the annotation result of an adjacent
     *                                             "contains" keyword. The first way is if the annotation result is an
     *                                             array and the length of that array is greater than or equal to the
     *                                             "minContains" value. The second way is if the annotation result is a
     *                                             boolean "true" and the instance array length is greater than or equal
     *                                             to the "minContains" value.
     */
    public function __construct(
        // The JSON Schema Core Vocabulary
        public string|null     $schema           = null,
        public array|null      $vocabulary       = [self::VOCABULARY_CORE_URI => true],
        public string|null     $id               = null,
        public string|null     $anchor           = null,
        public string|null     $dynamicAnchor    = null,
        public string|null     $ref              = null,
        public string|null     $dynamicRef       = null,
        public array|null      $defs             = [],
        public string|null     $comment          = null,
        
        // A Vocabulary for Applying Subschemas
        public array|null      $allOf            = null,
        public array|null      $anyOf            = null,
        public array|null      $oneOf            = null,
        public Schema|null     $not              = null,
        public Schema|null     $if               = null,
        public Schema|null     $then             = null,
        public Schema|null     $else             = null,
        public array|null      $dependentSchemas = null,
        
        
        
        public Type|array|null $type             = null,
        public array|null      $enum             = null,
        public mixed           $const            = null,

        public int|float|null $multipleOf       = null,
        public int|float|null $maximum          = null,
        public int|float|null $exclusiveMaximum = null,
        public int|float|null $minimum          = null,
        public int|float|null $exclusiveMinimum = null,
        public int|null       $maxLength        = null,
        public int            $minLength        = 0,
        public string|null    $pattern          = null,

        // Array-specific properties
        public array          $prefixItems      = [],
        public Schema|null    $items            = null,
        public Schema|null    $contains         = null,
        public int|null       $maxItems         = null,
        public int            $minItems         = 0,
        public bool           $uniqueItems      = false,
        public int|null       $maxContains      = null,
        public int            $minContains      = 1,

    ) {
        
    }

    public static function fromSpec(array $spec): self
    {
        // TODO: Implement fromSpec() method.
    }
}
