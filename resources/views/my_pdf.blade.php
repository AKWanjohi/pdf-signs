<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <title>PDF Signer</title>
</head>

<body>
    <div class="container">
        <h1>Submitted Details</h1>
        <div class="row">
            <p class="col-3 fs-4 fw-semibold">
                First Name:
                <span class="fw-normal">{{ $first_name }}</span>
            </p>
            <p class="col-3 fs-4 fw-semibold">
                Last Name:
                <span class="fw-normal">{{ $last_name }}</span>
            </p>
        </div>
        <div class="row">
            <p class="col-3 fs-4 fw-semibold">
                Email:
                <span class="fw-normal">{{ $email }}</span>
            </p>
            <p class="col-3 fs-4 fw-semibold">
                Phone Number:
                <span class="fw-normal">{{ $phone_number }}</span>
            </p>
        </div>
        <div>
            <p class="fs-4 fw-semibold">Signature:</p>
            <img src="{{ $signature }}" alt="">
        </div>
    </div>
</body>

</html>
