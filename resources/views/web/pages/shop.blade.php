@extends('web.layouts.app')

@section('web-section')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-6 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 sidebar">
                        <div class="sub-title">
                            <h2>Categories</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExample">

                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $key => $category)
                                            <div class="accordion-item">
                                                @if ($category->sub_categories->isNotEmpty())
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne-{{ $key + 1 }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapseOne-{{ $key + 1 }}">
                                                            {{ $category->name }}
                                                        </button>
                                                    </h2>
                                                @else
                                                    <a href="{{ route('web.view.shop', $category->slug) }}"
                                                        class="nav-item nav-link">{{ $category->name }}</a>
                                                @endif

                                                @if ($category->sub_categories->isNotEmpty())
                                                    <div id="collapseOne-{{ $key + 1 }}"
                                                        class="accordion-collapse collapse {{ ($categorySelected == $category->id) ? 'show' : '' }}"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="navbar-nav">
                                                                @foreach ($category->sub_categories as $subCategory)
                                                                    <a href="{{ route('web.view.shop', [$category->slug, $subCategory->slug]) }}"
                                                                        class="nav-item nav-link {{ ($subCategorySelected == $subCategory->id) ? 'text_primary' : '' }}">{{ $subCategory->name }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Brand</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">

                                @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="brand[]"
                                                value="{{ $brand->id }}" id="{{ $brand->id }}">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $brand->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Price</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        $0-$100
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        $100-$200
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        $200-$500
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        $500+
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                                data-bs-toggle="dropdown">Sorting</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#">Latest</a>
                                                <a class="dropdown-item" href="#">Price High</a>
                                                <a class="dropdown-item" href="#">Price Low</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <div class="col-md-4">
                                        <div class="card product-card">
                                            <div class="product-image position-relative">

                                                <div
                                                    style="display: flex; justify-content: center; align-items: center; height: 150px; width: 100%; overflow:hidden; ">

                                                    @if ($product->productimage[0]->image)
                                                        <a href="" class="product-img"><img class="card-img-top"
                                                                src="{{ asset('storage/' . $product->productimage[0]->image) }}"
                                                                alt="{{ $product->productimage[0]->image }}">
                                                        @else
                                                            <a href="" class="product-img"><img
                                                                    class="card-img-top"
                                                                    src="{{ asset('admin/images/thumbnail-default.jpg') }}">
                                                    @endif

                                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                                    <div class="product-action">
                                                        <a class="btn btn-dark" href="#">
                                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body text-center mt-3">
                                                <a class="h6 link"
                                                    href="product.php">{{ strlen($product->title) > 40 ? substr($product->title, 0, 30) . '...' : $product->title }}</a>
                                                <div class="price mt-2">
                                                    <span class="h5"><strong>Rs.{{ $product->price }}</strong></span>

                                                    @if ($product->compare_price > 0)
                                                        <span
                                                            class="h6 text-underline"><del>Rs.{{ $product->compare_price }}</del></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
