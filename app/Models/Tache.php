<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $primaryKey = 'num_tache';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nom_tache',
        'description',
        'assigne_a',
        'priorite',
        'statut',
    ];

    /**
     * Get the user that is assigned to the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'assigne_a', 'email');
    }
}