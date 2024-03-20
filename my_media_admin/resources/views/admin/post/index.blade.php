@extends('admin.layouts.app')

@section('content')
    <div class="col-4">
        <div class="card">

            <div class="card-body">
                <form method="POST" action="{{ route('admin#createPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Post Name</label>
                        <input type="text" name="postName" class="form-control" value="{{ old('postName') }}">
                        @error('postName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Description</label>
                        <textarea name="postDescription" id="" cols="30" rows="10" class="form-control">{{ old('postDescription') }}</textarea>
                        @error('postDescription')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="postImage" value="{{ old('postImage') }}">
                        @error('postImage')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Category Name</label>
                        <select name="postCategory" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($category as $c)
                                <option value="{{ $c['category_id'] }}">{{ $c['title'] }}</option>
                            @endforeach
                        </select>
                        @error('postCategory')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
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
            @if (Session::has('updateSuccess'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('updateSuccess') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-header">
                <h3 class="card-title">Post</h3>

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
                            <th>Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($post as $p)
                            <tr>
                                <td>{{ $p['post_id'] }}</td>
                                <td>{{ $p['title'] }}</td>
                                <td><img class="rounded shadow-sm" width="100px"
                                        @if ($p['image'] == null) src="{{ asset('defaultImage/images.png') }}"
                                        @else
                                        src="{{ asset('postImage/' . $p['image']) }}" @endif>
                                </td>

                                <td>
                                    <a href="{{ route('admin#updatePostPage', $p['post_id']) }}"><button
                                            class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                                    <a href="{{ route('admin#deletePost', $p['post_id']) }}"><button
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
