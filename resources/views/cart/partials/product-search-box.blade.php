<div class="panel panel-default" style="border-radius:0px">
    <div class="panel-heading">
        <form method="get" action="{{ route('cart.show', $draft->draftKey) }}" class="form-inline cart-form">
            <div class="form-group">
                <label for="query">{{ trans('cart.product_search') }}</label>
                <input class="form-control" type="text" id="query" name="query" value="{{ request('query') }}" placeholder="{{ trans('cart.min_search_query') }}">
            </div>
            <div class="form-group">
                <label for="cari_label">Label Harga</label>
                <select id="cari_label" name="cari_label" class="form-control" onchange="$('.cart-form').submit()" >
                    @foreach ($price_label as $k=>$v):
                    <option value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </div>

            <input type="submit" value="{{ trans('cart.product_search') }}" class="btn btn-sm">
            @if ($queriedProducts)
            {{ link_to_route('cart.show', trans('cart.search_box_cleanup'), [$draft->draftKey], ['class' => 'btn btn-sm']) }}
            @endif
        </form>
    </div>
    <div id="product-search-result-box">
    @includeWhen ($queriedProducts, 'cart.partials.product-search-result-box', [
        'draftType' => $draft->type,
        'draftKey' => $draft->draftKey
    ])
    </div>
</div>