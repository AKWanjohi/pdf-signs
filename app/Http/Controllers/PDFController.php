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
        Storage::put("public/images/" . $filename . ".png", $decoded_image);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'signature' => Storage::path('public\\images\\' . $filename . '.png'),
        ];

        $pdf = Pdf::loadView('my_pdf', $data);
        $pdf->save($filename . '.pdf');

        return view('my_pdf', $data);

        Storage::move(public_path($filename . '.pdf'), 'public/documents/' . $filename . '.pdf');

        Storage::delete('public/images/' . $filename . '.png');

        Storage::download('/storagepublic/documents/' . $filename . '.pdf');

        return redirect('/generate_pdf')->with('message', 'PDF generated successfully!');
    }
}
