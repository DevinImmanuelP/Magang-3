<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::get();
        return response()->json([
            'status'=>true,
            'message'=>'Data Ditemukan',
            'Data'=>$data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categorydata = new Category;

        $rules = [
            'name'=>'required',
            'description'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditambahkan',
                'Data' => $validator->errors()
            ]);
        }

        $categorydata->name = $request->name;
        $categorydata->description = $request->description;
        $categorydata->is_published = $request->is_published;
        $categorydata->id = $request->id;

        $categorydata->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'Data' => $categorydata
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categorydata = Category::find($id);
        if ($categorydata) {
            return response()->json([
                'status'=>true,
                'message'=>'Data akan tampil sebagai berikut :',
                'data'=>$categorydata
            ], 200);
        } else {
            return response()->json([
                'status'=>false,
                'message'=>'Gaada Data bang',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categorydata = Category::find($id);
        if (empty($categorydata)) {
            return response()->json([
                'status'=>false,
                'message'=>'Data tidak ditemukan'
            ], 404);
        }

        $rules = [
            'name'=>'required',
            'description'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=>'Data berhasil diUpdate',
                'Data'=>$validator->errors()
            ]);
        }

        $categorydata->name = $request->name;
        $categorydata->description = $request->description;

        $post = $categorydata->save();
        return response()->json([
            'status'=>true,
            'message'=>'Data Berhasil diupdate',
            'Data'=>$post
        ]);
    }
    public function destroy(string $id)
    {
        $categorydata = Category::find($id);
        if (empty($categorydata)) {
            return response()->json([
                'status'=>false,
                'message'=>'Data tidak ditemukan'
            ], 404);
        }
        $post = $categorydata->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Data Berhasil DiHapus',
            'Data'=>$post
        ]);
    }

    //=========================================================
    //For Publish

    public function publish($id)
    {
        $post = Category::find($id);
        $post->is_published = true;
        $post->save();

        return response()->json([
            'message' => 'Post published successfully'
        ], 200);
    }

    public function unpublish($id)
    {
        $post = Category::find($id);
        $post->is_published = false;
        $post->save();

        return response()->json([
            'message' => 'Post unpublished successfully
            '], 200);
    }
}
