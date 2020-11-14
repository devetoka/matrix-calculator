<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatrixRequest;
use App\Services\MatrixService;
use Illuminate\Http\Request;

class MatrixController extends Controller
{
    public function __construct()
    {
    }

    public function multiply(MatrixRequest $request)
    {

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => MatrixService::multiply($request->first_matrix, $request->second_matrix)
        ]);
    }
}
