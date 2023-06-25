<?php

namespace App\Pipes;

use App\Pipeline\PipeInterface;
use Closure;

class TrimPipe implements PipeInterface
{
    public function handle(mixed $passable, Closure $next): mixed
    {
        return $next(
            trim($passable)
        );
    }
}
