@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('product::products.list resource') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('product::products.title.products') }}</li>
        <li class="active">{{ trans('product::products.list resource') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.product.product.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('product::products.create resource') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">{{ trans('product::products.id') }}</th>
                                <th width="5%">{{ trans('product::products.type') }}</th>
                                <th width="10%" data-sortable="false">{{ trans('product::products.image') }}</th>
                                <th width="30%">{{ trans('product::products.name') }}</th>
                                <th width="20%">{{ trans('product::products.sale_price') }}</th>
                                <th width="30%" data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($products)): ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                {{ $product->id }}
                            </td>
                            <td>
                                {{ $product->getEntityName() }}
                            </td>
                            <td>
                                <a href="{{ route('admin.product.product.edit', [$product->id]) }}">
                                    <img src="{{ $product->small_thumb }}" class="image" />
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.product.product.edit', [$product->id]) }}">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td>
                                {{ $product->sale_price }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.product.product.edit', [$product->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.product.product.destroy', [$product->id]) }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" style="width: 80px;" />
                                </td>
                                <td>
                                    <select class="form-control" style="width: 100px;">
                                        @foreach ($productTypes as $type)
                                            <option>{{ trans($type->getEntityName()) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td>
                                    <input type="text" class="form-control" style="width: 100%" />
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
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
        <dd>{{ trans('product::products.title.create resource') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.product.product.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var $footer = $(column.footer());
                        var $input = $footer.find('input') || $footer.find('select');
                        $input.on('change', function () {
                            column.search($(this).val()).draw();
                        });
                    });
                }
            });
        });
    </script>
@endpush
