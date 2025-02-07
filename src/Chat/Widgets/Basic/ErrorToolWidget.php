<?php

namespace Mateffy\Magic\Chat\Widgets\Basic;

use Closure;
use Illuminate\View\View;
use Mateffy\Magic\Chat\Widgets\Basic\ViewToolWidget;
use Mateffy\Magic\Functions\InvokableFunction;
use Mateffy\Magic\LLM\Message\FunctionInvocationMessage;
use Mateffy\Magic\LLM\Message\FunctionOutputMessage;

class ErrorToolWidget extends ViewToolWidget
{
    public string $view = 'llm-magic::components.tools.error';

    public function __construct(
        public string $error,
        public ?string $details = null,
        public array $with = [],
    ) {
        parent::__construct($this->view, $with);
    }

    protected function prepare(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output): View
    {
        return parent::prepare($tool, $invocation, $output)
            ->with('error', $this->error)
            ->with('details', $this->details);
    }

    public static function error(
        Closure|string|null $error = null,
        Closure|string|null $details = null,
    ): ErrorToolWidget
    {
        return app(ErrorToolWidget::class, [
            'error' => $error,
            'details' => $details,
        ]);
    }
}
