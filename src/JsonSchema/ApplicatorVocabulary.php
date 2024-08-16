<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\JsonSchema;

/**
 * @phpstan-type  listOfSchema     non-empty-list<Schema>
 * @phpstan-type  then             ($then is Schema ? Schema|null : never)
 * 
 * @phpstan-type  dependentSchemas ($type is Type::Object ? non-empty-array<non-empty-string,Schema>|null : never)
 *
 * @phpstan-type  prefixItems      ($type is Type::Array ? non-empty-list<Schema>|array{} : never)
 *
 * @property  listOfSchema      $allOf             An instance validates successfully against this keyword if it
 *                                                 validates successfully against all schemas defined by this keyword's
 *                                                 value.
 * @property  listOfSchema      $anyOf             An instance validates successfully against this keyword if it
 *                                                 validates successfully against at least one schema defined by this
 *                                                 keyword's value.
 * @property  listOfSchema      $oneOf             An instance validates successfully against this keyword if it
 *                                                 validates successfully against exactly one schema defined by this
 *                                                 keyword's value.
 * @property  Schema|null       $not               An instance is valid against this keyword if it fails to validate
 *                                                 successfully against the schema defined by this keyword.
 * @property  Schema|null       $if                This validation outcome of this keyword's subschema has no direct
 *                                                 effect on the overall validation result. Rather, it controls which of
 *                                                 the "then" or "else" keywords are evaluated.
 * @property  then              $then              When "if" is present, and the instance successfully validates against
 *                                                 its subschema, then validation succeeds against this keyword if the
 *                                                 instance also successfully validates against this keyword's
 *                                                 subschema.
 * @property  then              $else              When "if" is present, and the instance fails to validate against its
 *                                                 subschema, then validation succeeds against this keyword if the
 *                                                 instance successfully validates against this keyword's subschema.
 * @property  dependentSchemas  $dependentSchemas  This keyword specifies subschemas that are evaluated if the instance
 *                                                 is an object and contains a certain property.
 *
 * @property  prefixItems       $prefixItems       Validation succeeds if each element of the instance validates against
 *                                                 the schema at the same position, if any. This keyword does not
 *                                                 constrain the length of the array. If the array is longer than this
 *                                                 keyword's value, this keyword validates only the prefix of matching
 *                                                 length.
 */
interface ApplicatorVocabulary
{

}