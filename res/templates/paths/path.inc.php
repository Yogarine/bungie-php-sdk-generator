<?php

declare(strict_types=1);

foreach ()
?>
    public function <?= $name ?>(<?= $parameters ?>): <?= $returnType ?>
    {
        $response = $this->client-><?= $method ?>('<?= $path ?>', [
            'query' => $query,
            'json' => $json,
        ]);

        return $response->getBody()->getContents();
    }
