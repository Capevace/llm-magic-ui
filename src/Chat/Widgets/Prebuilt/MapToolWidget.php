<?php

namespace Mateffy\Magic\Chat\Widgets\Prebuilt;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Js;
use Illuminate\View\View;
use Mateffy\Magic\Chat\Widgets\Basic\ViewToolWidget;
use Mateffy\Magic\Tools\InvokableFunction;
use Mateffy\Magic\Models\Message\FunctionInvocationMessage;
use Mateffy\Magic\Models\Message\FunctionOutputMessage;

class MapToolWidget extends ViewToolWidget
{
    public string $view = 'llm-magic::components.tools.map';

    protected Closure $label;
    protected Closure $description;
    protected Closure $icon;
    protected Closure $chevronIcon;
    protected Closure $color;
    protected Closure $center;
    protected Closure $zoom;
    protected Closure $markers;
    protected Closure $loading;
    protected Closure $js;

    public function __construct(
        ?Closure $label = null,
        ?Closure $description = null,
        ?Closure $icon = null,
        ?Closure $chevronIcon = null,
        ?Closure $color = null,
        ?Closure $center = null,
        ?Closure $zoom = null,
        ?Closure $markers = null,
        ?Closure $loading = null,
        ?Closure $js = null,
        protected bool $useOutput = false,
    )
    {
        $get = fn (string $key, mixed $default) =>
            fn (FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output) =>
                Arr::get($this->useOutput ? $output?->output : $invocation->call?->arguments ?? [], $key, $default);

        $this->label = $label ?? $get('label', __('Map'));
        $this->description = $description ?? $get('description', null);
        $this->icon = $icon ?? $get('icon', null);
        $this->chevronIcon = $chevronIcon ?? $get('chevronIcon', 'heroicon-o-chevron-down');
        $this->color = $color ?? $get('color', 'gray');
        $this->center = $center ?? $get('center', null);
        $this->zoom = $zoom ?? $get('zoom', null);
        $this->markers = $markers ?? $get('markers', []);
        $this->loading = $loading ?? fn () => ToolWidget::loading(loading: 'Preparing map...');
        $this->js = $js ?? $get('js', null);

        parent::__construct($this->view);
    }

    protected function prepare(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output): View
    {
        $app = app();
        $make = fn (Closure $fn) => $app->call($fn, ['tool' => $tool, 'invocation' => $invocation, 'output' => $output]);

        return parent::prepare($tool, $invocation, $output)
            ->with('label', $make($this->label))
            ->with('description', $make($this->description))
            ->with('icon', $make($this->icon))
            ->with('chevronIcon', $make($this->chevronIcon))
            ->with('color', $make($this->color))
            ->with('center', $make($this->center))
            ->with('zoom', $make($this->zoom))
            ->with('markers', $make($this->markers))
            ->with('loading', $make($this->loading))
            ->with('js', $make($this->js));
    }

    public function render(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output = null): string
    {
        if ($output) {
            return parent::render($tool, $invocation, $output);
        }

        return app()
            ->call($this->loading, ['tool' => $tool, 'invocation' => $invocation, 'output' => $output])
            ->render($tool, $invocation, $output);
    }

    public static function make(
        Closure|array|null $center = null,
        Closure|int|null $zoom = null,
        Closure|array|null $markers = null,
        Closure|string|null $label = null,
        Closure|string|null $description = null,
        Closure|string|null $icon = null,
        Closure|string|null $chevronIcon = null,
        Closure|string|null $color = null,
        Closure|ToolWidget|null $loading = null,
        Closure|Js|string|null $js = null,
        bool $useOutput = false,
    ): MapToolWidget
    {
        if (is_array($center)) {
            $center = fn() => $center;
        }

        if (is_int($zoom)) {
            $zoom = fn() => $zoom;
        }

        if (is_array($markers)) {
            $markers = fn() => $markers;
        }

        if (is_string($label)) {
            $label = fn() => $label;
        }

        if (is_string($description)) {
            $description = fn() => $description;
        }

        if (is_string($icon)) {
            $icon = fn() => $icon;
        }

        if (is_string($chevronIcon)) {
            $chevronIcon = fn() => $chevronIcon;
        }

        if (is_string($color)) {
            $color = fn() => $color;
        }

        if ($loading instanceof ToolWidget) {
            $loading = fn() => $loading;
        }

        if (is_string($js)) {
            $js = fn() => new Js($js);
        }

        if ($js instanceof Js) {
            $js = fn() => $js;
        }

        return app(MapToolWidget::class, [
            'center' => $center,
            'zoom' => $zoom,
            'markers' => $markers,
            'label' => $label,
            'description' => $description,
            'icon' => $icon,
            'chevronIcon' => $chevronIcon,
            'color' => $color,
            'useOutput' => $useOutput,
            'loading' => $loading,
            'js' => $js,
        ]);
    }
}
