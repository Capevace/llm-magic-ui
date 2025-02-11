<?php

namespace Mateffy\Magic\Chat\Widgets\Prebuilt;

use Closure;
use Illuminate\View\View;
use Mateffy\Magic\Chat\Widgets\Basic\ViewToolWidget;
use Mateffy\Magic\Tools\InvokableFunction;
use Mateffy\Magic\Models\Message\FunctionInvocationMessage;
use Mateffy\Magic\Models\Message\FunctionOutputMessage;

class LoadingToolWidget extends ViewToolWidget
{
    public string $view = 'llm-magic::components.tools.loaders.default';

    protected Closure $loading;
    protected Closure $done;

    protected Closure $loadingIcon;
    protected Closure $loadingIconColor;
    protected Closure $doneIcon;
    protected Closure $doneIconColor;

    protected Closure $variant;

    public function __construct(
        ?Closure $loading = null,
        ?Closure $done = null,
        ?Closure $loadingIcon = null,
        ?Closure $loadingIconColor = null,
        ?Closure $doneIcon = null,
        ?Closure $doneIconColor = null,
        ?Closure $variant = null,
        array $with = []
    )
    {
        $this->loading = $loading ?? fn (FunctionInvocationMessage $invocation) => "Running `" . str($invocation->call->name)->snake()->replace('_', ' ')->title() . '`...';
        $this->done = $done ?? fn () => 'Done';
        $this->loadingIcon = $loadingIcon ?? fn () => 'filament::loading-indicator';
        $this->loadingIconColor = $loadingIconColor ?? fn () => 'gray';
        $this->doneIcon = $doneIcon ?? fn () => 'heroicon-o-check-circle';
        $this->doneIconColor = $doneIconColor ?? fn () => 'success';
        $this->variant = $variant ?? fn () => 'default';

        parent::__construct($this->view, $with);
    }

    protected function prepare(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output): View
    {
        $fn = $output === null
            ? $this->loading
            : $this->done;

        $callWithArguments = fn (Closure $fn) => app()->call($fn, [
            'tool' => $tool,
            'invocation' => $invocation,
            'output' => $output,
        ]);

        $content = $callWithArguments($fn);

        return parent::prepare($tool, $invocation, $output)
            ->with('content', $content)
            ->with('loadingIcon', $callWithArguments($this->loadingIcon))
            ->with('loadingIconColor', $callWithArguments($this->loadingIconColor))
            ->with('doneIcon', $callWithArguments($this->doneIcon))
            ->with('doneIconColor', $callWithArguments($this->doneIconColor));
    }

    protected function getView(): string
    {
        $variant = app()->call($this->variant);

        return match ($variant) {
            default => 'llm-magic::components.tools.loaders.detailed',
            'simple' => 'llm-magic::components.tools.loaders.default',
        };
    }

    public static function make(
        Closure|string|null $loading = null,
        Closure|string|null $done = null,
        Closure|string|null $loadingIcon = null,
        Closure|string|null $loadingIconColor = null,
        Closure|string|null $doneIcon = null,
        Closure|string|null $doneIconColor = null,
        array $with = [],
        Closure|string $variant = 'default'
    ): LoadingToolWidget
    {
        if (is_string($loading)) {
            $loading = fn () => $loading;
        }

        if (is_string($done)) {
            $done = fn () => $done;
        }

        if (is_string($loadingIcon)) {
            $loadingIcon = fn () => $loadingIcon;
        }

        if (is_string($loadingIconColor)) {
            $loadingIconColor = fn () => $loadingIconColor;
        }

        if (is_string($doneIcon)) {
            $doneIcon = fn () => $doneIcon;
        }

        if (is_string($doneIconColor)) {
            $doneIconColor = fn () => $doneIconColor;
        }

        if (is_string($variant)) {
            $variant = fn () => $variant;
        }

        return app(LoadingToolWidget::class, [
            'loading' => $loading,
            'done' => $done,
            'loadingIcon' => $loadingIcon,
            'loadingIconColor' => $loadingIconColor,
            'doneIcon' => $doneIcon,
            'doneIconColor' => $doneIconColor,
            'with' => $with,
            'variant' => $variant
        ]);
    }
}
