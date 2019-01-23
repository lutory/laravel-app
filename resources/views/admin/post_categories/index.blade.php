@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h1>Posts Categories</h1>
                <hr>
                @if( session('edited_cat') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('edited_cat')])
                @endif
                @if(count($categories)>0)
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" placeholder="Type keyword" id="search" class="form-control"/>
                    </div>
                    <table id="categoriesTable" class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Posts</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td><a href="{{route('post-categories.edit',$category->id)}}">{{ $category->name }}</a></td>
                                <td>{{ $category->posts->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <p id="noSearchResult" style="display: none;">No results for: <em></em></p>
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
                {!! Form::open(['method' => 'POST','action' => 'AdminPostsCategoriesController@store']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="text-danger">:message</p>') !!}
                </div>
                <button type="submit"  class="add-category btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add category</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>

    $(document).ready(function(){

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
