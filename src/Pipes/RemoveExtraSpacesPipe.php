<?php

namespace App\Pipes;

use App\Pipeline\PipeInterface;
use Closure;

class RemoveExtraSpacesPipe implements PipeInterface
{
    public function handle(mixed $passable, Closure $next): mixed
    {
        return $next(
            preg_replace('/\s+/', ' ', $passable)
        );
    }
}
