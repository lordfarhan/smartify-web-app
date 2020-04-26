<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Smartify</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            #content {
                text-align: center;
                pointer-events: none;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                /* color: #f0f8ff; */
                color: azure;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                pointer-events: all;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #particles-js {
                position: fixed;
                width: 100%;
                height: 100%;
                background-color: rgb(8, 6, 17);
                left: 0px;
                top: 0px;
            }
        </style>
    </head>
    <body>
        <div id="particles-js"></div> 

        <div id="content" class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div id="header-links" class="top-right links">
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <img src="{{asset("storage/home/smartify.png")}}" width="400" alt="Smartify Logo">
                </div>

                <div id="links" class="links">
                    <a href="https://codeiva.com">From Codeiva</a>
                </div>
            </div>
            
        </div>

        <script src="{{asset("js/particles.min.js")}}"></script>
        <script src="{{asset("js/particles.js")}}"></script>
    </body>
</html>
