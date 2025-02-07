# `@mateffy/llm-magic-ui`

> [!NOTE]
> This project is still in development and not yet publicly released.

Ready-made Livewire components for use with [mateffy/llm-magic](https://github.com/capevace/llm-magic).

```php
use Mateffy\Magic\Chat\HasChat;
use Mateffy\Magic\Chat\InteractsWithChat;
use Mateffy\Magic\Chat\Tool;

class MyChatComponent extends Component implements HasChat
{
    use InteractsWithChat;
    
    protected static function getTools() : array
    {
        return [
            Tool::make('search')
                ->callback(function (string $query) {
                    return Article::where('title', 'like', "%$query%")
                        ->limit(5)
                        ->get();
                })
                ->widget(ViewToolWidget::view('components.search-results')),
        ];
    }
}
```

### Copyright and License

This project is made by [Lukas Mateffy](https://mateffy.me) and is licensed under the [GNU Affero General Public License v3.0 (AGPL-3.0)](https://choosealicense.com/licenses/agpl-3.0/).

For commercial licensing, please drop me an email at [hey@mateffy.me](mailto:hey@mateffy.me).

### Contributing

At the moment, this project is not yet open for contributions, as I am in the process of writing a thesis about it. After that is done, and the published version is tagged, I may open it up for contributions, if there is interest.

However, if you have ideas, bugs or suggestions, feel free to open an issue or start a discussion anyway! Feedback is always welcome.
