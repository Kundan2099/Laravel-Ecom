@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.product.list') }}">Product</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.product.create') }}">Add Product</a></li>
        </ul>
        <h1 class="panel-title">Add Product</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.product.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Add Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- Title --}}
                    <div class="input-group">
                        <label for="title" class="input-label">Title <em>*</em></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="input-box-md @error('title') input-invalid @enderror" placeholder="Enter Title"
                            minlength="1" maxlength="250" required>
                        @error('title')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="flex flex-col">
                        <label for="slug" class="input-label">Slug <em>*</em></label>
                        <input type="slug" name="slug" value="{{ old('slug') }}"
                            class="input-box-md @error('slug') input-invalid @enderror" placeholder="Enter Email Address"
                            required minlength="1" maxlength="250">
                        @error('slug')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Product status --}}
                    <div class="input-group">
                        <label for="status" class="input-label">Product status<em>*</em></label>
                        <select name="status" class="input-box-md @error('status') input-invalid @enderror" required>
                            <option value="true">Active</option>
                            <option value="false">Block</option>
                        </select>
                        @error('status')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </figure>

        <br>

        {{-- Product category --}}
        <figure class="panel-card">
            <div class="panel-card-header ">
                <div>
                    <h1 class="panel-card-title">Product category</h1>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- Category --}}
                    <div class="input-group">
                        <label for="category_id" class="input-label">Category<em>*</em></label>
                        <select name="category_id" class="input-box-md @error('category_id') input-invalid @enderror"
                            required>
                            <option value="">Select Category</option>
                            @foreach ($category as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}
                                </option>
                            @endforeach
                            {{-- <option value="">Electronics</option>
                            <option value="">Clothes</option>
                            <option value="">Furniture</option> --}}
                        </select>
                        @error('category_id')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Sub Category --}}
                    <div class="input-group">
                        <label for="sub_category_id" class="input-label">Sub Category<em>*</em></label>
                        <select name="sub_category_id"
                            class="input-box-md @error('sub_category_id') input-invalid @enderror" required>
                            <option value="">Select Sub Category</option>
                            @foreach ($subcategory as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}
                                </option>
                            @endforeach
                            {{-- <option value="">Mobile</option>
                            <option value="">Home Theater</option>
                            <option value="">Headphones</option> --}}
                        </select>
                        @error('sub_category_id')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Product Brand --}}
                    <div class="input-group">
                        <label for="brand_id" class="input-label">Product Brand<em>*</em></label>
                        <select name="brand_id" class="input-box-md @error('brand_id') input-invalid @enderror" required>
                            <option value="">Select Product Brand</option>
                            @foreach ($brand as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}
                                </option>
                            @endforeach
                            {{-- <option value="">Apple</option>
                            <option value="">Vivo</option>
                            <option value="">HP</option>
                            <option value="">Samsung</option>
                            <option value="">DELL</option> --}}
                        </select>
                        @error('category_id')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Featured Product --}}
                    <div class="input-group">
                        <label for="is_featured" class="input-label">Featured Product<em>*</em></label>
                        <select name="is_featured" class="input-box-md @error('is_featured') input-invalid @enderror"
                            required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        @error('is_featured')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="input-group 2xl:col-span-5 lg:col-span-4 md:col-span-2 sm:col-span-1">
                        <label for="image" class="input-label">Media <span>(Format: png, jpg, jpeg, webp,
                                avif)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/avif"
                                    onchange="handleThumbnailPreview(event)" name="image">
                                <i data-feather="upload-cloud"></i>
                                <span>Darg and Drop Image Files</span>
                            </div>
                            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="image" alt="image"
                                class="input-thumbnail-preview">
                        </div>
                        @error('image')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
        </figure>

        <br>

        {{-- Pricing --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Pricing</h1>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- Price --}}
                    <div class="input-group">
                        <label for="price" class="input-label">Price <em>*</em></label>
                        <input type="text" name="price" value="{{ old('price') }}"
                            class="input-box-md @error('price') input-invalid @enderror" placeholder="Enter Price"
                            minlength="1" maxlength="250" required>
                        @error('price')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Compare at Price --}}
                    <div class="input-group">
                        <label for="compare_price" class="input-label">Compare at Price<em>*</em></label>
                        <input type="text" name="compare_price" value="{{ old('compare_price') }}"
                            class="input-box-md @error('compare_price') input-invalid @enderror"
                            placeholder="Enter Compare Price" minlength="1" maxlength="250" required>
                        @error('compare_price')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </figure>

        <br>

        {{-- Inventory --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Inventory</h1>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- SKU --}}
                    <div class="input-group">
                        <label for="sku" class="input-label">SKU (Stock Keeping Unit) <em>*</em></label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                            class="input-box-md @error('sku') input-invalid @enderror" placeholder="Enter Sku"
                            minlength="1" maxlength="250" required>
                        @error('sku')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Barcode --}}
                    <div class="input-group">
                        <label for="barcode" class="input-label">Barcode<em>*</em></label>
                        <input type="text" name="barcode" value="{{ old('barcode') }}"
                            class="input-box-md @error('barcode') input-invalid @enderror"
                            placeholder="Enter Compare Price" minlength="1" maxlength="250" required>
                        @error('barcode')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-4 sm:col-span-1 grid md:grid-cols-4 sm:grid-cols-1 md:gap-7 sm:gap-5"
                        x-data="{ open: {{ old('track_qty') == '1' ? 'true' : 'false' }} }">

                        {{-- Track Quantity --}}
                        <div class="md:col-span-4 sm:col-span-1">
                            <div class="flex items-center mt-2">
                                <input type="hidden" name="track_qty" value="No">
                                <input @click="open = ! open" value="Yes" name="track_qty" id="track_qty"
                                    type="checkbox">
                                <label for="track_qty" min="0"
                                    class="text-xs font-medium cursor-pointer select-none">Track
                                    Qty</label>
                            </div>
                        </div>

                        {{-- Qty --}}
                        <div class="input-group" x-show="open">
                            <label for="qty" class="input-label">Qty</label>
                            <input type="number" name="qty"
                                class="input-box-md @error('qty') input-invalid @enderror" placeholder="Qty"
                                minlength="6" maxlength="20">
                            @error('qty')
                                <span class="input-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Add Product</button>
            </div>
        </figure>
    </form>
@endsection


@section('panel-script')
    <script>
        document.getElementById('product-tab').classList.add('active');

        const handleThumbnailPreview = (event) => {
            if (event.target.files.length == 0) {
                document.getElementById('image').src = "{{ asset('admin/images/default-thumbnail.png') }}";
            } else {
                document.getElementById('image').src = URL.createObjectURL(event.target.files[0])
            }
        }
    </script>
@endsection
