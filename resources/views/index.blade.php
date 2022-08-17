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
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <title>PDF Signer</title>

    {{-- <style>
        .signature-pad {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            font-size: 10px;
            width: 100%;
            height: 100%;
            max-width: 700px;
            max-height: 460px;
            border: 1px solid #e8e8e8;
            background-color: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
            border-radius: 4px;
            padding: 16px;
        }

        .signature-pad::before,
        .signature-pad::after {
            position: absolute;
            z-index: -1;
            content: "";
            width: 40%;
            height: 10px;
            bottom: 10px;
            background: transparent;
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.4);
        }

        .signature-pad::before {
            left: 20px;
            -webkit-transform: skew(-3deg) rotate(-3deg);
            transform: skew(-3deg) rotate(-3deg);
        }

        .signature-pad::after {
            right: 20px;
            -webkit-transform: skew(3deg) rotate(3deg);
            transform: skew(3deg) rotate(3deg);
        }

        .signature-pad--body {
            position: relative;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            border: 1px solid #f4f4f4;
        }

        .signature-pad--body canvas {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.02) inset;
        }

        .signature-pad--footer {
            color: #C3C3C3;
            text-align: center;
            font-size: 1.2em;
            margin-top: 8px;
        }

        .signature-pad--actions {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            margin-top: 8px;
        }
    </style> --}}
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand mb-0 h1">PDF Signer</span>
        </div>
    </nav>

    <div class="container">
        @if (session('message'))
            <div class="alert alert-success mt-2">
                {{ session('message') }}
            </div>
        @endif

        <form class="mt-2" method="POST" action="{{ route('generate-pdf') }}">
            @csrf
            <div class="row">
                <div class="mb-3 col">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name">
                </div>
                <div class="mb-3 col">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3 col">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number">
                </div>
            </div>
            <label class="form-label">Signature</label>
            <textarea name="signature" id="signature" hidden></textarea>
            <div id="signature-pad" class="signature-pad mt-2">
                <div class="signature-pad--body">
                    <canvas style="border: 1px solid #9b9b9b"></canvas>
                </div>
                <div class="signature-pad--footer">
                    <div class="signature-pad--actions">
                        <div>
                            <button type="button" class="btn btn-sm btn-danger" data-action="clear">Clear</button>
                            <button type="button" class="btn btn-sm btn-warning" data-action="undo">Undo</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <button type="submit" class="btn btn-primary btn-block col">Submit</button>
            </div>
        </form>

    </div>

    <script>
        const wrapper = document.getElementById("signature-pad");

        const canvas = wrapper.querySelector("canvas");
        const clearButton = wrapper.querySelector("[data-action=clear]");
        const undoButton = wrapper.querySelector("[data-action=undo]");

        const signaturePad = new SignaturePad(canvas);

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            signaturePad.clear();

            // If you want to keep the drawing on resize instead of clearing it you can reset the data.
            // signaturePad.fromData(signaturePad.toData());
        }

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;
        resizeCanvas();

        clearButton.addEventListener("click", () => {
            signaturePad.clear();
        });

        undoButton.addEventListener("click", () => {
            const data = signaturePad.toData();

            if (data) {
                data.pop(); // remove the last dot or line
                signaturePad.fromData(data);
            }
        });

        const form = document.querySelector('form');
        const signature = document.getElementById('signature');

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            signature.value = signaturePad.toDataURL();

            form.submit();
        })
    </script>
</body>

</html>
