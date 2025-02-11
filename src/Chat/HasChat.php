<?php

namespace Mateffy\Magic\Chat;

use Mateffy\Magic\Chat\Widgets\Basic\ToolWidget;
use Mateffy\Magic\Models\Message\Message;

interface HasChat
{
    public static function renderChatMessage(Message $message): string|ToolWidget|null;
}
