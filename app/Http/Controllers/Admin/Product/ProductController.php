<?php

namespace App\Http\Controllers\Admin\Product;

use App\Actions\ProductStoreAction;
use App\Actions\ProductUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Model\Product;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    use ApiResponse;

    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        /**
         * Branch Products List
         * Supplier Products List
         * Management Products List
         */
        if (isBranch()) {
            return view('admin.products.branch-product-list', ProductService::branchProducts($request));
        } elseif (isSupplier()) {
            return view('admin.products.supplier-list', ProductService::supplierList($request));
        } elseif (isMainBranch()) {
            return view('admin.products.list', ProductService::productList($request));
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.products.add', ProductService::productResource());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @param ProductStoreAction $action
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(ProductRequest $request, ProductStoreAction $action)
    {

        try {
            DB::beginTransaction();
            $saved = $action->handle($request, $this->product);
            DB::commit();

            return $this->respondCreated($saved,
                'Product added successfully'
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
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
     * @param Product $product
     * @return Application|Factory|View
     */
    public function edit(Product $product)
    {

        if (isSupplier()) {
            if ($product->supplier_id != supplierAuth()->supplier->id) {
                abort(ResponseAlias::HTTP_NOT_FOUND);
            }
        }

        return view('admin.products.edit',
            ProductService::productResource(),
            ProductService::getEditProduct($product)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @param ProductUpdateAction $action
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(ProductRequest $request, $id, ProductUpdateAction $action)
    {

        try {
            DB::beginTransaction();
            $saved = $action->handle($request, Product::findOrFail($id));
            DB::commit();
            return $this->respondCreated($saved,
                'Product updated successfully'
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
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

    public function sort($id, $sort)
    {
        return redirect()->back();
    }

    public function list()
    {
        return redirect()->back();
    }
}
