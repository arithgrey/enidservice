<!doctype html>
@include('layouts.meta')
<body>
    <main>   
        <header class="shadow-lg">
            <div class="bg-blue-500 py-1">
            @include('layouts.navbar')           
            </div>
            
        </header>
         
        <div class="container mx-auto px-4">
            @yield('content')
        </div>        
    </main>
    <footer class="py-4">
        
    </footer>
</body>
</html>
