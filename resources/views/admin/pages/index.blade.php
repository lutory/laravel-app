@extends('layouts.admin')

@section('content')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h1>Pages</h1>

                @if( session('deleted_page') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('deleted_page')])
                @endif
                @if( session('edited_page') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('edited_page')])
                @endif

                @if(count($pages)>0)
                    <div class="table-responsive mb-3">


                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{ $page->id  }}</td>
                                    <td>@if($page->photo)<img src="{{ $page->photo->getPageImagePath($page->photo->file) }}"/> @endif </td>
                                    <td><a href="{{ route('pages.edit',['id'=>$page->id]) }}">{{ $page->title }}</a> </td>
                                    <td>{{ $page->slug  }}</td>
                                    <td>{{ $page->created_at->diffForHumans()  }}</td>
                                    <td>{{ ($page->updated_at) ? $page->updated_at->diffForHumans() : "-"   }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No pages yet</p>
                @endif
            </div>
        </div>
    </div>
@endsection