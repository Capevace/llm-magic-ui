@props([
    /** @var InvokableFunction $tool */
    'tool',

    /** @var \Mateffy\Magic\Models\Message\FunctionInvocationMessage $invocation */
    'invocation',

    /** @var ?\Mateffy\Magic\Models\Message\FunctionOutputMessage $output */
    'output' => null,

    /** @var string $error */
    'error',

    /** @var ?string $details */
    'details' => null,
])


<x-llm-magic::tools.dropdown
		:label="$error"
		description="An error occurred while running the tool."
		icon="heroicon-o-exclamation-triangle"
		color="danger"
>
	<p class="text-sm text-danger-500 dark:text-danger-400">
		{{ $details ?? $error }}
	</p>
	</x-tools.dropdown>
