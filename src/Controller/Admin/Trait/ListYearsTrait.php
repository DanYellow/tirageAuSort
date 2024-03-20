<?php

namespace App\Controller\Admin\Trait;

trait ListYearsTrait
{
    public function generateYears(): array
    {
        $result = [];

        foreach (range(2023, 2045) as $value) {
            $result[$value] = $value;
        }

        return $result;
    }
}
