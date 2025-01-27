<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Peminjaman extends Model
{
 use HasFactory;


 protected $fillable = [
    'judul_buku',
    'kode_buku',
    'nama_peminjam',
    'tanggal_peminjaman',
    'tanggal_pengembalian'
 ];
}
