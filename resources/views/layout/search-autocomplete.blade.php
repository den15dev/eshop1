<div class="search_results_cont_inner scrollbar-thin">
    @if($brands->count())
        <x-search-title title="Бренды" :num="$total->brands" :url="false" />

        @foreach($brands as $brand)
        <a href="{{ route('brand', $brand->slug) }}" class="search_result_brand_block black_link">{{ $brand->name }}</a>
        @endforeach

        <div class="my-1"></div>
    @endif

    @if($products->count())
        <x-search-title title="Товары" :num="$total->products" :url="route('search', ['query' => $query_str])" />

        @foreach($products as $product)
        <x-search-product-block :product="$product" />
        @endforeach
    @endif

    @if(!$brands->count() && !$products->count())
        <div class="w-100 py-1 ps-25 lightgrey_text">Ничего не найдено</div>
    @endif
</div>
