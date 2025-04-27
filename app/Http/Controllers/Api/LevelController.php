<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(Request $request){
        return LevelModel::all();
    }

    public function show($id){
        return LevelModel::find($id);
    }

    public function store(Request $request){
        $level = LevelModel::create($request->all());
        return response()->json($level, 201);

    }

    public function update(Request $request,LevelModel $level){
        $level->update($request->all());
        return LevelModel::find($level);
    }

    public function destroy(LevelModel $level){
        $level->delete();
        return response()->json([
            'success' => true,
            'message' => 'Level deleted successfully'
        ]);
    }
}
