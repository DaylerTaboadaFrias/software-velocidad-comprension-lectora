<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Role extends Enum
{
    const Fotografo = 'Fotografo';
    const Organizacion = 'Organizacion';
    const Admin = 'Admin';
    const Cliente = 'Cliente';
}
