@extends('layout')
@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>@lang('app.edit_product')</strong>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form
                    class="form-horizontal"
                    action="{{ route('products.update', ['product' => $product]) }}"
                    method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">@lang('app.name')</label>
                        <div class="col-sm-10">
                            <input id="name" type="string" name="name" value="{{ $product->name }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">@lang('app.category')</label>
                        <div class="col-sm-10">
                            <input id="category" type="string" name="category" value="{{ $product->category }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="free_shipping" class="col-sm-2 control-label">@lang('app.free_shipping')</label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="free_shipping" value="0"/>
                                    <input id="free_shipping" name="free_shipping" type="checkbox" value="1" {{ $product->free_shipping ? 'checked' : '' }}>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">@lang('app.description')</label>
                        <div class="col-sm-10">
                            <input id="description" type="string" name="description" value="{{ $product->description }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">@lang('app.price')</label>
                        <div class="col-sm-10">
                            <input id="price" type="number" name="price" value="{{ $product->price }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">@lang('app.edit')</button>
                            <a href="{{ @route('products.index') }}" class="btn btn-default">@lang('app.back')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
