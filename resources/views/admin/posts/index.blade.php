@extends('layouts.admin')

@section('content')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h1>Posts</h1>

                @if( session('deleted_post') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('deleted_post')])
                @endif
                @if( session('edited_post') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('edited_post')])
                @endif

                {!! Form::open(['method'=>'GET','class="form-inline"']) !!}
                <div class="row">
                    <div class="form-group m-3">
                        <select class="form-control" name="category" onchange="form.submit()" >
                            <option value="0">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{$category['id']}}" @if( request('category') == $category['id'] ) selected @endif   @if( isset($category['childs']) ) disabled @endif >{{$category['name']}}</option>
                                @if( isset($category['childs']) )
                                    @foreach($category['childs'] as $child)
                                        <option value="{{$child['id']}}" @if( request('category') == $child['id'] ) selected @endif > &nbsp;&nbsp; - {{$child['name']}}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        {!! Form::select('status',['all' => 'Select Status','1'=>'Active','0'=>'Inactive'],request('status'),['class'=>'form-control','onChange'=>'form.submit()']) !!}
                    </div>

                    <div class="form-group  m-3">
                        <div class="input-group">
                            <input class="form-control" id="search" value="{{ request('search') }}"
                                   placeholder="Search title"
                                   name="search" type="text" id="search"/>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <a href="{{route("posts.index")}}" class="btn btn-dark">Clear filter</a>
                    </div>
                    <input type="hidden" value="{{request('field')}}" name="field"/>
                    <input type="hidden" value="{{request('sort')}}" name="sort"/>
                </div>
                {!! Form::close() !!}

                @if(count($posts)>0)
                    <div class="table-responsive mb-3">


                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>
                                    <a href="{{route('posts.index')}}?search={{request('search')}}&category={{request('category')}}&status={{request('status')}}&field=id&sort={{request('sort')=='asc'?'desc':'asc'}}">Id {!!request('field')=='id'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>
                                </th>
                                <th>Photo</th>
                                <th>
                                    <a href="{{route('posts.index')}}?search={{request('search')}}&category={{request('category')}}&status={{request('status')}}&field=title&sort={{request('sort')=='asc'?'desc':'asc'}}">Title {!!request('field')=='title'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>
                                </th>
                                <th>User</th>
                                <th>
                                    <a href="{{route('posts.index')}}?search={{request('search')}}&category={{request('category')}}&status={{request('status')}}&field=created_at&sort={{request('sort')=='asc'?'desc':'asc'}}">Created {!!request('field')=='created_at'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>
                                </th>
                                <th>Updated at</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id  }}</td>
                                    <td>@if($post->photo)<img src="{{ $post->photo->getPostImagePath($post->photo->file) }}"/> @endif </td>
                                    <td><a href="{{ route('posts.edit',['id'=>$post->id]) }}">{{ $post->title }}</a> </td>
                                    <td>{{ $post->user->name  }}</td>
                                    <td>{{ $post->created_at->diffForHumans()  }}</td>
                                    <td>{{ ($post->updated_at) ? $post->updated_at->diffForHumans() : "-"   }}</td>
                                    <td>@if($post->status == '1') <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Inactive</span> @endif</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $posts->links() }}
                @else
                    <p>No posts yet</p>
                @endif
            </div>
        </div>
    </div>
@endsection