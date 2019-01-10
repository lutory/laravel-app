@extends('layouts.admin')

@section('content')
    <h1>Posts</h1>

    @if( session('deleted_post') )
        @include('inc.flashmsg',['type'=>'success','msg'=>session('deleted_post')])
    @endif
    @if( session('edited_post') )
        @include('inc.flashmsg',['type'=>'success','msg'=>session('edited_post')])
    @endif

    @if(count($posts)>0)
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Title </th>
                <th>Body </th>
                <th>User</th>
                <th>Category</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id  }}</td>
                    <td>@if($post->photo)<img style="width: 50px;" src="{{ $post->photo->getPostImagePath($post->photo->file) }}" /> @endif </td>
                    <td><a href="{{ route('posts.edit',['id'=>$post->id]) }}">{{ $post->title }}</a></td>
                    <td style="max-width: 200px">{{ str_limit($post->body, $limit = 50, $end = '...') }}</td>
                    <td>{{ $post->user->name  }}</td>
                    <td>{{ $post->category_id  }}</td>
                    <td>{{ $post->created_at->diffForHumans()  }}</td>
                    <td>{{ ($post->updated_at) ? $post->updated_at->diffForHumans() : "-"   }}</td>
                    <td>{{$post->status == '1' ? 'Active' : 'Inactive'}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No posts yet</p>
    @endif
@endsection