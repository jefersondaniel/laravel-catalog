@extends('layout')
@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>@lang('app.import_catalog_title')</strong>
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
                    action="{{ route('products.import') }}"
                    method="post"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="file" class="col-sm-2 control-label">@lang('app.catalog_file')</label>
                        <div class="col-sm-10">
                            <input id="file" type="file" name="attachment" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">@lang('app.submit_file')</button>
                            <a href="{{ @route('products.index') }}" class="btn btn-default">@lang('app.back')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
