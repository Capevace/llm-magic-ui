<?php

namespace Mateffy\Magic\Debug;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Debugger extends Component
{
    public static function getNavigationItems(): array
    {
        return [];
    }

	#[Url]
	public DebugView $view = DebugView::Combined;

    #[Url(as: 'session')]
    public ?string $logging_session_id = null;

	#[Computed]
	public function latest_session_id(): ?string
	{
		return cache('llm-magic-debugger.latest_session');
	}

	#[Computed]
	public function sessions(): Collection
	{
		return collect(Storage::disk('llm-logs')->directories())
			->map(fn (string $dir) => basename($dir))
			->sortDesc()
			->values();
	}

    #[Computed]
    public function debugger(): ?FileDebugger
    {
		if ($this->logging_session_id === '') {
			$this->logging_session_id = null;
		}

		$id = $this->logging_session_id ?? $this->latest_session_id;

        if (empty($id)) {
            return null;
        }

        return FileDebugger::load($id);
    }

    #[Computed]
    public function events(): Collection
    {
        return ($this->debugger?->getEvents() ?? collect())
            ->filter(fn (FileDebugger\DebugEvent $event) => match ($this->view) {
				DebugView::Combined => true,
				DebugView::Messages => $event->type === FileDebugger::MESSAGE,
				DebugView::Stream => $event->type === FileDebugger::DATA_PACKET,
			})
            ->map(fn (FileDebugger\DebugEvent $event) => $event->toLivewire());
    }

	public function updatedView()
	{
		unset($this->events);
	}

	#[Layout('llm-magic::components.debug.debugger-layout')]
	public function render()
	{
		return view('llm-magic::components.debug.debugger');
	}
}
