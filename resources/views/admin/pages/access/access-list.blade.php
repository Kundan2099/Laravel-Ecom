@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.admin.access.list') }}">Admin Access</a></li>
        </ul>
        <h1 class="panel-title">Admin Access</h1>
    </div>
@endsection


@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Admin Access</h1>
                <p class="panel-card-description">List of all admins access in the system</p>
            </div>
            {{-- @can(\App\Enums\Permission::ADD_ACCESS->value) --}}
            <div>
                <a href="{{ route('admin.view.admin.access.create') }}" class="btn-primary-sm flex">
                    <span class="lg:block md:block sm:hidden mr-2">Add Access</span>
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
                        <th>Email</th>
                        <th>Phone</th>
                        {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                        <th>Status</th>
                        {{-- @endcan --}}
                        <th>Role</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                        @foreach ($admins as $key => $admin)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone }}</td>
                                {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                                <td>
                                    <label class="toggler-switch">
                                        <input onchange="handleUpdateStatus('{{ $admin->id }}')"
                                            @checked($admin->status) type="checkbox">
                                        <div class="slider"></div>
                                    </label>
                                </td>
                                {{-- @endcan --}}
                                <td>
                                    <span
                                        class="px-4 py-2 rounded-md text-xs bg-ascent bg-opacity-10 text-ascent-dark">{{ $admin->roles->first()->name }}</span>
                                </td>
                                <td>
                                    <div class="table-dropdown">
                                        <button>Options<i data-feather="chevron-down"
                                                class="ml-1 toggler-icon"></i></button>
                                        <div class="dropdown-menu">
                                            <ul>
                                                {{-- @can(\App\Enums\Permission::EDIT_ACCESS->value) --}}
                                                <li><a href="{{route('admin.view.admin.access.update', ['id' => $admin->id])}}" class="dropdown-link-primary"><i data-feather="edit"
                                                            class="mr-1"></i> Edit Admin Access</a></li>
                                                {{-- @endcan --}}

                                                {{-- @can(\App\Enums\Permission::DELETE_ACCESS->value) --}}
                                                <li><a href="" class="dropdown-link-danger"><i data-feather="trash-2"
                                                            class="mr-1"></i> Delete Admin Access</a></li>
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
