<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        return KategoriModel::all();
    }

    public function show($id)
    {
        return KategoriModel::find($id);
    }

    public function store(Request $request)
    {
        $kategori = KategoriModel::create($request->all());
        return response()->json($kategori, 201);
    }

    public function update(Request $request,KategoriModel $kategori)
    {
        $kategori->update($request->all());
        return response()->json($kategori, 200);
    }

    public function destroy(KategoriModel $kategori)
    {
        $kategori->delete();
        return response()->json([
            'success' => true,
            'message' => 'Kategori deleted successfully'
        ]);
    }
}
