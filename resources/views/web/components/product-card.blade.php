<div class="card product-card">
    <div class="product-image position-relative">
        <a href="" class="product-img">

            {{-- <img class="card-img-top" src="{{ asset('front-assets/images/product-1.jpg') }}" alt=""></a> --}}

            <div
                style="display: flex; justify-content: center; align-items: center; height: 200px; width: 100%; overflow:hidden; ">
                @if ($product->productimage[0]->image)
                    <img class="card-img-top" src="{{ asset('storage/' . $product->productimage[0]->image) }}"
                        alt="{{ $product->productimage[0]->image }}">
                @else
                    <img class="card-img-top" src="{{ asset('admin/images/thumbnail-default.jpg') }}">
                @endif
            </div>
            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

            <div class="product-action">
                <a class="btn btn-dark" href="#">
                    <i class="fa fa-shopping-cart"></i> Add To Cart
                </a>
            </div>
    </div>
    <div class="card-body text-center mt-3">
        <a class="h6 link"
            href="product.php">{{ strlen($product->title) > 40 ? substr($product->title, 0, 30) . '...' : $product->title }}</a>
        <div class="price mt-2">
            <span class="h5"><strong>Rs.{{ $product->price }}</strong></span>
            @if ($product->compare_price > 0)
                <span class="h6 text-underline"><del>Rs.{{ $product->compare_price }}</del></span>
            @endif
        </div>
    </div>
</div>
