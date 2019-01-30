@extends('layouts.admin')
@section('content')

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1>Create product</h1>
                <hr>
                {!! Form::open(['method' => 'POST','action' => 'AdminProductsController@store','files'=> true]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Title<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::text('title', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('title','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-4 pl-0">
                                {!! Form::label('price', 'Price<span class="text-danger">*</span>',[],false) !!}
                                {!! Form::number('price', null,["class"=>"form-control","step"=>"0.01"]) !!}
                                {!! $errors->first('price','<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('old_price', 'Old Price') !!}
                                {!! Form::number('old_price', null,["class"=>"form-control","step"=>"0.01"]) !!}
                                {!! $errors->first('old_price','<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="col-4 pr-0">
                                {!! Form::label('quantity', 'Quantity<span class="text-danger">*</span>',[],false) !!}
                                {!! Form::number('quantity', null,["class"=>"form-control"]) !!}
                                {!! $errors->first('quantity','<p class="text-danger">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('body', 'Body<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::textarea('body', null,["class"=>"form-control tiny-mce"]) !!}
                    {!! $errors->first('body','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-6 pl-0">
                                {!! Form::label('status', 'Status<span class="text-danger">*</span>',[],false) !!}
                                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], 1,['class'=>'form-control']); !!}
                            </div>
                            <div class="col-6 pr-0">

                            </div>

                        </div>
                    </div>

                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Featured Image',['class'=>'custom-file-label']) !!}
                </div>

                {{ Form::hidden('categories[]', null, array('id' => 'catsIds')) }}
                {{ Form::hidden('tags[]', null, array('id' => 'tagsIds')) }}
                {{ Form::hidden('gallery[]', null, array('id' => 'imagesPaths')) }}

                <button type="submit" data-target="#alert" data-message="Select at least one category" id="addItem" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card">

            <div class="card-body">
                <h4>Categories<span class="text-danger">*</span></h4>
                <hr>
                @if( count($categories)>0)
                    <div class="categories-list">

                        <ul class="main-categories">
                            @foreach($categories as $category)
                            <li>
                                <label> @if(!isset($category['childs'])) <input type="checkbox" data-id="{{$category['id']}}" /> @endif {{$category['name']}}</label>
                                @if( isset($category['childs']) )
                                    <ul class="main-categories">
                                    @foreach( $category['childs'] as $child)
                                        <li><label><input type="checkbox" data-id="{{$child['id']}}">{{$child['name']}}</label></li>
                                    @endforeach
                                    </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p>No categories yet.</p>
                @endif


            </div>
        </div>
        <div class="card mt-3">

            <div class="card-body">
                <h4>Tags</h4>
                <div id="productTags"></div>

                <hr>
                <h6>Search for a tag</h6>
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
    @include('inc.alertmodal')
    <script>

        $(document).ready(function () {

            // Add checked categories ids to form

            var selectedCatsIds = [];

            $(".categories-list input").on('change', function (ev) {
                var id = $(this).data('id');
                var idx = $.inArray(id, selectedCatsIds);
                if (idx == -1) {
                    selectedCatsIds.push(id);
                } else {
                    selectedCatsIds.splice(idx, 1);
                }
                $("#catsIds").val(selectedCatsIds);
            });

            // Check or categories before submit

            $("#addItem").on('click', function (ev) {
                ev.preventDefault();
                if( selectedCatsIds.length<1 ){
                    $("#alert").modal('show');
                }
                else{
                    $(this).closest('form').submit();
                }
            });

            // Add gallery images to product

            var selectedGalleryPaths = [];
            $("#addImageToGallery").on('click',fileManagerGallery);

            function fileManagerGallery(){
                var route_prefix = '/laravel-filemanager';
                window.open(route_prefix + '?type=image', 'FileManager', 'width=900,height=600');
                window.SetUrl = function (file_path) {
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

            // Add tags to product

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
                $("#productTags").append('<a href="#" data-name="' + name + '" data-id="' + id + '"  class="badge badge-success">' + name + ' <i class="fas fa-times"></i></a>');
                $(this).remove();
                $("#tagsIds").val(selectedTagsIds);
            });

            $("#productTags").on('click', 'a', function (ev) {
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