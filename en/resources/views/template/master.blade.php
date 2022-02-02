<!doctype html>
@include('template.meta')
<body class="bg-white">
    <div id="app">        
        @include('template.navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
