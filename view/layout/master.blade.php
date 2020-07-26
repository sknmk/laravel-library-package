<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Returner Peakman</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="offset-md-2 col-md-8 py-5">
            <div class="row">
                <div class="col-12 mb-4">
                    <h1>Returner Peakman Library</h1>
                </div>
                <div class="col-12 mb-3">
                    <div class="card py-2">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link active" href="/reader/create">Create Reader</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/book/create">Create Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/book/list">Book List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/book/assign">Assign Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/book/return">Return Book</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@yield('script')
</body>
</html>
