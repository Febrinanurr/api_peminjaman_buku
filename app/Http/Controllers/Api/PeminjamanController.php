<?php

namespace App\Http\Controllers\Api;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PeminjamanResource;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $peminjamans = Peminjaman::latest()->paginate(5);

        //return collection of peminjamans as a resource
        return new PeminjamanResource(true, 'List Data Peminjaman', $peminjamans);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'judul_buku'            => 'required|string|max:255',
            'kode_buku'             => 'required|integer',
            'nama_peminjam'         => 'required|string|max:255',
            'tanggal_peminjaman'    => 'required|date',
            'tanggal_pengembalian'  => 'nullable|date|after_or_equal:tanggal_peminjaman',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Errors', 'errors' => $validator->errors()], 422);
        }

        //create peminjaman
        $peminjaman = Peminjaman::create([
            'judul_buku'            => $request->judul_buku,
            'kode_buku'             => $request->kode_buku,
            'nama_peminjam'         => $request->nama_peminjam,
            'tanggal_peminjaman'    => $request->tanggal_peminjaman,
            'tanggal_pengembalian'  => $request->tanggal_pengembalian,
        ]);

        //return response
        return new PeminjamanResource(true, 'Data Peminjaman Berhasil Ditambahkan!', $peminjaman);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Peminjaman Not Found'], 404);
        }

        return new PeminjamanResource(true, 'Detail Data Peminjaman!', $peminjaman);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku'            => 'required|string|max:255',
            'kode_buku'             => 'required|integer',
            'nama_peminjam'         => 'required|string|max:255',
            'tanggal_peminjaman'    => 'required|date',
            'tanggal_pengembalian'  => 'nullable|date|after_or_equal:tanggal_peminjaman',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Errors', 'errors' => $validator->errors()], 422);
        }

        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Peminjaman Not Found'], 404);
        }

        $peminjaman->update([
            'judul_buku'            => $request->judul_buku,
            'kode_buku'             => $request->kode_buku,
            'nama_peminjam'         => $request->nama_peminjam,
            'tanggal_peminjaman'    => $request->tanggal_peminjaman,
            'tanggal_pengembalian'  => $request->tanggal_pengembalian,
        ]);

        return new PeminjamanResource(true, 'Data Peminjaman Berhasil Diubah!', $peminjaman);
    }
 
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Peminjaman Not Found'], 404);
        }

        $peminjaman->delete();

        return new PeminjamanResource(true, 'Data Peminjaman Berhasil Dihapus!', null);
    }
}