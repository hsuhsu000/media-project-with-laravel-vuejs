@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trend Posts</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post Title</th>
                            <th>Image</th>
                            <th>View Count</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $p)
                            <tr>
                                <td>{{ $p['postsPostId'] }}</td>
                                <td>{{ $p['postsTitle'] }}</td>
                                <td>
                                    <img class="rounded shadow" width="100px"
                                        @if ($p['postsImage'] == null) src="{{ asset('defaultImage/images.png') }}"
                                @else
                                    src="{{ asset('postImage/' . $p['postsImage']) }}" @endif>
                                </td>
                                <td>{{ $p['post_count'] }}</td>
                                <td>
                                    <a href="{{ route('admin#trendPostDetails', $p['postsPostId']) }}"><button
                                            class="btn btn-sm bg-dark text-white">Details</button></a>


                                </td>
                            </tr>
                        @endforeach


                        </tr>

                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
