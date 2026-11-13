<?php

namespace App\Http\Controllers;

use App\Models\PesanKontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    /** Simpan pesan dari formulir Kontak; admin membacanya di menu "Pesan Masuk". */
    public function kirim(Request $request): RedirectResponse
    {
        // Kolom tersembunyi "website" harus kosong (jebakan sederhana untuk bot spam).
        if ($request->filled('website')) {
            return back()->with('berhasil', 'Terima kasih, pesan Anda sudah kami terima.');
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'subjek' => ['nullable', 'string', 'max:150'],
            'pesan' => ['required', 'string', 'max:3000'],
        ], [], [
            'nama' => 'nama',
            'email' => 'email',
            'pesan' => 'pesan',
        ]);

        PesanKontak::create($data);

        return back()->with('berhasil', 'Terima kasih, pesan Anda sudah kami terima. Kami akan segera membalas.');
    }
}
