<?php

namespace Mateffy\Magic\Chat\Tools\Concerns;

trait HasDetailedView
{
    protected bool|Closure $detailed = false;

    public function detailed(Closure|bool $detailed = true): static
    {
        $this->detailed = $detailed;

        return $this;
    }

    public function simple(Closure|bool $simple = true): static
    {
        $this->detailed = fn () => !$this->evaluate($simple);

        return $this;
    }

    public function isUsingDetailedView(): bool
    {
        return $this->evaluate($this->detailed);
    }
}
