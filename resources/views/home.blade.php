<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Bootstrap Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS for Dark and Light mode -->
    <style>
        body {
            transition: background-color 0.5s;
        }

        .dark-mode body {
            background-color: #333;
            color: white;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }

        .navbar-light .navbar-nav .nav-link {
            color: black;
        }

        .navbar-nav.ml-auto {
            margin-right: 20px;
        }

        .center-vertically {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100vh;
        }

        .content {
            text-align: center;
            padding: 20px;
        }

        .payment-buttons {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand mx-auto" href="#">
            <img src="your-logo.png" alt="Logo" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                    </li>

                    @else
                    <a href="{{ route('login') }}">Log in</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                    @endif
                    @endauth
                </div>
                @endif


            </ul>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="darkModeSwitch">
                <label class="custom-control-label" for="darkModeSwitch">Dark Mode</label>
            </div>
        </div>
    </nav>

    <div class="container center-vertically">
        <div class="content">
            <h2>ZoneBook</h2>
            <p>Book your events as per Time Zone, and get notified. $40 for 100 bookings</p>
            <p>  <a href="{{ route('register') }}">Register</a> here to get first 10 Bookings free!</p>
            <div class="payment-buttons">
                <div class="col-md-4 my-2">
                    <form action="{{route('paypal.payment')}}" method="POST">
                        @csrf
                        <input type="hidden" value="40" name="price">
                        <button type="submit" class="btn btn-outline-dark flex-shrink-0" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Buy With Paypal
                        </button>
                    </form>
                </div>

                <div class="col-md-4 my-2">
                    <form action="{{route('stripe.payment')}}" method="POST">
                        @csrf
                        <input type="hidden" value="40" name="price">
                        <button type="submit" class="btn btn-outline-dark flex-shrink-0" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Buy With Stripe
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Dark mode script -->
    <script>
        const darkModeSwitch = document.getElementById('darkModeSwitch');
        darkModeSwitch.addEventListener('change', () => {
            document.body.classList.toggle('dark-mode', darkModeSwitch.checked);
        });
    </script>

</body>

</html>