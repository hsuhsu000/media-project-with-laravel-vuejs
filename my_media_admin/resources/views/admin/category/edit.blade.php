@extends('admin.layouts.app')

@section('content')
    <div class="col-4">
        <div class="card">

            <div class="card-body">
                <form method="POST" action="{{ route('admin#categoryUpdate', $updateData['category_id']) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="categoryName" class="form-control"
                            value="{{ old('categoryName', $updateData['title']) }}">
                        @error('categoryName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Description</label>
                        <textarea name="categoryDescription" id="" cols="30" rows="10" class="form-control">{{ old('categoryDescription', $updateData['description']) }}</textarea>
                        @error('categoryDescription')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin#category') }}"><button type="button" class="btn btn-dark">Create</button></a>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            @if (Session::has('deleteSuccess'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('deleteSuccess') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-header">
                <h3 class="card-title">Category</h3>

                <div class="card-tools">
                    <form action="{{ route('admin#searchCategory') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="categorySearch" class="form-control float-right"
                                placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $c)
                            <tr>
                                <td>{{ $c['category_id'] }}</td>
                                <td>{{ $c['title'] }}</td>
                                <td>{{ $c['description'] }}</td>

                                <td>
                                    <a href="{{ route('admin#categoryEditPage', $c['category_id']) }}"><button
                                            class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                                    <a href="{{ route('admin#deleteCategory', $c['category_id']) }}"><button
                                            class="btn btn-sm bg-danger text-white"><i
                                                class="fas fa-trash-alt"></i></button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
