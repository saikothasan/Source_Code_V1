<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductImage;
use App\Services\FileService;
use App\Services\ProductImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    use  ApiResponse;

    public function index(Request $request, Product $product): JsonResponse
    {
        if ($request->ajax()) {
            $images = ProductImage::query()
                ->whereProductId($request->get('product-id'))
                ->get()->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'product_id' => $data->product_id,
                        'product_barcode' => $data->product_barcode,
                        'path' => '/' . $data->photo,
                    ];
                });
            return $this->respondSuccess($images, 'Product image fetch successfully');
        }
        return abort(404);
    }

    public function create(Product $product)
    {
        return view('admin.products.image', ProductImageService::productImageResource($product));
    }

    public function store(Request $request, ProductImage $productImage)
    {
        try {
            $productImage->product_id = $request->product_id;
            $productImage->product_barcode = $request->product_barcode;
            $productImage->variation_id = $request->variation_id;
            $directory = 'images/products/' . $request->get('product_barcode') . '/';
            if ($request->hasFile('file')) {
                $productImage->photo = FileService::imageStore($request->file, $directory, $request->product_barcode);
            }
            $productImage->save();
            return $this->respondSuccess($productImage, 'Product image store successfully');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }

    public function update(Request $request, ProductImage $productImage)
    {
        try {
            $productImage = ProductImage::query()->findOrFail($request->id);
            $directory = 'images/products/' . $request->get('product_barcode') . '/';
            if ($request->hasFile('file')) {
                $productImage->photo = FileService::imageStore($request->file, $directory, $request->product_barcode, $productImage->photo);
            }
            $productImage->save();
            return $this->respondSuccess($productImage, 'Product image update successfully');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }

    public function crop(Request $request)
    {
        try {
            $productImage = ProductImage::query()->findOrFail($request->id);
            $productImage->product_id = $request->product_id;
            $directory = 'images/products/' . $request->get('product_barcode') . '/';
            if ($request->hasFile('cropped_image')) {
                $productImage->photo = FileService::imageStore(
                    $request->cropped_image,
                    $directory,
                    $request->get('product_barcode'),
                    $productImage->photo
                );
            }
            $productImage->save();
            return $this->respondSuccess($productImage, 'Product image crop successfully');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }


    }

    public function destroy(ProductImage $productImage)
    {
        FileService::imageDelete($productImage->photo);
        return $productImage->delete();
    }
}
