<?php

namespace Mateffy\Magic\Chat;

abstract class BaseToolContainer implements ToolContainer
{
    public function __construct(protected string $name)
    {
        $this->setUp();
    }

    protected function setUp(): void
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function evaluate(mixed $evaluate): mixed
    {
        if ($evaluate instanceof Closure) {
            return app()->call($evaluate);
        }

        return $evaluate;
    }

    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

}
