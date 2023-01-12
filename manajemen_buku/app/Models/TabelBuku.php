<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabelBuku extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tabel_buku';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
