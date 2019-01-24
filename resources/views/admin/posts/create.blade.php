@extends('layouts.admin')

@section('content')


    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h1>Create post</h1>
                <hr>
                {!! Form::open(['method' => 'POST','action' => 'AdminPostsController@store','files'=> true]) !!}
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
                    {!! Form::select('category_id', $categories, null,['placeholder' => 'Choose a category','class'=>'form-control']); !!}
                    {!! $errors->first('category_id','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], 1,['class'=>'form-control']); !!}
                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Featured Image',['class'=>'custom-file-label']) !!}
                </div>

                {{ Form::hidden('tags[]', null, array('id' => 'tagsIds')) }}
                {{ Form::hidden('gallery[]', null, array('id' => 'imagesPaths')) }}

                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Post</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card">

            <div class="card-body">
                <h4>Tags</h4>
                <div id="postTags"></div>

                <hr>
                <h6>Search or a tag</h6>
                <input type="text" id="tagSearch" class="form-control"/>
                <div id="searchTags" class="mt-3">
                    @foreach($tags as $id => $name)
                        <a href="#" data-id="{{$id}}" class="tag-badge badge badge-primary">{{$name}}</a>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h4>Gallery</h4>
                <hr>

                <div class="image-upload-holder">

                    <div class="images-preview" id="galleryHolder">

                    </div>

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
    @include('inc.admin.tinyMce')



    <script>

        $(document).ready(function () {

            // Add gallery images to post

            var selectedGalleryPaths = [];
            $("#addImageToGallery").on('click',fileManagerGallery);

            function fileManagerGallery(){
                var route_prefix = '/laravel-filemanager';
                window.open(route_prefix + '?type=image', 'FileManager', 'width=900,height=600');
                window.SetUrl = function (file_path) {
                    console.log(file_path);
                    $('#galleryHolder').append('<span><img src="'+file_path+'" alt=""><i class="fas fa-trash-alt remove-image"></i></span>');
                    selectedGalleryPaths.push(file_path.replace(document.location.origin+'/',''));
                    $('#imagesPaths').val(selectedGalleryPaths);
                };
                return false;
            }

            $('#galleryHolder').on('click','.remove-image',function () {
                $(this).parent().remove();
                var removePath=$(this).prev().attr('src');
                selectedGalleryPaths.splice($.inArray(removePath, selectedGalleryPaths), 1);
                $('#imagesPaths').val(selectedGalleryPaths);
            });

            // Add tags to post

            var selectedTagsIds = [];

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