@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('product::categories.title.edit category') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.product.category.index') }}">{{ trans('product::categories.title.categories') }}</a></li>
        <li class="active">{{ trans('product::categories.title.edit category') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.product.category.update', $category->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-sm-9">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('product::admin.categories.partials.edit-trans-fields', ['lang' => $locale])
                        </div>
                    @endforeach
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-sm-3">
            <div class="box box-primary">
                <div class="box-body">
                    @include('product::admin.categories.partials.edit-fields')
                </div>
                <div class="box-footer">
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.product.category.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.product.category.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
