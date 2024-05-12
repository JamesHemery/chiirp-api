<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Support\Carbon;

trait ConvertDateTimeToUTC
{
    /**
     * Move to UTC timezone before saving
     * Assuming all dates are saved in UTC only
     *
     * @param  mixed  $value
     * @return Carbon
     */
    protected function asDateTime($value): mixed
    {
        $value = parent::asDateTime($value);

        // any DateTime is going to be translated to UTC before saving
        return $value->timezone('UTC');
    }
}
