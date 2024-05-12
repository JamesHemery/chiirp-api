<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\ConvertDateTimeToUTC;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use ConvertDateTimeToUTC;
}
