<header class="header-container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#" id="menu-icon">
        @if(request()->is('menu'))
            <span>&#x2716;</span> 
        @else
            <div class="logo-box">
                <span>&#x25A1;</span>
            </div>
        @endif
    </a>
    </nav>

    <div class="header-logo">
        <h1>Rese</h1>
    </div>

    <script>
    document.getElementById('menu-icon').addEventListener('click', function() {
        window.location.href = "{{ auth()->check() ? route('menu1') : route('menu2') }}";
    });
    </script>
</header>