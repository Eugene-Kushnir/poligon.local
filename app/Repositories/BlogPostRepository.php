<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


/**
 * Class BlogPostRepository
 *
 * @package App/Repositories
 */
class BlogPostRepository extends CoreRepository
{
	/**
	 * @return srting
	 */
	protected function getModelClass()
	{
		return Model::class;
	}

	/**
	 * Получить сптсок статей для вывода в списке (Админка)
	 *
	 * @return LengthAwarePaginator
	 */
	public function getAllWithPaginate()
	{
		$columns = [
			'id',
			'title',
			'slug',
			'is_published',
			'published_at',
			'user_id',
			'category_id',
		];

		$result = $this->startConditions()
			->select( $columns )
			->orderBy( 'id', 'DESC' )
//			->with(['category', 'user'])
				->with([
					 // Можно так
					'category' => function($query) {
					$query->select(['id', 'title']);
					},
					 // или так
					 'user:id,name',
				])
			->paginate(25);


		return $result;
	}

}