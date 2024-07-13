<header class="header-container">
    <div class="logo-container">
        <div class="logo-icon">
            <a class="navbar-brand" href="#" id="menu-icon">
                @if(request()->is('menu'))
                <span>&#x2716;</span>
                @else
                <div class="logo-box">
                    <span>&#x25A1;</span>
                </div>
                @endif
            </a>
        </div>
        <h1 class="logo-text">Rese</h1>
    </div>

    <script>
        document.getElementById('menu-icon').addEventListener('click', function() {
            window.location.href = "{{ auth()->check() ? route('menu1') : route('menu2') }}";
        });
    </script>
</header>