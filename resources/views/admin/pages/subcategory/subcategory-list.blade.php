@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.subcategory.list') }}">Sub Category</a></li>
        </ul>
        <h1 class="panel-title">Sub Category</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Category</h1>
                <p class="panel-card-description">List of all category in the system</p>
            </div>
            {{-- @can(\App\Enums\Permission::ADD_ACCESS->value) --}}
            <div>
                <a href="{{ route('admin.view.subcategory.create') }}" class="btn-primary-sm flex">
                    <span class="lg:block md:block sm:hidden mr-2">Add Sub Category</span>
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
                        <th>Category</th>
                        <th>Image</th>
                        {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                        <th>Status</th>
                        {{-- @endcan --}}
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($subcategories as $key => $subcategory)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $subcategory->name }}</td>
                                <td>{{ $subcategory->slug }}</td>
                                <td>{{ $subcategory->category->name }}</td>
                                <td>
                                    @if ($subcategory->img)
                                        <img src="{{ asset('storage/' . $subcategory->img) }}" class="img-fluid"
                                            style="max-width:80px" alt="{{ $subcategory->img }}">
                                    @else
                                        <img src="{{ asset('admin/images/thumbnail-default.jpg') }}" class="img-fluid"
                                            style="max-width:80px" alt="avatar.png">
                                    @endif
                                </td>
                                {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                                <td>
                                    <label class="toggler-switch">
                                        <input onchange="handleUpdateStatus('{{ $subcategory->id }}')"
                                            @checked($subcategory->status) type="checkbox">
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
                                                <li><a href="{{ route('admin.view.subcategory.update', ['id' => $subcategory->id]) }}"
                                                        class="dropdown-link-primary"><i data-feather="edit"
                                                            class="mr-1"></i> Edit Admin Access</a></li>
                                                {{-- @endcan --}}

                                                {{-- @can(\App\Enums\Permission::DELETE_ACCESS->value) --}}
                                                <li><a href="javascript:handleDelete('{{ $subcategory->id }}')"
                                                        class="dropdown-link-danger"><i data-feather="trash-2"
                                                            class="mr-1"></i> Delete Sub Category</a></li>
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
        document.getElementById('subcategory-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.subcategory.status') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    subcategory_id: id,
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
                    text: "Once deleted, you will not be able to recover this subcategory access!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = `{{ url('admin/sub-category/delete') }}/${id}`;
                    }
                });
        }
    </script>
@endsection
