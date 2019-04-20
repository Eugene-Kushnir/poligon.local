<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;


class BlogPostObserver
{
    /**
     * Отработка перед созданием записи
     *
     * @param  BlogPost  $blogPost
     */
    public function creating(BlogPost $blogPost)
    {
    	$this->setPublishedAt($blogPost);
    	$this->setSlug($blogPost);
    }

    /**
     * Обработка перед обновлением записи
     *
     * @param  BlogPost  $blogPost
     *
     */
    public function updating(BlogPost $blogPost)
    {
//        $test[]= $blogPost->isDirty();
//        $test[]= $blogPost->isDirty('is_published');
//        $test[]= $blogPost->isDirty('user_id');
//        $test[]= $blogPost->getAttribute('is_published');
//        $test[]= $blogPost->is_published;
//        $test[]= $blogPost->getOriginal('is_published');
//        dd($test);

        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
    }


	/**Если дата публицации не установлена и происходит установка флага - Опубликовано,
	 * то устанавливаем дату публикации на текущую.
	 * @param  BlogPost  $blogPost
	 */
	 protected function setPublishedAt(BlogPost $blogPost)
	 {
	 	if (empty($blogPost->published_at) && $blogPost['is_published']) {
			$blogPost['published_at'] = Carbon::now();
		}

	 }

	/**
	 * Если поле Slug пустое, то заполним его конвертацией заголовка.
	 *
	 * @param BlogPost $blogPost
	 */
	protected function 	setSlug(BlogPost $blogPost)
	{
		if (empty( $blogPost['slug'] )) {
			$blogPost['slug'] = str_slug( $blogPost['title'] );
			}


	}
    /**
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
