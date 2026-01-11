<header style="padding:15px; border-bottom:1px solid #ccc;">
    <strong>BUFET COFFEE</strong>

    <span style="margin-left:30px;">
        <a href="/">Home</a> |
        <a href="/tentang">Tentang</a> |
        <a href="/menu">Produk</a> |
        <a href="/event">Event</a>
    </span>

    <span style="float:right;">
        @if(session('user_id'))
            Welcome, <strong>{{ session('user_name') }}</strong> |
            <a href="/profile">Profile</a> |

            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="border:none; background:none; color:blue; cursor:pointer;">
                    Logout
                </button>
            </form>
        @else
            <a href="/login">Login</a> |
            <a href="/register">Register</a>
        @endif
    </span>
</header>
