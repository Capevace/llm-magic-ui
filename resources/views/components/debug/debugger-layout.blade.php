<!doctype html>
<html lang="en" class="dark">
	<head>
		<meta charset="UTF-8">
		<meta
				name="viewport"
				content="width=device-width, initial-scale=1"
		>
		<title>Debugger</title>

		{{ filament()->getTheme()->getHtml() }}
		{{ filament()->getFontHtml() }}

		@filamentStyles
		@livewireStyles
		@stack('styles')
		@yield('styles')
		@vite(['resources/css/app.css'])
		@vite(['resources/css/filament/admin/theme.css'])
		<script src="https://cdn.tailwindcss.com/"></script>
	</head>
	<body class="bg-white dark:bg-black">
		{{ $slot }}
		@yield('content')

		@stack('modals')
		@stack('scripts')
		@yield('scripts')

		@filamentScripts
		@livewireScripts
	</body>
</html>