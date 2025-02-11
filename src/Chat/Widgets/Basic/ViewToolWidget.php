<?php

namespace Mateffy\Magic\Chat\Widgets\Basic;

use Illuminate\View\View;
use Mateffy\Magic\Chat\Widgets\Basic\ToolWidget;
use Mateffy\Magic\Tools\InvokableFunction;
use Mateffy\Magic\Models\Message\FunctionInvocationMessage;
use Mateffy\Magic\Models\Message\FunctionOutputMessage;
use Throwable;

class ViewToolWidget extends ToolWidget
{
    public function __construct(
        public string $view,
        public array $with = [],
    ) {}

    protected function prepare(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output): View
    {
        return view($this->getView(), $this->with)
            ->with('tool', $tool)
            ->with('invocation', $invocation)
            ->with('output', $output);
    }

    protected function getView(): string
    {
        return $this->view;
    }

    /**
     * @throws Throwable
     */
    public function render(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output = null): string
    {
        return $this->prepare($tool, $invocation, $output)->render() ?? '';
    }

    public static function view(string $view, array $with = []): ViewToolWidget
    {
        return app(ViewToolWidget::class, ['view' => $view, 'with' => $with]);
    }
}
