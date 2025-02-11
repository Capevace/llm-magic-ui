<?php

namespace Mateffy\Magic\Chat\Widgets\Basic;

use Closure;
use Illuminate\Support\Facades\Blade;
use Mateffy\Magic\Chat\Widgets\Basic\ToolWidget;
use Mateffy\Magic\Tools\InvokableFunction;
use Mateffy\Magic\Models\Message\FunctionInvocationMessage;
use Mateffy\Magic\Models\Message\FunctionOutputMessage;


class LivewireToolWidget extends ToolWidget
{
    public function __construct(
        public Closure $name,
        public Closure $props
    ) {}

    public function render(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output = null): string
    {;
        return Blade::render(<<<'BLADE'
            @livewire($name, $props)
        BLADE, [
            'name' => app()->call($this->name, [
                'tool' => $tool,
                'invocation' => $invocation,
                'output' => $output,
            ]),
            'props' => app()->call($this->props, [
                'tool' => $tool,
                'invocation' => $invocation,
                'output' => $output,
            ]),
        ]);
    }

    public static function make(Closure|string $name, Closure|array $props = []): LivewireToolWidget
    {
        if (is_string($name)) {
            $name = fn () => $name;
        }

        if (is_array($props)) {
            $props = fn () => $props;
        }

        return app(LivewireToolWidget::class, ['name' => $name, 'props' => $props]);
    }
}
