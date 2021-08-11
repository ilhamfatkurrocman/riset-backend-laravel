<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        // variabel parameter input
        $id = $request->input('id');
        $limit = $request->input('limit', 6); // 6 untuk pembatas
        $status = $request->input('status');

        // Get data berdasarkan ID
        if ($id) {
            $transaction = Transaction::with(['items.product'])->find($id); // items.product (Mengambil relasi items dan mengambil relasi didalam items yaitu product)

            // Jika data ada
            if ($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    'Data transaction berhasil diambil'
                );

            } else {
                return ResponseFormatter::error(
                    null,
                    'Data transaction tidak ada', 404
                );

            }
        }

        // Mengambil semua data berdasarkan filter id
        $transaction = Transaction::with(['items.product'])->where('users_id', Auth::user()->id);

        if ($status) {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data list transaction berhasil diambil'
        );
    }

    // Function checkout
    public function checkout(Request $request)
    {
        // Create Validate
        $request->validate([
            'items' => 'required|array', // Items harus berupa array
            'items.*.id' => 'exists:products,id', // items.*.id (Mengecek semua item yang di checkout berdasarkan id)
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED' // Status yang ada di backend
        ]);

        // Membuat data transaction
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status,
        ]);

        // Karena Items memiliki array, maka menggunakan foreach untuk submit satu - satu ke detail transaksi
        foreach ($request->items as $product) {
            TransactionItem::create([
                'users_id' => Auth::user()->id,
                'products_id' => $product['id'], // Karena array
                'transactions_id' => $transaction->id, // Diambil dari data transaction id
                'quantity' => $product['quantity']
            ]);
        }

        return ResponseFormatter::success($transaction->load('items.product'), 'Transaction berhasil'); // load('items.product') (untuk load / memanggil kembali relasi data / refresh)

    }

}
