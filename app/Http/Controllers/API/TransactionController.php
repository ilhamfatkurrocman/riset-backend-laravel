<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
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
}
