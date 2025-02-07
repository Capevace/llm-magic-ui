<?php

namespace Mateffy\Magic\Chat\Widgets\Basic;

use Closure;
use Illuminate\Support\Js;
use Mateffy\Magic\Functions\InvokableFunction;
use Mateffy\Magic\LLM\Message\FunctionInvocationMessage;
use Mateffy\Magic\LLM\Message\FunctionOutputMessage;
use Throwable;

abstract class ToolWidget
{
    /**
     * @throws Throwable
     */
    abstract public function render(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output = null): string;

    public function interrupts(): bool
    {
        return false;
    }
}
