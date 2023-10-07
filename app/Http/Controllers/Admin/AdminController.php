<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function usertoken()
    {
        $token = session()->get('access_token');
        return $token;
    }

    public function index()
    {
        $result = Http::withToken($this->usertoken())->get('http://localhost/laravel_api/public/api/users');
        $category = Http::withToken($this->usertoken())->get('http://localhost/laravel_api/public/api/category');
        $response = json_decode((string) $category->getBody(), true);
        return view('admin.index', compact('response','result'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = $request->file('image');
        $result = Http::withToken($this->usertoken())->get('http://localhost/laravel_api/public/api/users');
        Http::withToken($this->usertoken())->attach(
            'image',
            file_get_contents($image->path()),
            $image->getClientOriginalName()
        )->post('http://localhost/laravel_api/public/api/category',[
            'name'             =>       $request->name,
            'user_id'          =>       $result['user']['id'],
            'slug'             =>       $request->slug,
            'alt'              =>       $request->alt,
            'image'            =>       $image->getClientOriginalName(),
            'status'           =>       $request->status,
            'description'      =>       $request->description,
            'meta_title'       =>       $request->meta_title,
            'meta_keywords'    =>       $request->meta_keywords,
            'meta_description' =>       $request->meta_description,
        ]);
        return redirect('/admin/dashboard')->with('success', 'Successfully Added !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $eid)
    {
        $id = Crypt::decrypt($eid);
        $category = Http::withToken(self::usertoken())->get('http://localhost/laravel_api/public/api/category/'.$id);
        $response = json_decode((string) $category->getBody(), true);
        return view('admin.edit', compact('response'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $eid)
    {
        $id = Crypt::decrypt($eid);
        $token = session()->get('access_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagepath = $image->path();
        }else{
            $imagepath = null;
        }
        $response = Http::withToken($token)->attach(
            'image',
            file_get_contents($imagepath),
            $image->getClientOriginalName()
        )->post('http://localhost/laravel_api/public/api/category/'.$id,[
            '_method'           => 'PUT',
            'name'              => $request->name,
            'slug'              => $request->slug,
            'description'       => $request->description,
            'image'             => $image->getClientOriginalName(),
            'alt'               => $request->alt,
            'status'            => $request->status,
            'meta_title'        => $request->meta_title,
            'meta_keywords'     => $request->meta_keywords,
            'meta_description'  => $request->meta_description,
        ]);
        return $response;
        return redirect()->back()->with('success' ,'Successfully Updated !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = Http::withToken($this->usertoken())->delete('http://localhost/laravel_api/public/api/category/'.$id);
        if($response->status() == 200) {
            return $response['success'];
            return redirect()->back()->with();
          } else {
            dd('Sorry, something went wrong.');
          }
    }
}
