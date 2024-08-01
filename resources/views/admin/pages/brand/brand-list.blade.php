@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.brand.list') }}">Brand</a></li>
        </ul>
        <h1 class="panel-title">Brand</h1>
    </div>
@endsection


@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Brand</h1>
                <p class="panel-card-description">List of all brand in the system</p>
            </div>
            {{-- @can(\App\Enums\Permission::ADD_ACCESS->value) --}}
            <div>
                <a href="{{ route('admin.view.brand.create') }}" class="btn-primary-sm flex">
                    <span class="lg:block md:block sm:hidden mr-2">Add Brand</span>
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
                        <th>Name</th>
                        <th>Slug</th>
                        {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                        <th>Status</th>
                        {{-- @endcan --}}
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($brands as $key => $brand)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->slug }}</td>
                                {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                                <td>
                                    <label class="toggler-switch">
                                        <input onchange="handleUpdateStatus('{{ $brand->id }}')"
                                            @checked($brand->status) type="checkbox">
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
                                                <li><a href="{{ route('admin.view.brand.update', ['id' => $brand->id]) }}"
                                                        class="dropdown-link-primary"><i data-feather="edit"
                                                            class="mr-1"></i> Edit Brand</a></li>
                                                {{-- @endcan --}}

                                                {{-- @can(\App\Enums\Permission::DELETE_ACCESS->value) --}}
                                                <li><a href="javascript:handleDelete('{{ $brand->id }}')"
                                                        class="dropdown-link-danger"><i data-feather="trash-2"
                                                            class="mr-1"></i> Delete Brand</a></li>
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
        document.getElementById('brand-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.brand.status') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    brand_id: id,
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
                    text: "Once deleted, you will not be able to recover this brand access!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = `{{ url('admin/brand/delete') }}/${id}`;
                    }
                });
        }
    </script>
@endsection
