<?php

namespace Mateffy\Magic\Chat;

use Mateffy\Magic\Chat\Widgets\Basic\ToolWidget;
use Mateffy\Magic\Functions\InvokableFunction;

interface ToolContainer
{
    public function getName(): string;
    public function getInvokableFunction(): InvokableFunction;
    public function getToolWidget(): ToolWidget;
}
