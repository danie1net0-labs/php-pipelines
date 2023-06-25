<?php

namespace App\Pipeline;

use Closure;

interface PipeInterface
{
    public function handle(mixed $passable, Closure $next): mixed;
}
