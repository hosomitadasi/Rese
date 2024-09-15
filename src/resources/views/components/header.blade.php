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

    @if(request()->is('/'))
    <div class="search-container">
        <form action="{{ route('search') }}" method="GET">
            <div class="search-field">
                <label for="area">All area</label>
                <select name="area" id="area">
                    <option value=""></option>
                    @foreach($areas ?? '' as $area)
                    <option value="{{ $area->id }}">{{ $area->area }}</option>
                    @endforeach
                </select>
            </div>

            <div class="search-field">
                <label for="genre">All genre</label>
                <select name="genre" id="genre">
                    <option value=""></option>
                    @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->genre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="search-field">
                <input type="text" name="name" id="name" placeholder="Search…">
            </div>
        </form>
    </div>
    @endif

    <script>
        document.getElementById('menu-icon').addEventListener('click', function() {
            @if(auth()->check())
            @if(auth()->user()->hasRole('admin'))
            window.location.href = "{{ route('admin.menu') }}";
            @elseif(auth()->user()->hasRole('owner'))
            window.location.href = "{{ route('owner.menu') }}";
            @else
            window.location.href = "{{ route('home_menu') }}";
            @endif
            @else
            window.location.href = "{{ route('auth_menu') }}";
            @endif
        });
    </script>
</header>