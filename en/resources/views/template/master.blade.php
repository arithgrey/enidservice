<!doctype html>
@include('template.meta')
@yield('jscss')
<body class="bg-white">
    <div id="app">        
        @include('template.navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
