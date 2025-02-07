<?php

namespace Mateffy\Magic\Chat\Tools;

use Mateffy\Magic\Chat\Tool;
use Mateffy\Magic\Chat\MapToolWidget;
use Mateffy\Magic\Chat\TableToolWidget;
use Mateffy\Magic\Prebuilt\Geolocation\Tools\SearchMapboxPlaces;

class AddressLookupTool extends Tool
{
    public static function make(string $name = 'outputTable'): static
    {
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->callback(
                /**
                 * @description Output a table to the user
                 * @type $columns {"type":"array","items":{"type":"string"}}
                 * @type $rows {"type":"array","items":{"type":"array","items":{"type":"string"}}}
                 */
                function (array $columns, array $rows) {
                    return [
                        'columns' => $columns,
                        'rows' => $rows,
                    ];
                }
            )
            ->widget(TableToolWidget::make());
    }
}