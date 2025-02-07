<?php

namespace Mateffy\Magic\Chat;

use Closure;
use Mateffy\Magic\Chat\BaseToolContainer;
use Mateffy\Magic\Chat\Tools\Concerns\HasDetailedView;
use Mateffy\Magic\Chat\Widgets\Basic\ClosureToolWidget;
use Mateffy\Magic\Chat\Widgets\Basic\ToolWidget;
use Mateffy\Magic\Chat\Widgets\Prebuilt\LoadingToolWidget;
use Mateffy\Magic\Functions\Concerns\ToolProcessor;
use Mateffy\Magic\Functions\InvokableFunction;
use ReflectionException;

class Tool extends BaseToolContainer
{
    use HasDetailedView;

    protected InvokableFunction $callback;
    protected ToolWidget $widget;

    protected function setUp(): void
    {
        $this
            ->widget(LoadingToolWidget::make(variant: fn () => $this->isUsingDetailedView() ? 'detailed' : 'simple'));
    }

    /**
     * @throws ReflectionException
     */
    public function callback(Closure|InvokableFunction $fn): static
    {
        if ($fn instanceof Closure) {
            $this->callback = app(ToolProcessor::class)->processFunctionTool($this->name, $fn);
        } else {
            $this->callback = $fn;
        }

        return $this;
    }

    public function widget(Closure|ToolWidget $widget): static
    {
        if ($widget instanceof ToolWidget) {
            $this->widget = $widget;
        } else {
            $this->widget = ClosureToolWidget::make($widget);
        }

        return $this;
    }


    public function getInvokableFunction(): InvokableFunction
    {
        return $this->callback;
    }

    public function getToolWidget(): ToolWidget
    {
        return $this->widget;
    }
}
