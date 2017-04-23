@extends('layout')
@section('body')
    @if (session()->has('status'))
    <div class="alert alert-info">
        {{ session()->get('status') }}
    </div>
    @endif
    @if ($products->count() == 0)
    <div class="text-center">
        <p class="lead">@lang('app.import_catalog_tip')</p>
        <a href="{{ route('products.import') }}" class="btn btn-success btn-lg">@lang('app.import_catalog_button')</a>
    </div>
    @else
    <div class="panel panel-default panel-table">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-xs-6">
                    <h3 class="panel-title">@lang('app.product_list')</h3>
                </div>
                <div class="col col-xs-6 text-right">
                    <a href="{{ route('products.import') }}" class="btn btn-sm btn-primary btn-create">@lang('app.import_catalog_button')</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered table-list">
                <thead>
                    <tr>
                        <th>@lang('app.lm')</th>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.free_shipping')</th>
                        <th>@lang('app.price')</th>
                        <th>@lang('app.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->lm }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->free_shipping ? __('app.yes') : __('app.no') }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>
                            <a class="btn btn-xs btn-default" href="{{ route('products.edit', ['id' => $product->id]) }}">
                                <em class="fa fa-pencil"></em>
                            </a>
                            <button type="button" class="btn btn-xs btn-danger" data-product-delete="{{ $product->id }}">
                                <em class="fa fa-trash"></em>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            {{ $products->links() }}
        </div>
    </div>
    @endif
@endsection
@push("scripts")
<script>
$(function () {
    $('[data-product-delete]').click(function () {
        if (! confirm('@lang('app.confirm_delete')')) {
            return false;
        }
        var id = $(this).data('product-delete');
        $.ajax({
            url: '/products/' + id,
            method: 'DELETE',
            success: function () {
                location.reload();
            }
        });
    });
});
</script>
@endpush
