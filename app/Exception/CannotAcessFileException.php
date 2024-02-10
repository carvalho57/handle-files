<?php

namespace App\Exception;

class CannotAcessFileException extends \Exception
{
    protected $message = 'Não foi possível acessar o arquivo';
}