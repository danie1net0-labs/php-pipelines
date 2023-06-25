<?php

declare(strict_types=1);

use App\Pipeline\Pipeline;
use App\Pipes\{AddExclamationPipe, CapitalizePipe, RemoveExtraSpacesPipe, TrimPipe};

require_once './vendor/autoload.php';

$input = '   liFE,   thE UNIVERSE aNd   EVeRyThIng    ';

$pipes = [
    TrimPipe::class,
    CapitalizePipe::class,
    RemoveExtraSpacesPipe::class,
    AddExclamationPipe::class,
];

$result = Pipeline::send($input)
    ->through($pipes)
    ->thenReturn();

echo $result . PHP_EOL;
