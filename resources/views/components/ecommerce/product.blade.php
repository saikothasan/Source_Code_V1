<style>
    .image img {
        height: 273px;
        width: 373px;
    }

    .img-fluid {
        height: 200px;
    }

    .wishlist-hart {
        background: white;
        border: none;
        padding: 9px;
    }
</style>


<figure>
    {{-- <span class="ribbon off">-30%</span> --}}
    <a href="{{ route('frontend.product.details', $product->id) }}">
        @if ($product->productImage->isNotEmpty())
            @foreach ($product->productImage->take(2) as $img)
                <img class="img-fluid lazy" src="{{ asset($img->photo) }}"
                    onerror="this.src='{{ asset('ecommerce/error-img.jpg') }}'" height="171" title="{{ $product->name }}"
                    alt="{{ $product->name }}" data-src="{{ asset($img->photo) }}">
            @endforeach
        @else
            <img src="{{ asset('ecommerce/error-img.jpg') }}" title="{{ $product->name }}" alt="{{ $product->name }}"
                class="img-fluid lazy" />

        @endif
    </a>
    {{-- <div data-countdown="2019/05/15" class="countdown"></div> --}}
</figure>
{{-- <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i
        class="icon-star voted"></i><i class="icon-star"></i>
</div> --}}
<a href="{{ route('frontend.product.details', $product->id) }}">
    <h3>{{ $product->name }}</h3>
</a>
<div class="price_box">
    <span class="new_price">৳{{ $product->sell_price }}</span>
    {{-- <span class="old_price">$60.00</span> --}}
</div>
<ul>
    <li><button onclick="addWishlist('{{ $product['id'] }}')" class="tooltip-1 wishlist-hart" data-bs-toggle="tooltip"
            data-bs-placement="left" title="Add to favorites"><i class="ti-heart"></i></button>
    </li>
    {{-- <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to
                        compare</span></a></li> --}}
    <li><a href="{{ route('frontend.product.details', $product->id) }}" class="tooltip-1" data-bs-toggle="tooltip"
            data-bs-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Order Now</span></a></li>

    <li class="productDetaisView"><a onclick="quickView('{{ $product->id }}')" id="sign-in" class="access-link"
            class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick View"><i
                class="ti-eye"></i><span>Quick
                View</span></a></li>

</ul>

{{--
              <div class="slider-item">
                <div class="product-block product-thumb transition">
                    <div class="product-block-inner">
                        <div class="img-wrap">
                            <div class="image ">
                                <a href="{{ route('frontend.product.details', $product->id) }}">
                               @if ($product->productImage->isNotEmpty())
                             @foreach ($product->productImage->take(1) as $img)
                                        <img src="{{ asset($img->photo) }}" title="{{ $product->name }}"
                                            alt="{{ $product->name }}"
                                            class="img-responsive reg-image" />
                                        <div class="image_content">
                                            @foreach ($product->productImage as $img)

                                                <img class="img-responsive hover-image"
                                                    src="{{ asset($img->photo) }}" onerror="this.src='{{asset('ecommerce/error-img.jpg')}}'"
                                                    title="{{ $product->name }}" alt="{{ $product->name }}" />
                                            @endforeach
                                        </div>
                                    @endforeach
                                    @else
                                    <img src="{{asset('ecommerce/error-img.jpg')}}" title="{{ $product->name }}"
                                            alt="{{ $product->name }}"
                                            class="img-responsive reg-image" />
                                    @endif
                                </a>

</div>
<div class="product_hover_block">
    <button class="wishlist" type="button" title="Add to Wish List "
        onclick="addWishlist('{{ $product['id'] }}')"></button>
    <div class="quickview-button">
        <a class="quickbox" title="Quick View" href="{{ route('frontend.product-quick-view', $product->id) }}"></a>
    </div>
</div>

</div>
<div class="product-details">
    <div class="caption">

        <h4><a href="{{ route('frontend.product.details', $product->id) }}">{{ $product->name }}</a>
        </h4>

        <div class="rating">
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
                    class="fa fa-star-o fa-stack-2x"></i></span>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
                    class="fa fa-star-o fa-stack-2x"></i></span>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
                    class="fa fa-star-o fa-stack-2x"></i></span>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
                    class="fa fa-star-o fa-stack-2x"></i></span>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
                    class="fa fa-star-o fa-stack-2x"></i></span> &nbsp;
            <span style="cursor:pointer;" class="total-review49">1
                Review</span>
        </div>
        <p class="price">
            <span class="price-new">৳{{ $product->sell_price }}</span>
        </p>
        <div class="action">
            <a href="{{ route('frontend.product.details', $product->id) }}">
                <button type="button" class="cart_button" title="Add to Cart">Order Now</button>
            </a>
        </div>
    </div>
</div>
</div>
</div>
<script>
    $('.total-review49').on('click', function() {
        var t = 'product_one.html?route=product/product&amp;product_id=49';
        const parseResult = new DOMParser().parseFromString(t, "text/html");
        const parsedUrl = parseResult.documentElement.textContent;
        window.location.href = parsedUrl + '&review';
        return false;
    });
</script>
</div> --}}
