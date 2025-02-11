<?php

namespace Mateffy\Magic\Chat\Widgets\Prebuilt;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Mateffy\Magic\Tools\InvokableFunction;
use Mateffy\Magic\Models\Message\FunctionInvocationMessage;
use Mateffy\Magic\Models\Message\FunctionOutputMessage;

class VideoToolWidget extends ViewToolWidget
{
    public string $view = 'llm-magic::components.tools.iframe';

    protected Closure $url;

    public function __construct(
        ?Closure $url = null,
        array $with = [],
        protected bool $useOutput = false,
    )
    {
        $this->url = $url ?? fn (FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output) => Arr::get($useOutput ? $output?->output : $invocation->call?->arguments ?? [], 'url');

        parent::__construct($this->view, $with);
    }

    public function prepare(InvokableFunction $tool, FunctionInvocationMessage $invocation, ?FunctionOutputMessage $output = null): View
    {
        if ($this->useOutput && !$output) {
            return ToolWidget::loading(loading: 'Loading...')->prepare($tool, $invocation, $output);
        }

        $url = app()->call($this->url, ['tool' => $tool, 'invocation' => $invocation, 'output' => $output]);
        $url = str($url)
            ->trim()
            ->replace('www.', '');

        $host = parse_url($url, PHP_URL_HOST);
        $allowedHosts = [
            'youtube.com',
            'youtu.be',
            'vimeo.com',
            'open.spotify.com',
            'player.twitch.tv',
        ];

        if (! $url || !str($url)->after('://')->contains('/')) {
            return ToolWidget::loading(loading: 'Loading...')->prepare($tool, $invocation, $output);
        }

        if (! in_array($host, $allowedHosts)) {
            return ToolWidget::error(error: 'Only YouTube and Vimeo links are supported.', details: "The URL you provided ({$url}) is not a valid YouTube or Vimeo link.")->prepare($tool, $invocation, $output);
        }

        if ($host === 'player.twitch.tv') {
            // Add parent=data-wizard.ai query parameter to the URL
            $query = parse_url($url, PHP_URL_QUERY);

            // Parse the query string
            parse_str($query, $queryParams);

            unset($queryParams['parent']);

            $parent = parse_url(config('app.url'), PHP_URL_HOST);
            $query = http_build_query($queryParams);

            $url = "https://player.twitch.tv/?parent={$parent}&{$query}";
        }

        return parent::prepare($tool, $invocation, $output)
            ->with('url', $url)
            ->with('aspectVideo', $host !== 'open.spotify.com');
    }

    public static function make(Closure|string|null $url = null): VideoToolWidget
    {
        return app(VideoToolWidget::class, ['url' => $url]);
    }
}
