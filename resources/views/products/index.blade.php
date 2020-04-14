@extends('layouts.app')

@section('title', __('product.list'))

@section('content')

<div class="pull-right">
    {{ link_to_route('products.price-list', __('product.print_price_list'), [], ['class' => 'btn btn-info']) }}
    {{--{{ link_to_route('products.index', __('product.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}--}}
</div>
<h3 class="page-header">
    {{ __('product.list') }}
    <small>{{ __('app.total') }} : {{ count($products) }} {{ __('product.product') }}</small>
</h3>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
                {!! FormField::text('q', ['value' => request('q'), 'label' => __('product.search'), 'class' => 'input-sm']) !!}
                {!!
                //var_dump($products);
                $option = null;
                foreach ($label_harga as $k=>$v):
                    $option[$v->id] = $v->name;
                endforeach;
                $label = collect($option);
                !!}
                {!! FormField::select('price_label', $label) !!}
                {{ Form::submit(__('product.search'), ['class' => 'btn btn-sm']) }}
                {{ link_to_route('products.index', __('app.reset')) }}
                {{ Form::close() }}
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('product.name') }}</th>
                        <th>{{ __('product.unit') }}</th>
                        <th class="text-right">{{ __('product.cash_price') }}</th>
                        <th class="text-right">{{ __('product.credit_price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $customersTotal = 0?>
                    @foreach($products as $key => $product)
                    <tr>
                        <td class="text-center">{{ $key }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->type->name }}</td>
                        <td class="text-right">
                            <?php
                            $price_nya = collect($product->price);
                            $price_nya = $price_nya->firstWhere('price_label',$cari_label);
                            //var_dump($price_nya);
                            if ($price_nya):
                                $price_nya = $price_nya->price;
                            else:
                                $price_nya = 0;
                            endif;
                            echo format_rp($price_nya);
                            ?>
                        </td>
                        <td class="text-right">{{ format_rp($price_nya) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{--{{var_dump($products[0]->price)}}--}}
            {{--<div class="panel-body">{{ $products->appends(Request::except('page'))->render() }}</div>--}}
        </div>
    </div>
    <div class="col-md-4">
        @include('products.partials.forms')
    </div>
</div>
@endsection