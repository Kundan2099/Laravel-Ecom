@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.category.list') }}">Category</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.category.update', ['id' => $category->id]) }}">Edit Category</a></li>
        </ul>
        <h1 class="panel-title">Edit Category</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.category.update', ['id' => $category->id]) }}" method="POST"
        enctype="multipart/form-data">
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

                    {{-- Name --}}
                    <div class="input-group">
                        <label for="name" class="input-label">Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}"
                            class="input-box-md @error('name') input-invalid @enderror" placeholder="Enter Name"
                            minlength="1" maxlength="250" required>
                        @error('name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="flex flex-col">
                        <label for="slug" class="input-label">Slug <em>*</em></label>
                        <input type="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                            class="input-box-md @error('slug') input-invalid @enderror" placeholder="Enter Email Address"
                            required minlength="1" maxlength="250">
                        @error('slug')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Thumbnail --}}
                    <div class="input-group 2xl:col-span-5 lg:col-span-4 md:col-span-2 sm:col-span-1">
                        <label for="img" class="input-label">Thumbnail <span>(Format: png, jpg, jpeg, webp,
                                avif)</span> <em>*</em></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/avif"
                                    onchange="handleThumbnailPreview(event)" name="img">
                                <i data-feather="upload-cloud"></i>
                                <span>Darg and Drop Image Files</span>
                            </div>
                            <img src="{{ is_null($category->img) ? asset('admin/images/default-thumbnail.png') : asset('storage/' . $category->img) }}"
                                id="img" alt="img" class="input-thumbnail-preview">

                        </div>
                        @error('img')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>


                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Save Changes</button>
            </div>
        </figure>
    </form>
@endsection


@section('panel-script')
    <script>
        document.getElementById('category-tab').classList.add('active');


        const handleThumbnailPreview = (event) => {
            if (event.target.files.length == 0) {
                document.getElementById('img').src = "{{ asset('admin/images/default-thumbnail.png') }}";
            } else {
                document.getElementById('img').src = URL.createObjectURL(event.target.files[0])
            }
        }
    </script>
@endsection
