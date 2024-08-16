<?php

/**
 * @var  string  $identifier  Schema identifier. {@example "User.Models.GetCredentialTypesForAccountResponse"}
 * @var  string  $namespace   Schema identifier. {@example "Bungie\User\Models"}
 * @var  string  $name        Schema identifier. {@example "GetCredentialTypesForAccountResponse"}
 * @var  array{
 *           type:                   'object',
 *           properties?:            array<string, array>,
 *           description?:           string,
 *           x-mobile-manifest-name: string,
 *       }  $schema  Schema definition.
 */

declare(strict_types=1);

use Yogarine\OpenAPI\Generator\SchemaGen;

?>
declare(strict_types=1);

namespace <?= $namespace ?>;

class <?= $name . PHP_EOL ?>
{
    /**
<?php foreach (SchemaGen::properties($schema) as $propertyName => $property): ?>
     * @param  <?= SchemaGen::docType($property) ?>  $<?= $propertyName?>
<?php if (isset($property['description'])): ?>
  <?= $property['description'] ?>
<?php endif; ?>

<?php endforeach; ?>
    */
    public function __construct(
<?php foreach (SchemaGen::properties($schema) as $propertyName => $property): ?>
        public <?= SchemaGen::type($property) ?> $<?= $propertyName?>,
<?php endforeach; ?>
    ) {}
}
