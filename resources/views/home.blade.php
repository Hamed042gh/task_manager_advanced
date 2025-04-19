<head>
    @livewireStyles

    <!-- لینک به فایل CSS تولیدی -->
<link rel="stylesheet" href="{{ asset('build/assets/app-BVNHUl9R.css ') }}">
<script src="{{ asset('build/assets/app-C_9rHI7Y.js') }}" defer></script>
</head>
<body>
    @auth
    @if(auth()->user()->role === 'admin')
        <h1 class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 text-center mb-6">
            <a href="/admin" class="text-white font-semibold text-xl">Admin Panel</a>
        </h1>
    @endif
@endauth

    @livewire('task')
    @livewireScripts

</body>
