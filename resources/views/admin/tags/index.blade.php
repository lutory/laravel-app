@extends('layouts.admin')

@section('content')
    <h1>Tags</h1>
    @if( session('deleted_tag') )
        @include('inc.flashmsg',['type'=>'success','msg'=>session('deleted_tag')])
    @endif
    @if( session('edited_tag') )
        @include('inc.flashmsg',['type'=>'success','msg'=>session('edited_tag')])
    @endif
    <div class="row">
    <div class="col-6">
    @if(count($tags)>0)
        <div class="card mb-3">
            <div class="card-body">
                <input type="text" placeholder="Type keyword" id="search"/>
            </div>
        </div>
        <table class="table table-striped table-hover table-sm" id="tagsTable">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name </th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td><a href="{{route('tags.edit',$tag->id)}}">{{ $tag->name }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p id="noSearchResult" style="display: none;">No results for: <em>ddd</em></p>
    @else
        <p>No tags yet</p>
    @endif
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h2>Add tag</h2>
                {!! Form::open(['method' => 'POST','action' => 'AdminTagsController@store']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="error-message">:message</p>') !!}
                </div>
                <button type="submit"  class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add tag</button>
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
                    url: "/admin/tags/search",
                    dataType: 'json',
                    data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'search': search }
                })
                .done(function( res ) {

                    if(res.tags.length>0){
                        $("#noSearchResult").hide();
                        var table = $("#tagsTable");
                        table.show();
                        var output = '';
                        table.find('tbody').empty();

                        $.each(res.tags, function( index, tag ) {

                            output += '<tr>' +
                                      '<td>'+tag.id+'</td>' +
                                      '<td><a href="/admin/tags/'+tag.id+'/edit">'+tag.name+'</a></td>' +
                                      '</tr>';
                        });
                        table.find('tbody').html(output);
                    }
                    else{

                        $("#tagsTable").hide();
                        $("#noSearchResult").find('em').text(search);
                        $("#noSearchResult").show();
                    }
                });
            //}

        });

    });

</script>
@endsection
