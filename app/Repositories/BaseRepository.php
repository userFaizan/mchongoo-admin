<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
	
	public const NEWS_CACHE_TTL = 60 * 15;
	
	/**
	 * @param array $filters
	 * @param array $strongFilters
	 * @param array $relationFilters
	 * @param Model|null $model
	 * @return Builder
	 */
	public function findByFilters (array $filters , array $strongFilters , array $relationFilters , Model $model = null) : Builder
	{
		$filters = array_filter($filters);
		$strongFilters = array_filter($strongFilters);
		$relationFilters = array_filter($relationFilters);
		
		$entity = $model::query();
		
		foreach($filters as $column => $value) {
			$value = strtolower($value);
			$entity = $entity->whereRaw("LOWER($column) like '%$value%'");
		}
		
		foreach($strongFilters as $column => $value) {
			$entity = $entity->where($column , $value);
		}
		
		foreach($relationFilters as $relation => $filter) {
			$entity = $entity->whereHas($relation , function ($query) use ($filter) {
				if($filter['operator'] === 'LIKE') {
					$query->whereRaw("LOWER({$filter['column']}) like '%{$filter['value']}%'");
				}
				else {
					$query->where($filter['column'] , $filter['value']);
				}
			});
		}
		
		return $entity->offset($filters['page'] ?? 0);
	}
	
	public function getPaginateInformation($builder): array
	{
		return [
			'total_per_page' => $builder->perPage(),
			'current_page' => $builder->currentPage(),
			'last_page' => $builder->lastPage(),
			'total' => $builder->total(),
		];
	}
}