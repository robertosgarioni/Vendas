<html>
    <head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Sistema de Gestão LIFE ERP</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
        .baixado{
            background: #90EE90;
        }

        .nbaixado{
             background: #ADD8E6;
        }

        
        </style>
    </head>
<body>
    <div class="container-fluid">
        @component('componente_navbar', [ "current" => $current ])
        @endcomponent
        <main role="main">
            @hasSection('body')
                @yield('body')
            @endif
        </main>
    </div>
    <footer>
         @component('footer')
                @yield('footer')
            @endcomponent
    </footer>

    
    
    <script src="{{ asset('js/app.js')}}" type="text/javascript"></script>
    
    @hasSection('javascript')
        @yield('javascript')
    @endif
</body>
</html>