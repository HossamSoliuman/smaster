<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                {{-- <a class="nav-link btn btn-secondary btn-block mb-2" href="{{ route('cj-auths.index') }}">
                    cj auth
                </a> --}}
                <a class="nav-link btn btn-secondary btn-block mb-2" href="{{ route('orders.index') }}">
                    Orders
                </a>
                <a class="nav-link btn btn-secondary btn-block mb-2" href="{{ route('banners.index') }}">
                    Banners
                </a>
                <a class="nav-link btn btn-secondary btn-block mb-2" href="{{ route('categories.index') }}">
                    Categories
                </a>
                <a class="nav-link btn btn-secondary btn-block mb-2" href="{{ route('product.index') }}">
                    Products
                </a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="nav-link btn btn-danger btn-block mb-2">
                        Logout
                    </button>
                    </a>
                </form>
            </li>

        </ul>
    </div>
</nav>
