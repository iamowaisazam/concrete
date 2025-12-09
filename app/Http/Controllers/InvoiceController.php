<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Crypt;
use App\Models\Membership;
class InvoiceController extends Controller
{
    public function view($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid invoice link');
        }

        $membership = Membership::with(['user', 'plan', 'payment'])->findOrFail($id);
        $downloadbtn = 1; // Prevent showing download in modal

        return view('invoice.view', compact('membership','downloadbtn'));
    }

public function downloadPDF($encryptedId)
{
    try {
        $id = Crypt::decryptString($encryptedId);
    } catch (\Exception $e) {
        abort(404, 'Invalid invoice link');
    }

    $membership = Membership::with(['user', 'plan', 'payment'])->findOrFail($id);
    $downloadbtn = 0;
    $html = view('invoice.view', compact('membership','downloadbtn'))->render();

    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4',
        'margin_top' => 15,
        'margin_bottom' => 15,
        'margin_left' => 15,
        'margin_right' => 15,
    ]);

    $mpdf->WriteHTML($html);
    return $mpdf->Output("invoice-{$membership->id}.pdf", "D");
}
}
