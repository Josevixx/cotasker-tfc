<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model {
    use HasFactory;

    protected $fillable = ['name', 'description', 'owner_id', 'join_code'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($team) {
            $team->join_code = strtoupper(Str::random(8)); // Código de 8 caracteres aleatorios
        });
    }

    // Relación con el propietario del equipo
    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relación de muchos a muchos con los usuarios del equipo
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }
}
