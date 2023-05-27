<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidationMessages extends Model
{
    use HasFactory;

    public const REQUIRED = 'O campo :attribute é obrigatório.';
    public const NUMERIC = 'O campo :attribute só pode haver numeros';

    public const ALPHA_DASH = 'Foram inseridos elementos inválidos para o campo :attribute';
}
