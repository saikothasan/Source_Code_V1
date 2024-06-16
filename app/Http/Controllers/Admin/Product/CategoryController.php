<?php

namespace App\Http\Controllers\Admin\Product;

use App\Model\Category;
use App\Model\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    private $category_object;

    public function __construct()
    {
        $this->category_object = new Category;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = $this->categories();
        return view('admin.category', compact('categories'));
    }

    private function categories()
    {
        return Category::query()
            ->withCount('totalVariants')
            ->withCount('products as total_items')
            ->withCount(['availableStocks' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Stock'])
                    ->whereNull('sale_id')
                    ->whereNull('sale_detail_id')
                    ->whereNull('transfer_id');
            }])
            ->orderBy('name')
            ->paginate(100);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->category_object->fill($request->validated())->save();

        Session::flash('message', 'New Category Created Successfully!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        $categories = $this->categories();
        return view('admin.category', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);
        $category->update($validatedData);
        Session::flash('message', 'Category Updated Successfully!');

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
