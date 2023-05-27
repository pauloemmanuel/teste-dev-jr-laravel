<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidationMessages extends Model
{
    use HasFactory;

    public const REQUIRED = 'O campo :attribute é obrigatório !';
    public const NUMERIC = 'O campo :attribute só pode haver numeros';
    public const ALPHA_DASH = 'Foram inseridos elementos inválidos para o campo :attribute';
    public const MAX_DIGITS = 'Só são permitidos até :max digitos para o campo :attribute';
    public const DATE = 'Só são permitidos datas no campo :attribute, tente o seguinte formato: (dd-mm-yyyy ss:mm:HH)';
    public const DECIMAL = 'Só são permitidos números de até :max digitos para o campo :attribute';
    public const MAX = 'Só são permitidos valores de até :max para o campo :attribute';
    public const STRING = 'Só são permitidos strings para o campo :attribute';
}
