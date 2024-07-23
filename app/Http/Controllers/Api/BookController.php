<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookdata = Book::with('category')->get();
            return  response()->json([
                'status'=>true,
                'message'=>'Data Ditemukan',
                'Data'=>$bookdata
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bookdata = new Book;

        $rules = [
            'title'=>'required',
            'description'=>'required',
            'image_url'=>'required',
            'image'=>'required',
            'isbn'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditambahkan',
                'Data' => $validator->errors()
            ]);
        }

        $image = null;
        if ($request->has('image')) {
            $image = $request->image;
            $name = time() .'.'. $image->extension();
            $path = public_path('uploud');
            $image = $image->move($path, $name);
        }

        $bookdata->title = $request->title;
        $bookdata->description = $request->description;
        $bookdata->image_url = $request->image_url;
        $bookdata->image = $request->image;
        $bookdata->image = $name;
        $bookdata->isbn = $request->isbn;
        $bookdata->category_id = $request->category_id;
        $bookdata->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'Data' => $bookdata
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bookdata = Book::find($id);
        if ($bookdata) {
            return response()->json([
                'status'=>true,
                'message'=>'Data akan tampil sebagai berikut :',
                'Data'=>$bookdata
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
        $bookdata = Book::find($id);
        if (empty($bookdata)) {
            return response()->json([
                'status'=>false,
                'message'=>'Data tidak ditemukan'
            ], 404);
        }

        $rules = [
            'title'=>'required',
            'description'=>'required',
            'image_url'=>'required',
            'image'=>'required',
            'isbn'=>'required',
            'category_id'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=>'Data belum berhasil diupdate',
                'Data'=>$validator->errors()
            ], 422);
        }

        $image = null;
        if ($request->has('image')) {
            $path = public_path('uploud');
            $image = $request->image;
            $name = time() .'.'. $image->extension();
            $image = $image->move($path, $name);
        }

        $bookdata->title = $request->title;
        $bookdata->description = $request->description;
        $bookdata->image_url = $request->image_url;
        $bookdata->image = $name;
        $bookdata->isbn = $request->isbn;
        $bookdata->category_id = $request->category_id;

        $post = $bookdata->save();
        return response()->json([
            'status'=>true,
            'message'=>'Data Berhasil diupdate',
            'Data'=>$post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookdata = Book::find($id);
        if (empty($bookdata)) {
            return response()->json([
                'status'=>false,
                'message'=>'Data tidak ditemukan'
            ], 404);
        }
        $post = $bookdata->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Data Berhasil DiHapus',
            'Data'=>$post
        ]);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
