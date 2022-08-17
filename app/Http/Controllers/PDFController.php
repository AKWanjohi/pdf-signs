<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function generate_pdf(Request $request)
    {
        $filename = Str::random(10);

        $data_uri = $request->signature;
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        file_put_contents($filename . ".png", $decoded_image);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'signature' => $filename . '.png'
        ];

        $pdf = Pdf::loadView('my_pdf', $data);
        Storage::put("public/documents/" . $filename . ".pdf", $pdf->output());

        unlink($filename . '.png');

        // return Storage::download('public/documents/' . $filename . '.pdf');

        return redirect('/')->with('message', 'PDF generated successfully!');
    }
}
