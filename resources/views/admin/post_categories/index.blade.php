@extends('layouts.admin')

@section('content')
    <h1>Posts Categories</h1>

    @if(count($categories)>0)
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name </th>
                <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr class="category-row">
                    <th>{{ $category->id }}</th>
                    <td class="category-name"><span>{{ $category->name }}</span><input type="text" value="{{ $category->name }}" class="d-none" /></td>
                    <td>
                        <button type="button"  class="edit-category btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Edit</button>
                        <button type="button"  class="save-category btn btn-primary btn-sm d-none" data-id="{{ $category->id }}"><i class="fas fa-save"></i> Save changes</button>
                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <div class="card">
            <div class="card-body">
                <h2>Add category</h2>
                <label for="name">Name:</label>
                <input type="text" id="name" />
                <button type="button"  class="add-category btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add category</button>
            </div>
        </div>


    @else
        <p>No categories yet</p>
    @endif

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){

            $(".add-category").on('click', function(){
                var name = $(this).parent().find('#name').val();
                $.ajax({
                    method: "POST",
                    url: "/admin/post-categories/create",
                    dataType: 'json',
                    data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'name': name }
                })
                .done(function( category ) {
                    location.reload();
                });


            });
            $(".edit-category").on('click', function(){
                var currentCatTd = $(this).parents('.category-row').find('.category-name');
                currentCatTd.find('input').removeClass('d-none').show().focus();
                currentCatTd.find('span').hide();

                $(this).hide();
                $(this).parent().find('.save-category').removeClass('d-none').show();

            });
            $('.save-category').on('click', function () {
                var newCatName = $(this).parents('.category-row').find('input').val();
                var catId = $(this).data('id');
                var saveBtn = $(this);
                var editBtn = $(this).parent().find('.edit-category');
                var catTd = $(this).parents('.category-row').find('.category-name');

                $.ajax({
                    method: "POST",
                    url: "/admin/post-categories/edit",
                    dataType: 'json',
                    data: { '_token':$('meta[name="csrf-token"]').attr('content'), 'name': newCatName, 'id': catId }
                })
                .done(function( res ) {
                    saveBtn.hide();
                    editBtn.show();
                    catTd.find('input').hide();
                    catTd.find('span').text(res.category.name).show();
                });
            });




        });

    </script>
@endsection


