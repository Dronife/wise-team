<?php
// src/Enum/Genre.php
namespace App\Enum;

enum Genre: string
{
    case FICTION          = 'Fiction';
    case NON_FICTION      = 'Non-fiction';
    case SCIENCE_FICTION  = 'Science fiction';
    case FANTASY          = 'Fantasy';
    case MYSTERY          = 'Mystery';
    case THRILLER         = 'Thriller';
    case ROMANCE          = 'Romance';
    case HISTORICAL       = 'Historical';
    case BIOGRAPHY        = 'Biography';
    case CHILDREN         = 'Children';

    /** For Symfony ChoiceType */
    public static function choices(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}