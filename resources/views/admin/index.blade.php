@extends('layouts.admin')
@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h1>Admin Dashboard</h1>
            <form action="{{ route('logout') }}" method="post" class="d-flex">
                @csrf
                <button class="btn btn-warning">Logout</button>
                <p>{{ $result['user']['name'] }}</p>
            </form>
        </div>
    </div>
    <div class="card-body">
        @if (Session::has('success'))
            {{ Session::get('success') }}
        @endif
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($response['categories'] as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <b>Name: </b>{{ $item['name'] }}
                                <br/>
                                <b>Slug: </b>{{ $item['slug'] }}
                            </td>
                            <td>
                                @isset($item['image'])
                                    <img src="{{ 'http://localhost/laravel_api/public/'.$item['image'] }}" alt="" width="100">
                                @endisset
                            </td>
                            <td>
                                @if ($item['status'] == 1)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ date('d-M-Y H:m:s', strtotime($item['created_at'])) }}</td>
                            <td class="d-flex">
                                <a href="{{ route('dashboard.edit', Crypt::encrypt($item['id'])) }}" class="btn btn-info">Edit</a>
                                <form method="post" action="{{ route('dashboard.destroy', $item['id']) }}" class="ml-3">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
