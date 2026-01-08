<header style="border-bottom:1px solid #ccc; padding:15px;">
    <strong>BUFET COFFEE</strong>

    <span style="margin-left:30px;">
        <a href="/">Home</a>
        |
        <a href="/#produk">Produk</a>
        |
        <a href="/#event">Event</a>
    </span>

    <span style="float:right;">
        @if(session()->has('user_id'))
            Welcome, <strong>{{ session('user_name') }}</strong>
            |
            <a href="/profile">Profile</a>
            |

            <!-- LOGOUT -->
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:blue;cursor:pointer;">
                    Logout
                </button>
            </form>
        @else
            <a href="/login">Login</a>
            |
            <a href="/register">Register</a>
        @endif
    </span>

    <div style="clear:both;"></div>
</header>
