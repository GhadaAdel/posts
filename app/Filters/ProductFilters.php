<?php

namespace App\Filters;

use App\Helpers\QueryFilter;

class ProductFilters extends QueryFilter
{
    public function brandId($brandId = null)
    {
        return $this->builder->where('brand_id', $brandId);
    }
}