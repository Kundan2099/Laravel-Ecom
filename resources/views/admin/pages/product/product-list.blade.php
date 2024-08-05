@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.product.list') }}">Product</a></li>
        </ul>
        <h1 class="panel-title">Product</h1>
    </div>
@endsection


@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Product</h1>
                <p class="panel-card-description">List of all product in the system</p>
            </div>
            {{-- @can(\App\Enums\Permission::ADD_ACCESS->value) --}}
            <div>
                <a href="{{ route('admin.view.product.create') }}" class="btn-primary-sm flex">
                    <span class="lg:block md:block sm:hidden mr-2">Add Product</span>
                    <i data-feather="plus"></i>
                </a>
            </div>
            {{-- @endcan --}}
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Sku</th>
                        <th>Image</th>
                        {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                        <th>Status</th>
                        {{-- @endcan --}}
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->qty }} left in Stock</td>
                                <td>{{ $product->sku }}</td>
                                <td>
                                    @if ($product->productimage[0]->image)
                                        <img src="{{ asset('storage/' . $product->productimage[0]->image) }}"
                                            class="img-fluid" style="max-width:80px"
                                            alt="{{ $product->productimage[0]->image }}">
                                    @else
                                        <img src="{{ asset('admin/images/thumbnail-default.jpg') }}" class="img-fluid"
                                            style="max-width:80px" alt="avatar.png">
                                    @endif
                                </td>
                                {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                                <td>
                                    <label class="toggler-switch">
                                        <input onchange="handleUpdateStatus('{{ $product->id }}')"
                                            @checked($product->status) type="checkbox">
                                        <div class="slider"></div>
                                    </label>
                                </td>
                                {{-- @endcan --}}
                                <td>
                                    <div class="table-dropdown">
                                        <button>Options<i data-feather="chevron-down"
                                                class="ml-1 toggler-icon"></i></button>
                                        <div class="dropdown-menu">
                                            <ul>
                                                {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                                                <li><a href="{{ route('admin.view.product.update', ['id' => $product->id]) }}"
                                                        class="dropdown-link-primary"><i data-feather="edit"
                                                            class="mr-1"></i> Edit Product</a></li>
                                                {{-- @endcan --}}

                                                {{-- @can(\App\Enums\Permission::DELETE_ACCESS->value) --}}
                                                <li><a href="javascript:handleDelete('{{ $product->id }}')"
                                                        class="dropdown-link-danger"><i data-feather="trash-2"
                                                            class="mr-1"></i> Delete Product</a></li>
                                                {{-- @endcan --}}

                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </figure>
@endsection

@section('panel-script')
    <script>
        document.getElementById('product-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.product.status') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: id,
                    _token: "{{ csrf_token() }}"
                })
            }).then((response) => {
                return response.json();
            }).catch((error) => {
                swal({
                    title: "Internal server error",
                    text: "An error occured, please try again",
                    icon: "error",
                })
            });
        }

        const handleDelete = (id) => {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this product access!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = `{{ url('admin/product/delete') }}/${id}`;
                    }
                });
        }
    </script>
@endsection
