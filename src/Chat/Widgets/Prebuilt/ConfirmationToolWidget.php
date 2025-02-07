<?php

namespace Mateffy\Magic\Chat\Widgets\Prebuilt;

use Mateffy\Magic\Chat\Widgets\Basic\ViewToolWidget;

class ConfirmationToolWidget extends ViewToolWidget
{
    public string $view = 'llm-magic::components.tools.confirmation';

    public function __construct(string $text)
    {
        parent::__construct($this->view, ['text' => $text]);
    }

    public function interrupts(): bool
    {
        return true;
    }

    public static function make(string $text): ConfirmationToolWidget
    {
        return app(ConfirmationToolWidget::class, ['text' => $text]);
    }
}
