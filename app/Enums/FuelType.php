<?php

namespace App\Enums;

class FuelType 
{

    /**
     * Get an array of years from $startYear to current year.
     *
     * @param int $startYear
     * @param bool $descending
     * @return array
     */
    public static function list(): array
    {
    
        return [
            'Petrol',
            "Diesel", 
            "Electric",
            "Hybrid",
            "PHEV",
            "Other"
        ];

    }
    

}
