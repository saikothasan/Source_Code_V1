<div class="slider-item">
    <div class="product-block product-thumb transition">
        <div class="product-block-inner">
            <div class="img-wrap">
                <div class="image ">
                    <a href="product_one.html?route=product/product&amp;product_id=49">

                        {{-- <img src="{{ asset('ecommerce/image/cache/catalog/12-287x373.jpg') }}" title="COTTON SHIRT"
                            alt="COTTON SHIRT" class="img-responsive reg-image" /> --}}
                        <img src="{{ $photo }}" title="COTTON SHIRT" alt="COTTON SHIRT"
                            class="img-responsive reg-image" />

                        <div class="image_content">
                            <img class="img-responsive hover-image" src="{{ $photo }}" title="COTTON SHIRT"
                                alt="COTTON SHIRT" />
                        </div>
                    </a>
                    <span class="special-tag">90%</span>
                </div>
                <div class="product_hover_block">
                    <button class="wishlist" type="button" title="Add to Wish List "
                        onclick="wishlist.add('49 ');"></button>
                    <div class="quickview-button">
                        <a class="quickbox" title="Quick View"
                            href="product_one.html?route=product/quick_view&amp;product_id=49"></a>
                    </div>

                    <button class="compare_button" type="button" title="Add to compare "
                        onclick="compare.add('49 ');"></button>
                </div>

            </div>
            <div class="product-details">
                <div class="caption">

                    <h4><a href="product_one.html?route=product/product&amp;product_id=49">COTTON SHIRT </a></h4>

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
                        <span style="cursor:pointer;" class="total-review49">1 Review</span>
                    </div>
                    <p class="price">
                        <span class="price-new">$26.00</span> <span class="price-old">$241.99</span>
                        <span class="price-tax">Ex Tax: $20.00</span>
                    </p>
                    <div class="action">
                        <button type="button" class="cart_button" onclick="cart.add('49');" title="Add to Cart">Add to
                            Cart</button>
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
</div>
