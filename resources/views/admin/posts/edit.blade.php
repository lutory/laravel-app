@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h1>Edit post <em>{{$post->title}}</em></h1>
                <hr>
                {!! Form::model($post,['method' => 'PATCH','action' => ['AdminPostsController@update',$post->id],'files'=> true, 'class'=>'d-inline']) !!}

                <div class="form-group">
                    {!! Form::label('title', 'Title') !!}
                    {!! Form::text('title', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('title','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('body', 'Body') !!}
                    {!! Form::textarea('body', null,["class"=>"form-control tiny-mce"]) !!}
                    {!! $errors->first('body','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'Category') !!}
                    {!! Form::select('category_id', $categories, null,['placeholder' => 'Pick a category','class'=>'form-control']); !!}
                    {!! $errors->first('category_id','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], null,['class'=>'form-control']); !!}
                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Featured Image',['class'=>'custom-file-label']) !!}
                </div>

                {{ Form::hidden('tags[]', null, array('id' => 'tagsIds')) }}
                {{ Form::hidden('gallery[]', null, array('id' => 'imagesPaths')) }}

                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit post</button>

                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE','action' => ['AdminPostsController@destroy',$post->id],'id'=>'deletePostForm', 'class'=>'d-inline float-right']) !!}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete"
                        data-form="deletePostForm" data-title="Delete Post"
                        data-message="Are you sure you want to delete this post ?"><i class="fas fa-trash"></i> Delete post
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin ">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Featured Image:</h5>
                <img width="100%"
                     src="{{ ($post->photo) ?  $post->photo->getPostImagePath($post->photo->file) : "/images/profile/default.jpg"}}"
                     alt="">

            </div>
        </div>
        <div class="card mt-3">

            <div class="card-body">

                <h5 class="card-title">Tags for post:</h5>
                <div id="postTags">
                    @foreach($post->tags as $tag)
                        <a href="#" data-name="{{$tag->name}}" data-id="{{$tag->id}}"
                           class="tag-badge badge badge-success">{{$tag->name}} <i class="fas fa-times"></i></a>
                    @endforeach
                </div>
                <hr>
                <h6>Search tag</h6>
                <input type="text" id="tagSearch" class="form-control"/>
                <div id="searchTags" class="mt-3">
                    @foreach($tags as $tag)
                        <a href="#" data-id="{{$tag->id}}" class="tag-badge badge badge-primary">{{$tag->name}} </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mt-3">

            <div class="card-body">
                <h5 class="card-title">Gallery</h5>
                <hr>

                <div class="image-upload-holder">

                    @if($post->images)
                        <div class="images-preview" id="galleryHolder">
                        @foreach($post->images as $image)
                            <span>
                                <img src="{{asset($image->path)}}" data-src="{{$image->path}}" alt="">
                                <i class="fas fa-trash-alt remove-image"></i>
                            </span>
                        @endforeach
                        </div>
                    @endif

                    <div class="input-group d-inline">
                       <span class="input-group-btn">
                         <a id="addImageToGallery" class="btn btn-primary" style="color: #fff;padding: 9px 7px; width: 100%;">
                           <i class="fas fa-image"></i> Add image
                         </a>
                       </span>

                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @include('inc.deletemodal')
    @include('inc.admin.tinyMce')
    <script>
        $(document).ready(function () {


            // Add gallery images to post

            var selectedGalleryPaths = [];
            $("#galleryHolder span img").each(function(){
                selectedGalleryPaths.push($(this).data('src'));
            });
            $('#imagesPaths').val(selectedGalleryPaths);

            $("#addImageToGallery").on('click',fileManagerGallery);

            function fileManagerGallery(){
                var route_prefix = '/laravel-filemanager';
                window.open(route_prefix + '?type=image', 'FileManager', 'width=900,height=600');
                window.SetUrl = function (file_path) {
                    var rawSrc = file_path.replace(document.location.origin+'/','');
                    $('#galleryHolder').append('<span><img data-src="'+rawSrc+'" src="'+file_path+'" alt=""><i class="fas fa-trash-alt remove-image"></i></span>');
                    selectedGalleryPaths.push(rawSrc);
                    $('#imagesPaths').val(selectedGalleryPaths);
                };
                return false;

            }

            $('#galleryHolder').on('click','.remove-image',function () {

                var removePath=$(this).prev().data('src');
                selectedGalleryPaths.splice($.inArray(removePath, selectedGalleryPaths), 1);
                $('#imagesPaths').val(selectedGalleryPaths);
                $(this).parent().remove();
            });

            // Add tags to post

            var selectedTagsIds = [];
            $("#postTags a").each(function(){
                selectedTagsIds.push($(this).data('id'));
            });
            $("#tagsIds").val(selectedTagsIds);

            $("#tagSearch").on('keyup ', function () {
                var search = $(this).val();
                $('#searchTags a').hide();
                $('#searchTags a').each(function () {
                    if ($(this).is(':contains("' + search + '")')) {
                        $(this).show();
                    }
                });
            });

            $("#searchTags").on('click', 'a', function (ev) {
                ev.preventDefault();
                var id = $(this).data('id');
                var name = $(this).text();
                selectedTagsIds.push(id);
                $("#postTags").append('<a href="#" data-name="' + name + '" data-id="' + id + '"  class="badge badge-success">' + name + ' <i class="fas fa-times"></i></a>');
                $(this).remove();
                $("#tagsIds").val(selectedTagsIds);
            });
            $("#postTags").on('click', 'a', function (ev) {
                ev.preventDefault();
                var deletedId = $(this).data('id');
                var deletedName = $(this).data('name');
                selectedTagsIds.splice($.inArray(deletedId, selectedTagsIds), 1);
                $(this).remove();
                $("#searchTags").append('<a href="#" data-id="' + deletedId + '" class="tag-badge badge badge-primary">' + deletedName + '</a>');
                $("#tagsIds").val(selectedTagsIds);
            });


        });
    </script>
@endsection
