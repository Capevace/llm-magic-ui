<?php

namespace Mateffy\Magic\Chat\Tools;

use Mateffy\Magic\Chat\Tool;
use Mateffy\Magic\Functions\InvokableFunction;

//protected static function getToolWidgets(): array
//    {
//        return [
//            'searchMapboxPlaces' => ToolWidget::map(useOutput: true),
//            'sendMail' => ToolWidget::livewire(SendMail::class),
//            'createEstate' => ToolWidget::confirmation(text: 'Are you sure you want to create an estate?'),
//            'queryAvailableRentables' => ToolWidget::map(
//                center: fn (?FunctionOutputMessage $output) => $output?->output['center'] ?? [52.5167, 13.3833],
//                markers: fn (?FunctionOutputMessage $output) => collect($output?->output['rentables'] ?? [])
//                    ->map(fn (array $rentable) => [
//                        'coordinates' => $rentable['coordinates'] ?? [52.5167, 13.3833],
//                        'label' => $rentable['name'],
//                    ]),
//                loading: ToolWidget::loading(
//                    loading: 'Finding locations...',
//                ),
//                useOutput: true,
//            ),
//            'lookupLocation' => ToolWidget::map(useOutput: true),
//            'outputMap' => ToolWidget::map(useOutput: true),
//            'outputTable' => ToolWidget::table(
//                description: 'This is a table',
//                icon: 'heroicon-o-table-cells',
//                color: 'warning',
//            ),
//
//            'outputVideo' => ToolWidget::youtube(),
//            'outputChart' => ToolWidget::chart(),
////            'indexBuckets' => new FilamentToolWidget(
////                resource: ExtractionBucketResource::class,
////                list: ListExtractionBucketsInline::class
////            ),
////            ...(new FilamentToolWidget(resource: ExtractionBucketResource::class, list: ListExtractionBucketsInline::class))->toolWidgets(),
//
//        ];
//    }
//
//    protected function getNewTools(): array
//    {
//        return [
//            ChatTool::make('searchMapboxPlaces')
//                ->fn(Magic\Prebuilt\Geolocation\Tools\SearchMapboxPlaces::callback())
//                ->ui(Magic\Chat\MapToolWidget::make()),
//
//            SearchPlaceTool::make('searchAndDisplayPlaces')
//                ->provider('mapbox')
//                ->limit(10),
//
//            ...FilamentTools::make(
//                resource: ExtractionBucketResource::class,
//                list: true,
//                create: true,
//                view: true,
//                edit: false,
//                delete: false
//            ),
//
//            ChatTool::make('sendMail')
//                ->fn(fn (string $to, string $subject, string $body) => [
//                    'to' => $to,
//                    'subject' => $subject,
//                    'body' => $body,
//                ])
//                ->ui(Magic\Chat\LivewireToolWidget::make(
//                    name: 'send-mail',
//                    props: fn (FunctionOutputMessage $output) => [
//                        'to' => $output->output['to'] ?? null,
//                        'subject' => $output->output['subject'] ?? null,
//                        'body' => $output->output['body'] ?? null,
//                    ]
//                )),
//        ];
//    }
//
//    protected function getTools(): array
//    {
//        return [
////            ...(new FilamentToolWidget(resource: ExtractionBucketResource::class, list: ListExtractionBucketsInline::class))->tools(),
//
//            /**
//             * @description The rows object parameter is a key-value pair of column slug and column value.
//             * @type $columns {"type": "object", "additionalProperties": {"type": "string"}}
//             * @description $columns Columns is an object with a column slug as the key and a column label as the value. For example: {"name": "Name", "area": "Area (m2)"}
//             * @type $rows {"type": "object"}
//             * @description $rows An object with key-value pairs of column slug and column value. For example: {"name": "Example Area", "area": 123.12}
//             */
//            'outputTable' => fn (
//                string $label,
//                string $description,
//                ?string $heroicon,
//                array $columns,
//                array $rows
//            ) => Magic::end([
//                'label' => $label,
//                'description' => $description,
//                'icon' => $heroicon,
//                'headerColumns' => $columns,
//                'rows' => $rows,
//            ]),
//
//            /**
//             * @description Calling this function will output a chart (using Chart.js) inside the chat
//             * @type $chart_js_config {"type": "object", "properties": {"type": {"type": "string"}, "data": {"type": "object"}, "options": {"type": "object"}}, "required": ["type", "data", "options"]}
//             * @description $chart_js_config The JSON object that directly passed into the Chart.js constructor. You can use all the graphs that Chart.js supports.
//             */
//            'outputChart' => function (array $chart_js_config) {
//                return [
//                    'chart_js_config' => $chart_js_config,
//                ];
//            },
//            'sendMail' => fn (string $to, string $subject, string $body) => Magic::end([
//                'to' => $to,
//                'subject' => $subject,
//                'body' => $body,
//            ]),
//            /**
//             * @description You can output a video by providing an embeddable URL to the outputVideo tool. We need the full URL, including https://. The following base URLs are supported: youtube.com, youtu.be, vimeo.com, open.spotify.com and player.twitch.tv.
//             */
//            'outputVideo' => fn (string $url) => Magic::end([
//                'url' => $url,
//            ]),
//            'findEstate' => fn (string $search) => [
//                'estates' => collect($this->estates)
//                    ->filter(function (array $estate) use ($search) {
//                        $score = 0;
//
//                        // Search with similar_text
//                        similar_text($search, $estate['name'], $score);
//
//                        if ($score >= 50) {
//                            return true;
//                        }
//
//                        similar_text($search, $estate['address'], $score);
//
//                        if ($score >= 50) {
//                            return true;
//                        }
//
//                        return false;
//                    })
//                    ->all()
//            ],
//            'createEstate' => fn (string $name, string $address, bool $runLocationAnalysis) => Magic::end([
//                'name' => $name,
//                'address' => $address,
//                'runLocationAnalysis' => $runLocationAnalysis,
//            ]),
//
//            'searchMapboxPlaces' => function (string $query, ?float $proximity_latitude, ?float $proximity_longitude) {
//                $session = Str::uuid()->toString();
//
//                $encodedQuery = urlencode($query);
//
//                $response = Http::get(
//                    "https://api.mapbox.com/search/searchbox/v1/suggest",
//                    array_filter([
//                        'q' => $query,
//                        'language' => 'en',
//                        'proximity' => ($proximity_latitude && $proximity_longitude)
//                            ? "{$proximity_longitude},{$proximity_latitude}"
//                            : null,
//                        'session_token' => $session,
//                        'access_token' => config('services.mapbox.access_token')
//                    ])
//                );
//
//                $text = $response->getBody()->getContents();
//                $json = json_decode($text, associative: true);
//
//                if ($json && $suggestions = $json['suggestions'] ?? null) {
//                    $markers = collect($suggestions)
//                        ->map(function (array $suggestion) use ($session) {
//                            $mapbox_id = $suggestion['mapbox_id'];
//
//                            $response = Http::get(
//                                "https://api.mapbox.com/search/searchbox/v1/retrieve/{$mapbox_id}",
//                                [
//                                    'language' => 'en',
//                                    'session_token' => $session,
//                                    'access_token' => config('services.mapbox.access_token')
//                                ]
//                            );
//
//                            if (!$response->ok()) {
//                                report(new \Exception('Invalid response: '.$response->json()));
//                                return null;
//                            }
//
//                            $feature = collect($response->json('features'))
//                                ->first();
//
//                            [$long, $lat] = Arr::get($feature, 'geometry.coordinates', []);
//
//                            if (! $long || ! $lat) {
//                                return null;
//                            }
//
//                            return [
//                                'coordinates' => [$lat, $long],
//                                'label' => Arr::get($feature, 'properties.name'),
//                                'color' => '#ff0000',
//                            ];
//                        })
//                        ->filter();
//
//                    return Magic::end([
//                        'center' => [$proximity_latitude, $proximity_longitude],
//                        'zoom' => 16,
//                        'markers' => $markers->all(),
//                        'js' => null,
//                    ]);
//                }
//
//                return [
//                    'response' => $json ?? $text,
//                    'params' => $params,
//                ];
//            },
//
//            'lookupLocation' => function (string $query) {
//                sleep(2);
//
//                return [
//                    'center' => [52.5167, 13.3833],
//                    'zoom' => 13,
//                    'markers' => [
//                        [
//                            'coordinates' => [52.5167, 13.3833],
//                            'label' => 'Brandenburger Tor',
//                            'color' => '#ff0000',
//                        ],
//                    ],
//                ];
//            },
////
//////                #[Description()]
//////                #[Min('markers.*.coordinates', 2)]
//////                #[Max('markers.*.coordinates', 2)]
//////                #[Type('markers', ['type' => 'array', 'items' => ['type' => 'object', 'properties' => ['coordinates' => ['type' => 'array', 'items' => ['type' => 'number']], 'label' => ['type' => 'string']]]])]
////
////            /**
////             * @type $markers {"type": "array", "items": {"type": "object", "properties": {"coordinates": {"type": "array", "items": {"type": "number"}}, "label": {"type": "string"}}}}
////             * @description $js You can write some custom Javascript code, that can directly manipulate the map, which is rendered using Leaflet. You have the `L` and `map` global variables available. `L` is the imported Leaflet library, and `map` is the Leaflet map instance.
////             */
////            'outputMap' => fn (float $latitude, float $longitude, int $zoom, array $markers, ?string $js) => [
////                'center' => [$latitude, $longitude],
////                'zoom' => $zoom,
////                'markers' => $markers,
////                'js' => $js
////            ],
////
////            'outputForm' => fn (array $jsonSchemaObject, ?array $initialData = null) => Magic::end([
////                'schema' => $jsonSchemaObject,
////                'initialData' => $initialData,
////                'actions' => [
////                    'submit' => 'Submit',
////                ]
////            ]),
////            'queryAvailableRentables' => function (array|string $location, array $areas) {
////                sleep(2);
////
////                return [
////                    'location' => $location,
////                    'center' => [52.5167, 13.3833],
////                    'rentables' => [
////                        [
////                            'id' => '1234',
////                            'name' => 'Bürofläche 1',
////                            'description' => 'Die Bürofläche ist eine große, leicht zugängliche, mit einem breiten Raum und einer großen Ausgabe für den Arbeitsplatz.',
////                            'address' => 'Am Borsigturm 100, 13507 Berlin',
////                            // We use locations around the center, but not exactly the center
////                            'coordinates' => [52.516732, 13.3838],
////                            'images' => [
////                                'https://example.com/image1.jpg',
////                                'https://example.com/image2.jpg',
////                            ],
////                            'area' => 100,
////                            'features' => ['balcony', 'terrace'],
////                            'floorplans' => [
////                                'https://example.com/floorplan1.jpg',
////                                'https://example.com/floorplan2.jpg',
////                            ],
////                            'areas' => [
////                                [
////                                    'id' => '5678',
////                                    'name' => 'Office Space',
////                                    'type' => 'office',
////                                    'area' => 100,
////                                    'features' => ['balcony', 'terrace'],
////                                    'images' => [
////                                        'https://example.com/image3.jpg',
////                                        'https://example.com/image4.jpg',
////                                    ]
////                                ],
////                            ],
////                        ],
////                        [
////                            'id' => '9876',
////                            'name' => 'Office Space 2',
////                            'description' => 'This is an office',
////                            'address' => 'Friedrichstraße 100, 10117 Berlin',
////                            'coordinates' => [52.5163, 13.38325],
////                            'images' => [
////                                'https://example.com/image3.jpg',
////                                'https://example.com/image4.jpg',
////                            ],
////                            'area' => 200,
////                            'features' => ['balcony', 'terrace'],
////                            'floorplans' => [
////                                'https://example.com/floorplan1.jpg',
////                                'https://example.com/floorplan2.jpg',
////                            ],
////                            'areas' => [
////                                [
////                                    'id' => '5678',
////                                    'name' => 'Office Space',
////                                    'type' => 'office',
////                                    'area' => 100,
////                                    'features' => ['balcony', 'terrace'],
////                                    'images' => [
////                                        'https://example.com/image3.jpg',
////                                        'https://example.com/image4.jpg',
////                                    ]
////                                ],
////                            ],
////                        ],
////                    ]
////                ];
////            },
//        ];
//    }

class TableTool extends Tool
{
    public function getInvokableFunction(): InvokableFunction
    {

    }

    public function getToolWidget(): ToolWidget
    {
        return MapToolWidget::make();
    }
}

class LookupAddressTool extends Tool
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->callback(LookupAddress::callback())
            ->widget(MapToolWidget::make());
    }
}

