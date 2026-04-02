<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Novo padrão de acessores

class Viagens extends Model
{
    use HasFactory;

    protected $table = 'viagens';

    protected $fillable = [
        'solicitante','origem','destino','data_ida','data_volta','status','user_id','enabled'
    ];

    protected $casts = [
        'data_ida'   => 'date',
        'data_volta' => 'date',
        'enabled'    => 'boolean',
    ];

    // Acessor para gerar um código legível do tipo VGM-0001, VGM-0002, etc.
    protected function codigo(): Attribute
    {
        return Attribute::make(
            get: fn () => 'VGM-' . str_pad($this->id, 4, '0', STR_PAD_LEFT),
        );
    }

    //solicitante da viagem, origem, destino, data_ida, data_volta, status e user_id (relacionamento com usuário)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}