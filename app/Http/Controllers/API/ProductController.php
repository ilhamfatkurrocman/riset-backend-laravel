<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // all() untuk handle product index maupun product detail
    public function all(Request $request)
    {
        // variabel ($id) = mengambil field inputan id ($request->input('id');)
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        // Get data berdasarkan ID
        if ($id) {
            // Diambil dari model Product dan memanggil relasinya (Product::with(['category', 'galleries']))
            // Untuk mengambil data (find($data yang di ambil))
            $product = Product::with(['category', 'galleries'])->find($id);

            // Cek data ada atau tidak ada
            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data produk berhasil diambil'
                );

            } else {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );

            }
        }

        // Memanggil variabel baru
        $product = Product::with(['category', 'galleries']);

        // Create Filter Nama
        if ($name) {
            // Query mengambil nama produk
            $product->where('name', 'like', '%' . $name . '%');
        }

        // Create Filter Description
        if ($description) {
            // Query mengambil description produk
            $product->where('description', 'like', '%' . $description . '%');
        }

        // Create Filter Tags
        if ($tags) {
            // Query mengambil Tags produk
            $product->where('tags', 'like', '%' . $tags . '%');
        }

        // Create Filter Price From
        if ($price_from) {
            // Query mengambil Price From produk
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            // Query mengambil Price To produk
            $product->where('price', '<=', $price_to);
        }

        // Create Filter Categories
        if ($categories) {
            // Query mengambil Price To produk
            $product->where('categories', $categories);
        }

        // paginate() (Mengambil data lebih dari 1)
        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data produk berhasil diambil'
        );



    }
}
