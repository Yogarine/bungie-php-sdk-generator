<?php

/**
 * @var  string  $identifier  Schema identifier. {@example "User.Models.GetCredentialTypesForAccountResponse"}
 * @var  string  $namespace   Schema identifier. {@example "Bungie\User\Models"}
 * @var  string  $name        Schema identifier. {@example "GetCredentialTypesForAccountResponse"}
 * @var  array{
 *           type:       'integer',
 *           properties: array<string, array{
 *               type:               string,
 *               items?:             array,
 *               description:        string,
 *               format?:            string,
 *               x-enum-reference?:  array{"$ref": string},
 *               x-enum-is-bitmask?: bool,
 *           }>,
 *       }  $schema  Schema definition.
 */

declare(strict_types=1);

use Yogarine\OpenAPI\Generator\SchemaGen;

?>
declare(strict_types=1);

namespace <?= $namespace; ?>;

enum <?= $name ?>: <?= SchemaGen::type($schema) . PHP_EOL ?>
{
<?php foreach ($schema['x-enum-values'] as $enumValue): ?>
<?php if (isset($enumValue['description'])): ?>

    /**
     * <?= $enumValue['description'] . PHP_EOL ?>
     */
<?php endif; ?>
    case <?= $enumValue['identifier']; ?> = <?= $enumValue['numericValue']; ?>;
<?php endforeach; ?>
}
