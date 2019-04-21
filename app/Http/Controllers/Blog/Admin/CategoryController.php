<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

/**
 * Упраление категориями блога
 * Class CategoryController
 * @package App\Http\Controllers\Blog\Admin
 */
class CategoryController extends BaseController
{
	/**
	 * @var BlogCategoryRepository
	 */
	private $blogCategoryRepository;

	public function __construct()
	{
		parent::__construct();

		$this->blogCategoryRepository = app(BlogCategoryRepository::class);
	}

	/**
     * Управление категориями блога
     *
     * @return App\Http\Controllers\Blog\Admin
     */
    public function index()
    {

		$paginator = $this->blogCategoryRepository->getAllWithPaginate(10);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$item = new BlogCategory();
		$categoryList
			= $this->blogCategoryRepository->getForComboBox();

		return view( 'blog.admin.categories.edit',
			compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
		$data = $request->input();

		//Создаст объект и добивит в БД
		$item = (new BlogCategory())->create($data);

		if ($item){
			return redirect()->route('blog.admin.categories.edit', [$item->id])
				->with(['success' => 'Успешно сохранено']);
		} else {
			return back()->withErrors(['msg' => 'Ошибка сохранения'])
				->withInput();
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

		$item = $this->blogCategoryRepository->getEdit($id);

		$v['title_before'] = $item->title;

		$item->title = 'ASDasdasdaSD asdasd 1212';

		$v['title_after'] = $item->title;
		$v['getAttribute'] = $item->getAttribute('title');
		$v['attributesToArray'] = $item->attributesToArray();
		$v['attributes'] = $item->attributes['title'];
		$v['getAttributeValue'] = $item->getAttributeValue('title');
		$v['getMutatesAttributes'] = $item->getMutatedAttributes();
		$v['hasGetMutator for title'] = $item->hasGetMutator('title');
		$v['toArray'] = $item->toArray();


		if (empty($item)) {
			abort(404);
		}
		$categoryList
			= $this->blogCategoryRepository->getForComboBox();

		return view('blog.admin.categories.edit',
			compact('item','categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogCategoryUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {

		$item = $this->blogCategoryRepository->getEdit($id);

		if (empty($item)){
			return back()
				->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
				->withInput();
		}

		$data = $request->all();
		$result = $item->update($data);

		if($result) {
			return redirect()
				->route('blog.admin.categories.edit', $item->id)
				->with(['success' => 'Успешно сохранено']);
		} else {
			return back()
				->withErrors(['msg' => 'Ошибка сохранения'])
				->withInput();
		}
    }
}
