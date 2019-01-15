@extends('layouts.admin')

@section('content')
    <h1>Posts Categories</h1>
    <div class="row">
    <div class="col-6">
    @if(count($categories)>0)
        <div class="card mb-3">
            <div class="card-body">
                <input type="text" placeholder="Type keyword" id="search"/>
            </div>
        </div>
        <table class="table table-striped table-hover table-sm" id="categoriesTable">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name </th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr class="category-row">
                    <td>{{ $category->id }}</td>
                    <td class="category-name"><a href="{{route('post-categories.edit',$category->id)}}">{{ $category->name }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p id="noSearchResult" style="display: none;">No results for: <em>ddd</em></p>
    @else
        <p>No categories yet</p>
    @endif
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h2>Add category</h2>
                {!! Form::open(['method' => 'POST','action' => 'AdminPostsCategoriesController@store']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="error-message">:message</p>') !!}
                </div>
                <button type="submit"  class="add-category btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add category</button>
                {!! Form::close() !!}

            </div>
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
