@extends('layouts.admin')

@section('links')
    <link rel="stylesheet" href="/css/vendor/jquery-ui.min.css" />
@endsection
@section('content')

    <div class="col-md-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h1>{{ucfirst($type)}} Categories</h1>
                <hr>

                @if(count($categories)>0)
                    <div class="menu-box">
                        <ul class="menu-list sortable">
                            @foreach($categories as $category)

                            <li class="clearfix" data-name="{{$category['name']}}" data-id="{{$category['id']}}">
                                <p class="float-left mb-0">
                                    @if( isset( $category['childs'] ) )
                                        <a href="javascript:void(0)" class="btn btn-sm btn-dark open-cat"><i class="fas fa-plus"></i></a>
                                    @endif
                                    {{--@if($category['photo'])<img src="/images/categories/{{ $category['photo']['file'] }}"/> @endif--}}
                                    <a href="{{route($type.'.categories.edit',$category['id'])}}">{{$category['name']}}</a>
                                    @if($category['status'] == '1') <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Inactive</span>@endif
                                    @if( !isset( $category['childs'] ) )
                                        <span class="badge badge-dark">{{ count($category[$type]) . " ".$type }}</span>
                                    @endif
                                </p>
                                <div class="handles float-right">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-dark move-cat"><i class="fas fa-arrows-alt"></i></a>
                                </div>

                                @if( isset( $category['childs'] ) )
                                <ul class="submenu-list ">
                                    @foreach($category['childs'] as $child)
                                        <li class="clearfix" data-name="{{$child['name']}}"  data-id="{{$child['id']}}">
                                            <p class="float-left mb-0">
                                                <a href="{{route($type.'.categories.edit',$child['id'])}}">{{$child['name']}}</a>
                                                @if($child['status'] == '1') <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Inactive</span>@endif
                                                <span class="badge badge-dark">{{ count($child[$type]) . " ".$type }}</span>
                                            </p>
                                            <div class="handles float-right">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-dark  move-cat"><i class="fas fa-arrows-alt"></i></a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>

                            @endforeach
                        </ul>
                    </div>
                    <button id="toArray" class="btn btn-primary mt-3" > <i class="fas fa-save"></i> Save reorder <img class="btn-spinner" src="/images/loader.gif"/> </button>

                @else
                <p>No categories yet</p>
                @endif

            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h2>Add category</h2>
                {!! Form::open(['method' => 'POST','action' => 'AdminCategoriesController@store','files'=> true]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('body', 'Body') !!}
                    {!! Form::textarea('body', null,["class"=>"form-control tiny-mce"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('parent_id', 'Parent Category') !!}
                    {!! Form::select('parent_id', $mainCategories, null,['placeholder' => 'Choose a parent category','class'=>'form-control']); !!}
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], 1,['class'=>'form-control']); !!}
                </div>
                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Category Image',['class'=>'custom-file-label']) !!}
                </div>
                <button type="submit"  class="add-category btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add category</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="/js/vendor/jquery-ui.min.js"></script>
<script>


    $(document).ready(function(){

        $( ".sortable" ).sortable({handle: '.move-cat'});
        $( ".submenu-list" ).sortable({handle: '.move-cat'});

        $(".open-cat").on('click',function () {
            $(this).parent().siblings('.submenu-list').slideToggle();
        });


        $('#toArray').on('click', function(e){
            var saveOrderBtn = $(this);
            saveOrderBtn.find(".btn-spinner").show();
            var ul = $(".sortable>li");
            var list=[];
            $(ul).each(function ( index ) {
                var mainLi=$(this);
                var id=mainLi.data('id');
                var childrenArr=[];
                if (mainLi.has('ul li').length) {
                    $(this).find('ul li').each(function (i) {
                        var childId=$(this).data('id');
                        childrenArr.push({'id':childId,'order':++i})
                    })
                }
                list.push({'id':id,'children':childrenArr,'order':++index});

            })

            $.ajax({
                method: "POST",
                url: "/admin/categories/reorder",
                dataType: 'json',
                data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'list': JSON.stringify(list) }
            }).done(function( res ) {
                saveOrderBtn.find(".btn-spinner").hide();
            });

        });


        $("#search").on('keyup ', function(){

            var search = $(this).val();

            //if(search.length>1){
                $.ajax({
                    method: "POST",
                    url: "/admin/post-categories/search",
                    dataType: 'json',
                    data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'search': search }
                })
                .done(function( res ) {

                    if(res.categories.length>0){
                        $("#noSearchResult").hide();
                        var table = $("#categoriesTable");
                        table.show();
                        var output = '';
                        table.find('tbody').empty();

                        $.each(res.categories, function( index, cat ) {

                            output += '<tr>' +
                                      '<td>'+cat.id+'</td>' +
                                      '<td><a href="/admin/post-categories/'+cat.id+'/edit">'+cat.name+'</a></td>' +
                                      '<td>'+cat.posts.length+'</td>' +
                                      '</tr>';
                        });
                        table.find('tbody').html(output);
                    }
                    else{

                        $("#categoriesTable").hide();
                        $("#noSearchResult").find('em').text(search);
                        $("#noSearchResult").show();
                    }
                });
            //}

        });

    });

</script>
@endsection
