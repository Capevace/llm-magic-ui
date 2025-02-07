<?php

namespace Mateffy\Magic\Chat\Tools;

use Mateffy\Magic\Chat\Tool;
use Mateffy\Magic\Chat\Widgets\Prebuilt\MapToolWidget;
use Mateffy\Magic\Prebuilt\Geolocation\Tools\SearchMapboxPlaces;

class AddressLookupTool extends Tool
{
    public static function make(string $name = 'lookupAddress'): static
    {
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->callback(SearchMapboxPlaces::make($this->name))
            ->widget(MapToolWidget::make());
    }
}