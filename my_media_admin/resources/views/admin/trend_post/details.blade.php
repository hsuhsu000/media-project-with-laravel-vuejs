@extends('admin.layouts.app')

@section('content')
    <div class="col-6 offset-3 mt-5">
        <button class="btn btn-primary ml-3" onclick="history.back()">Back</button>
        <div class="card-header">
            <div class="">
                <img class="rounded shadow-sm" width="400px"
                    @if ($post['image'] == null) src="{{ asset('defaultImage/images.png') }}"
                @else src="{{ asset('postImage/' . $post['image']) }}" @endif />
            </div>
        </div>

        <div class="card-body">
            <h3>{{ $post['title'] }}</h3>
            <h3>{{ $post['description'] }}</h3>
        </div>
    </div>
@endsection
