@extends('layouts.admin')

@section('content')
    <h1>Create post</h1>

    {!! Form::open(['method' => 'POST','action' => 'AdminPostsController@store','files'=> true]) !!}
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    {!! Form::label('title', 'Title') !!}
                    {!! Form::text('title', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('title','<p class="error-message">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('body', 'Body') !!}
                    {!! Form::textarea('body', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('body','<p class="error-message">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'Category') !!}
                    {!! Form::select('category_id', $categories, null,['placeholder' => 'Choose a category','class'=>'form-control']); !!}
                    {!! $errors->first('category_id','<p class="error-message">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('photo_id', 'Featured Image') !!}
                    {!! Form::file('photo_id',['class'=>'form-control-file']); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], 1,['class'=>'form-control']); !!}
                </div>

                {{ Form::hidden('tags[]', null, array('id' => 'tagsIds')) }}

                <button type="submit" class="btn btn-primary">Create Post</button>
            </div>
            <div class="col-4">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Tags for post:</h5>
                        <div id="postTags"></div>

                        <hr>
                        <h6>Search tag</h6>
                        <input type="text" id="tagSearch" class="form-control" />
                        <div id="searchTags" class="mt-3">
                            @foreach($tags as $id => $name)
                                <a href="#"  data-id="{{$id}}" class="tag-badge badge badge-primary">{{$name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}


@endsection
@section('scripts')
    <script>
    $(document).ready( function(){

        var selectedTagsIds = [];
        $("#tagSearch").on('keyup ', function() {
            var search = $(this).val();
            $('#searchTags a').hide();
            $('#searchTags a').each(function () {
                if($(this).is(':contains("' + search + '")')){
                    $(this).show();
                }
            });
        });

        $("#searchTags").on('click','a',function (ev) {
            ev.preventDefault();
            var id = $(this).data('id');
            var name = $(this).text();
            selectedTagsIds.push(id);
            $("#postTags").append('<a href="#" data-name="'+name+'" data-id="'+id+'"  class="badge badge-success">'+name+' <i class="fas fa-times"></i></a>');
            $(this).remove();
            $("#tagsIds").val(selectedTagsIds);
        });
        $("#postTags").on('click','a',function (ev) {
            ev.preventDefault();
            var deletedId = $(this).data('id');
            var deletedName = $(this).data('name');
            selectedTagsIds.splice( $.inArray(deletedId, selectedTagsIds), 1 );
            $(this).remove();
            $("#searchTags").append('<a href="#" data-id="'+deletedId+'" class="tag-badge badge badge-primary">'+deletedName+'</a>');
            $("#tagsIds").val(selectedTagsIds);
        });


    } );
    </script>
@endsection