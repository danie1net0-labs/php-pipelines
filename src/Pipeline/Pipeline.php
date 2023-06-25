<?php

namespace App\Pipeline;

use Closure;
use InvalidArgumentException;

class Pipeline
{
    protected mixed $passable;

    /** @var PipeInterface[] */
    protected array $pipes;

    protected string $method = 'handle';

    public static function send(mixed $passable): static
    {
        $pipeline = new static;

        $pipeline->passable = $passable;

        return $pipeline;
    }

    public function through(array $pipes): static
    {
        $this->pipes = $pipes;

        return $this;
    }

    public function then(Closure $destination): mixed
    {
        $pipeline = array_reduce(
            array_reverse($this->pipes),
            $this->carry(),
            static fn ($passable) => $destination($passable)
        );

        return $pipeline($this->passable);
    }

    public function thenReturn(): mixed
    {
        return $this->then(fn (mixed $passable) => $passable);
    }

    protected function carry(): Closure
    {
        return function (Closure $stack, mixed $pipe) {
            return fn ($passable) =>  match (true) {
                is_callable($pipe) => $pipe($passable, $stack),
                is_object($pipe) => $pipe->{$this->method}($passable, $stack),
                is_string($pipe) && class_exists($pipe) => (new $pipe)->{$this->method}($passable, $stack),
                default => throw new InvalidArgumentException('Invalid pipe type.'),
            };
        };
    }
}
