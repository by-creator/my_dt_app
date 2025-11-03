<?php

namespace App\Traits;
use Carbon\Carbon;

trait ConvertsDates
{
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getDates()) && $value) {
            $value = Carbon::createFromFormat('d/m/Y H:i', $value)
                ->format('Y-m-d H:i:s');
        }
        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->getDates()) && $value) {
            return Carbon::parse($value)->format('d/m/Y H:i');
        }

        return $value;
    }
}
