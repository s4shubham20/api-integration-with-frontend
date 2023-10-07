@extends('layouts.admin')
@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h1>Category Edit</h1>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn btn-warning">Logout</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        @if (Session::has('success'))
            {{ Session::get('success') }}
        @endif
        <form action="{{ route('dashboard.update', Crypt::encrypt($response['categories']['id'])) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $response['categories']['name']) }}" placeholder="Please enter your name here!">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $response['categories']['slug']) }}" placeholder="Please enter your slug here!">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image">Image</label>
                    @isset($response['categories']['image'])
                        <img src="{{ 'http://localhost/laravel_api/public/'.$response['categories']['image'] }}" alt="{{ $response['categories']['alt'] }}" width="100">
                    @endisset
                    <input type="file" name="image" class="form-control"/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="alt">Atl</label>
                    <input type="text" name="alt" class="form-control" value="{{ $response['categories']['alt'] }}"/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status">Status</label>
                    <input type="radio" name="status"  value="1" {{ old('status', $response['categories']['status']) == 1 ? "checked":""  }}/> Active
                    <input type="radio" name="status"  value="0" {{ old('status', $response['categories']['status']) == 0 ? "checked":""  }}/> Inactive
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $response['categories']['description'] }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $response['categories']['meta_title']) }}"/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', $response['categories']['meta_keywords']) }}"/>
                </div>
                <div class="mb-3">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" cols="5" rows="5" class="form-control">{{ $response['categories']['meta_description'] }}</textarea>
                </div>
                <div>
                    <button class="btn btn-info">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection()
