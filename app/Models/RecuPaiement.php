<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecuPaiement extends Model
{
    use HasFactory;


    protected $table = 'recu_paiements';

    protected $fillable = [
        'numero_recu',
        'montant',
        'date_paiement',
        'fichier_pdf',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
