@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('product::categories.title.categories') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('product::categories.title.categories') }}</li>
    </ol>
@stop

@push('css-stack')
    <link href="{!! Module::asset('menu:css/nestable.css') !!}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.product.category.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('product::categories.button.create category') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary" style="overflow: hidden;">
                <div class="box-body">
                    @if (!empty($categories->toArray()))
                        {!! $categoryStructure !!}
                    @else
                        <p class="text-center">{{ trans('product::categories.table.category not found') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('product::categories.title.create category') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.product.category.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script src="{!! Module::asset('menu:js/jquery.nestable.js') !!}"></script>
    <script>
    $( document ).ready(function() {
        $('.dd').nestable();
        $('.dd').on('change', function() {
            var data = $('.dd').nestable('serialize');
            $.ajax({
                type: 'POST',
                url: '{{ route('api.product.category.update') }}',
                data: {'categories': JSON.stringify(data), '_token': '<?php echo csrf_token(); ?>'},
                dataType: 'json',
                success: function(data) {

                },
                error:function (xhr, ajaxOptions, thrownError){
                }
            });
        });
    });
    </script>
    <script>
        $( document ).ready(function() {
            $('.jsDeleteCategoryItem').on('click', function(e) {
                var self = $(this),
                    categoryId = self.data('item-id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('api.product.category.delete') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        category: categoryId
                    },
                    success: function(data) {
                        if (! data.errors) {
                            var elem = self.closest('li');
                            elem.fadeOut()
                            setTimeout(function(){
                                elem.remove()
                            }, 300);
                        }
                    }
                });
            });
        });
    </script>
@endpush
