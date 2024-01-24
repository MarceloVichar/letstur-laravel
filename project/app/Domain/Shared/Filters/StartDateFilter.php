<?php

namespace App\Domain\Shared\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class StartDateFilter implements Filter
{
    protected string $property;

    public function __construct(string $property = 'created_at')
    {
        $this->property = $property;
    }

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->where($this->property, '>=', $value);
    }
}
