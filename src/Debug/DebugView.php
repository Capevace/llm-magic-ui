<?php

namespace Mateffy\Magic\Debug;

enum DebugView: string
{
	case Combined = 'combined';
	case Messages = 'messages';
	case Stream = 'stream';
}