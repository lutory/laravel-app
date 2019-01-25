@extends('layouts.admin')

@section('content')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h1>Products</h1>

                @if( session('deleted_product') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('deleted_product')])
                @endif
                @if( session('edited_product') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('edited_product')])
                @endif

                {!! Form::open(['method'=>'GET','class="form-inline"']) !!}
                <div class="row">
                    {{--<div class="form-group m-3">--}}
                        {{--{!! Form::select('category',array_merge(['0' => 'Select Category'], $categories),request('category'),['class'=>'form-control','onChange'=>'form.submit()']) !!}--}}
                    {{--</div>--}}
                    <div class="form-group">
                        {!! Form::select('status',['all' => 'Select Status','1'=>'Active','0'=>'Inactive'],request('status'),['class'=>'form-control','onChange'=>'form.submit()']) !!}
                    </div>

                    <div class="form-group  m-3">
                        <div class="input-group">
                            <input class="form-control" id="search" value="{{ request('search') }}"
                                   placeholder="Search title"
                                   name="search" type="text" id="search"/>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <a href="{{route("products.index")}}" class="btn btn-dark">Clear filter</a>
                    </div>
                    <input type="hidden" value="{{request('field')}}" name="field"/>
                    <input type="hidden" value="{{request('sort')}}" name="sort"/>
                </div>
                {!! Form::close() !!}

                @if(count($products)>0)
                    <div class="table-responsive mb-3">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>
                                    <a href="{{route('products.index')}}?search={{request('search')}}&status={{request('status')}}&field=id&sort={{request('sort')=='asc'?'desc':'asc'}}">Id {!!request('field')=='id'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>
                                    {{--<a href="{{route('products.index')}}?search={{request('search')}}&category={{request('category')}}&status={{request('status')}}&field=id&sort={{request('sort')=='asc'?'desc':'asc'}}">Id {!!request('field')=='id'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>--}}
                                </th>
                                <th>Photo</th>
                                <th>
                                    <a href="{{route('products.index')}}?search={{request('search')}}&status={{request('status')}}&field=title&sort={{request('sort')=='asc'?'desc':'asc'}}">Title {!!request('field')=='title'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>
{{--                                    <a href="{{route('products.index')}}?search={{request('search')}}&category={{request('category')}}&status={{request('status')}}&field=title&sort={{request('sort')=='asc'?'desc':'asc'}}">Title {!!request('field')=='title'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>--}}
                                </th>
                                <th>Price</th>
                                <th>Old price</th>
                                <th>Quantity</th>
                                <th>
                                    <a href="{{route('products.index')}}?search={{request('search')}}&status={{request('status')}}&field=created_at&sort={{request('sort')=='asc'?'desc':'asc'}}">Created {!!request('field')=='created_at'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>
                                    {{--<a href="{{route('products.index')}}?search={{request('search')}}&category={{request('category')}}&status={{request('status')}}&field=created_at&sort={{request('sort')=='asc'?'desc':'asc'}}">Created {!!request('field')=='created_at'?(request('sort')=='asc'?'<i class="fas fa-angle-up"></i>':'<i class="fas fa-angle-down"></i>'):''!!}</a>--}}
                                </th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id  }}</td>
                                    <td>@if($product->photo)<img src="{{ $product->photo->getProductImagePath($product->photo->file) }}"/> @endif </td>
                                    <td><a href="{{ route('products.edit',['id'=>$product->id]) }}">{{ $product->title }}</a> </td>
                                    <td>{{ $product->price  }}</td>
                                    <td>{{ $product->old_price  }}</td>
                                    <td>{{ $product->quantity  }}</td>
                                    <td>{{ $product->created_at->diffForHumans()  }}</td>
                                    <td>@if($product->status == '1') <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Inactive</span> @endif</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                @else
                    <p>No products yet</p>
                @endif
            </div>
        </div>
    </div>
@endsection