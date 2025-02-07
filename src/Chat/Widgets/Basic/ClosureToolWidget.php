<?php

namespace Mateffy\Magic\Chat\Widgets\Basic;

use Closure;
use Mateffy\Magic\Chat\Widgets\Basic\ToolWidget;
use Mateffy\Magic\Functions\InvokableFunction;
use Mateffy\Magic\LLM\Message\FunctionInvocationMessage;
use Mateffy\Magic\LLM\Message\FunctionOutputMessage;
use Throwable;

class ClosureToolWidget extends ToolWidget
{
    public function __construct(
        /** @var Closure(InvokableFunction, FunctionInvocationMessage, ?FunctionOutputMessage): string $render */
        public Closure $render,
    ) {}

    /**
     * @throws Throwable
     */
    public function render(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output = null): string
    {
        $rendered_output = app()->call($this->render, ['tool' => $tool, 'invocation' => $invocation, 'output' => $output]) ?? '';

		if ($rendered_output instanceof ToolWidget) {
			return $rendered_output->render($tool, $invocation, $output);
		}

		return $rendered_output;
    }

    /**
     * @param Closure(InvokableFunction, FunctionInvocationMessage, ?FunctionOutputMessage): string $render
     */
    public static function make(Closure $render): ClosureToolWidget
    {
        return app(ClosureToolWidget::class, ['render' => $render]);
    }
}
