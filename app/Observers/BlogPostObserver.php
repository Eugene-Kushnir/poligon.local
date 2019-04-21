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
    	$this->setHtml($blogPost);
    	$this->setUser($blogPost);
    }

    /**
     * Обработка перед обновлением записи
     *
     * @param  BlogPost  $blogPost
     *
     */
    public function updating(BlogPost $blogPost)
    {
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
	 * Установка значения полю content_html относительно поля content_raw.
	 * @param BlogPost $blogPost
	 */
	protected function setHtml(BlogPost $blogPost)
	{
		if ($blogPost->isDirty('content_raw')) {
			// TODO: Тут должна быть генерация markdown -> html
			$blogPost->content_html = $blogPost->content_raw;
		}
	}

	/**
	 * Если не указан user_id, то устанавливаем пользователя по-умолчанию
	 * @param BlogPost $blogPost
	 */
	protected function setUser(BlogPost $blogPost) {
		$blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;

	}

	/**
	 * @param  \App\Models\BlogPost  $blogPost
	 * @return void
	 */
	public function deleting(BlogPost $blogPost)
	{
		//dd(__METHOD__,$blogPost);
		return true;
	}

    /**
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        // 	dd(__METHOD__,$blogPost);
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
