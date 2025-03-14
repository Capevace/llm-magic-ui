<?php

namespace Mateffy\Magic;

use Livewire\Livewire;
use Mateffy\Magic\Chat\Livewire\FakeLivewire;
use Mateffy\Magic\Chat\Livewire\StreamableMessage;
use Mateffy\Magic\Debug\Debugger;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MagicChatServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('llm-magic-ui')
            ->hasRoutes('web')
            ->hasViews('llm-magic');
    }

    public function register()
    {
        parent::register();

        Livewire::component('llm-magic.streamable-message', StreamableMessage::class);
        Livewire::component('llm-magic.fake-livewire', FakeLivewire::class);
		Livewire::component('llm-magic.debugger', Debugger::class);
    }
}
