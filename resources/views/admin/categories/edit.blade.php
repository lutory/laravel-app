@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h1>Edit category <em>{{$category->name}}</em></h1>
                <hr>

                {!! Form::model($category,['method' => 'PATCH','action' => ['AdminCategoriesController@update',$category->id],'files'=> true]) !!}
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

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-6 pl-0">
                                {!! Form::label('status', 'Status<span class="text-danger">*</span>',[],false) !!}
                                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'],null,['class'=>'form-control']); !!}
                            </div>
                            <div class="col-6 pr-0">
                                @if( $category->parent_id == 0 && $children == 0 )
                                    {!! Form::label('parent_id', 'Parent Category') !!}
                                    {!! Form::select('parent_id', $mainCategories, null,['placeholder' => 'Choose a parent category','class'=>'form-control']); !!}
                                @elseif($category->parent_id != 0)
                                    @php  $noChildArrayOption=[]; $noChildArrayOption['0'] = 'Make it a main category';$cats = $noChildArrayOption + $mainCategories;  @endphp
                                    {!! Form::label('parent_id', 'Parent Category') !!}
                                    {!! Form::select('parent_id', $cats, null,['class'=>'form-control']); !!}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Category Image',['class'=>'custom-file-label']) !!}
                </div>
                <button type="submit"  class="add-category btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit category</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Featured Image:</h5>
                <img width="100%"
                     src="{{ ($category->photo) ?  $category->photo->getCategoryImagePath($category->photo->file) : "/images/default.png"}}"
                     alt="">
            </div>
        </div>
        <div class="card mt-3">

            <div class="card-body">
                <h5>Posts:</h5>
                @if(count($category->posts) > 0)
                    <ul class="list-star">
                        @foreach($category->posts as $post)
                            <li><a href="/admin/posts/{{$post->id}}/edit" target="_blank" >{{$post->title}}</a></li>
                        @endforeach
                    </ul>
                @else
                    <p>No posts yet.</p>
                @endif
            </div>
        </div>
    </div>


@endsection


