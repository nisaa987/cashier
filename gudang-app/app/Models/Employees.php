<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'telepon', 'email', 'departemen', 'job_title', 'foto'
    ];

    public function departemen()
    {
            return $this->belongsTo(Departemen::class, 'departemen', 'nama_departemen');
    }

}
