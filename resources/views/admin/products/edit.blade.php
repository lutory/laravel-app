@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin">
        <div class="card">

            <div class="card-body">
                <h1>Edit product <em>{{$product->title}}</em></h1>
                <hr>
                {!! Form::model($product,['method' => 'PATCH','action' => ['AdminProductsController@update',$product->id],'files'=> true, 'class'=>'d-inline']) !!}

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

                {{--<div class="form-group">--}}
                {{--{!! Form::label('category_id', 'Category') !!}--}}
                {{--{!! Form::select('category_id', $categories, null,['placeholder' => 'Choose a category','class'=>'form-control']); !!}--}}
                {{--{!! $errors->first('category_id','<p class="text-danger">:message</p>') !!}--}}
                {{--</div>--}}

                <div class="form-group">
                    {!! Form::label('status', 'Status<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], 1,['class'=>'form-control']); !!}
                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Featured Image',['class'=>'custom-file-label']) !!}
                </div>

                {{ Form::hidden('tags[]', null, array('id' => 'tagsIds')) }}
                {{ Form::hidden('gallery[]', null, array('id' => 'imagesPaths')) }}

                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit product</button>

                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE','action' => ['AdminProductsController@destroy',$product->id],'id'=>'deleteProductForm', 'class'=>'d-inline float-right']) !!}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete"
                        data-form="deleteProductForm" data-title="Delete Product"
                        data-message="Are you sure you want to delete this product ?"><i class="fas fa-trash"></i> Delete
                    product
                </button>
                {!! Form::close() !!}
            </div>
        </div>


        <div class="card mt-3">

            <div class="card-body">
                <h2>Comments</h2>
                @if( count($product->comments) > 0 )
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm mb-3">
                            <thead>
                            <tr>
                                <th>Body</th>
                                <th>User</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td width="60%" style="white-space: normal">{{ $comment->body  }}</td>
                                    <td>{{ $comment->user->name  }}</td>
                                    <td>{{ $comment->created_at->toDateTimeString()  }}</td>
                                    <td align="center">@if($comment->status == '1') <span
                                                class="badge badge-success">Active</span> @else <span
                                                class="badge badge-danger">Inactive</span> @endif
                                        <a href="#" data-id="{{ $comment->id  }}" data-status="{{ $comment->status  }}" class="changeStatus d-block mt-1">Change status</a>
                                    </td>
                                    <td><button data-id="{{ $comment->id  }}" type="button" class="deleteComment btn btn-icons btn-outline-danger"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $comments->links() }}
                    </div>
                @else
                    <p>No comments for this product.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin ">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Featured Image:</h5>
                <img width="100%"
                     src="{{ ($product->photo) ?  $product->photo->getProductImagePath($product->photo->file) : "/images/default.png"}}"
                     alt="">

            </div>
        </div>
        <div class="card mt-3">

            <div class="card-body">

                <h5 class="card-title">Tags for product:</h5>
                <div id="productTags">
                    @foreach($product->tags as $tag)
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

                    @if($product->images)
                        <div class="images-preview" id="galleryHolder">
                            @foreach($product->images as $image)
                                <span>
                                <img src="{{asset($image->path)}}" data-src="{{$image->path}}" alt="">
                                <i class="fas fa-trash-alt remove-image"></i>
                            </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="input-group d-inline">
                       <span class="input-group-btn">
                         <a id="addImageToGallery" class="btn btn-primary"
                            style="color: #fff;padding: 9px 7px; width: 100%;">
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

            // Change comment status

            $(".changeStatus").on('click ', function (ev) {

                ev.preventDefault();
                var thisChangeA = $(this);

                $.ajax({
                    method: "POST",
                    url: "/admin/comments/change-status",
                    dataType: 'json',
                    data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'id': thisChangeA.data('id'),'status': thisChangeA.data('status')}
                })
                    .done(function (res) {
                        var newStatus = res.comment.status;

                        var statusHtml = '<span class="badge badge-danger">Inactive</span>';
                        if(newStatus==1){
                            statusHtml = '<span class="badge badge-success">Active</span>';
                        }
                        thisChangeA.prev('span').remove();
                        thisChangeA.before(statusHtml);
                        thisChangeA.data('status',newStatus);
                    });
                //}

            });

            // Delete comment

            $(".deleteComment").on('click ', function (ev) {
                var thisDel = $(this);
                $.ajax({
                    method: "POST",
                    url: "/admin/comment/delete",
                    dataType: 'json',
                    data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'id': $(this).data('id')}
                })
                    .done(function (res) {
                        thisDel.parents('tr').remove();
                    });
                //}

            });


            // Add gallery images to product

            var selectedGalleryPaths = [];
            $("#galleryHolder span img").each(function () {
                selectedGalleryPaths.push($(this).data('src'));
            });
            $('#imagesPaths').val(selectedGalleryPaths);

            $("#addImageToGallery").on('click', fileManagerGallery);

            function fileManagerGallery() {
                var route_prefix = '/laravel-filemanager';
                window.open(route_prefix + '?type=image', 'FileManager', 'width=900,height=600');
                window.SetUrl = function (file_path) {
                    var rawSrc = file_path.replace(document.location.origin + '/', '');
                    $('#galleryHolder').append('<span><img data-src="' + rawSrc + '" src="' + file_path + '" alt=""><i class="fas fa-trash-alt remove-image"></i></span>');
                    selectedGalleryPaths.push(rawSrc);
                    $('#imagesPaths').val(selectedGalleryPaths);
                };
                return false;

            }

            $('#galleryHolder').on('click', '.remove-image', function () {

                var removePath = $(this).prev().data('src');
                selectedGalleryPaths.splice($.inArray(removePath, selectedGalleryPaths), 1);
                $('#imagesPaths').val(selectedGalleryPaths);
                $(this).parent().remove();
            });

            // Add tags to product

            var selectedTagsIds = [];
            $("#productTags a").each(function () {
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
