<?php

namespace App\Interfaces;

interface HireServiceInterface
{
    public function hireServiceOOH(string $package_id, string $brand_id, array $states) : bool;
    public function hireServiceOrigins(string $package_id, string $brand_id, array $origins, string $medium_name) : bool;
}
