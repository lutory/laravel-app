@extends('layouts.admin')

@section('content')
    <h1>Tags</h1>

    <div class="card">
        <div class="card-body">
            <h2>Add tag</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" />
            <button type="button"  class="add-tag btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add tag</button>
        </div>
    </div>

    <div class="card mt-3 mb-3">
        <div class="card-body">
            <label for="search">Search for tag:</label>
            <input type="text" id="search" />
            <button type="button" class="search-tag btn btn-secondary btn-sm"><i class="fas fa-search"></i> Search</button>
        </div>
    </div>


    @if(count($tags)>0)
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name </th>
                <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr class="tag-row">
                    <th>{{ $tag->id }}</th>
                    <td class="tag-name"><span>{{ $tag->name }}</span><input type="text" value="{{ $tag->name }}" class="d-none" /></td>
                    <td>
                        <button type="button"  class="edit-tag btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Edit</button>
                        <button type="button"  class="save-tag btn btn-primary btn-sm d-none" data-id="{{ $tag->id }}"><i class="fas fa-save"></i> Save changes</button>
                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>





    @else
        <p>No tags yet</p>
    @endif

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){

            $(".search-tag").on('click', function(){

                var search = $(this).parent().find('#search').val();

                if(search.length>1){
                    $.ajax({
                        method: "POST",
                        url: "/admin/tags",
                        dataType: 'json',
                        data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'search': search }
                    })
                    .done(function( $tag ) {
                        location.reload();
                    });
                }

            });

            $(".add-tag").on('click', function(){
                var name = $(this).parent().find('#name').val();
                $.ajax({
                    method: "POST",
                    url: "/admin/tags/create",
                    dataType: 'json',
                    data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'name': name }
                })
                .done(function( $tag ) {
                    location.reload();
                });
            });

            $(".edit-tag").on('click', function(){
                var currentCatTd = $(this).parents('.tag-row').find('.tag-name');
                currentCatTd.find('input').removeClass('d-none').show().focus();
                currentCatTd.find('span').hide();

                $(this).hide();
                $(this).parent().find('.save-tag').removeClass('d-none').show();

            });

            $('.save-tag').on('click', function () {
                var newCatName = $(this).parents('.tag-row').find('input').val();
                var catId = $(this).data('id');
                var saveBtn = $(this);
                var editBtn = $(this).parent().find('.edit-tag');
                var catTd = $(this).parents('.tag-row').find('.tag-name');

                $.ajax({
                    method: "POST",
                    url: "/admin/tags/edit",
                    dataType: 'json',
                    data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'name': newCatName, 'id': catId }
                })
                .done(function( res ) {
                    saveBtn.hide();
                    editBtn.show();
                    catTd.find('input').hide();
                    catTd.find('span').text(res.tag.name).show();
                });
            });




        });

    </script>
@endsection


