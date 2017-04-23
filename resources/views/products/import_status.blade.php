@extends('layout')
@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>@lang('app.import_catalog_status')</strong>
            </div>
            <div class="panel-body">
                <div id="error-message" class="alert alert-danger" style="display: none"></div>
                <div id="success-message" class="alert alert-success" style="display: none">
                    @lang('app.import_catalog_success')
                </div>
                <div id="processing-message" class="alert alert-info">
                    @lang('app.import_catalog_processing')
                </div>
                <a href="{{ @route('products.index') }}" class="btn btn-default">@lang('app.back')</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
(function () {
    Echo.channel('App.CatalogImport.{{ $catalogImport->id }}')
        .listen('CatalogImportUpdated', function (e) {
            var catalogImport = e.catalogImport;
            if (catalogImport.error_message) {
                $('#error-message').text();
                $('#error-message').show();
            } else if (catalogImport.completed) {
                $('#success-message').show();
            }
            $('#processing-message').hide();
        });
})();
</script>
@endpush
