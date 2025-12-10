@extends('partials.admin')
@section('title', 'Admin Ads Create')
@section('content')

@include('layouts.header', ['admin' => true])
@include('layouts.sidebar', ['admin' => true, 'active' => 'ads.create'])

<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            @include('layouts.breadcrumb', [
                'admin' => true,
                'pageTitle' => 'Create New Ad',
                'hasBack' => true,
                'backTitle' => 'Ads Listing',
                'backUrl' => route('admin.ads.index')
            ])

            <div class="row">
                <div class="col-lg-12">

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Something went wrong:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="card" method="POST" action="{{ route('admin.ads.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h3 class="card-title">Create New Ad Listing</h3>
                        </div>

                        <div class="card-body">

                            <!-- Ad Title -->
                            <x-input-item-field
                                name="title"
                                type="text"
                                label="Ad Title"
                                placeholder="Enter Ad Title"
                                required
                            />

                            <!-- Price -->
                            <x-input-item-field
                                name="price"
                                type="number"
                                label="Starting Price"
                                placeholder="Enter Starting Price"
                                required
                            />

                            <!-- Category Selector -->
                            <x-category-selectable :admin="true" />

                            <!-- Ad Description -->
                            <x-text-area-field
                                name="description"
                                label="Ad Description"
                                placeholder="Enter Ad Description"
                                :admin="true"
                                required
                            />

                            <!-- Start Date -->
                            <x-input-item-field
                                name="start_date"
                                type="datetime-local"
                                label="Start Date"
                                value="{{ old('start_date', now()->format('Y-m-d\TH:00')) }}"
                                required
                            />

                            <!-- End Date -->
                            <x-input-item-field
                                name="end_date"
                                type="datetime-local"
                                label="End Date"
                                value="{{ old('end_date', now()->addDays(1)->format('Y-m-d\TH:00')) }}"
                                required
                            />

                            <!-- Product Upload -->
                            <div class="row mt-4">
                                <label class="col-md-3 form-label">Product Images:</label>
                                <div class="col-md-9">
                                    <input
                                        type="file"
                                        name="images[]"
                                        accept=".jpg, .jpeg, .png"
                                        multiple
                                        class="form-control"
                                    >
                                    <small class="text-muted">You may upload up to 5 images.</small>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Create Ad Listing</button>
                            <a href="{{ route('admin.ads.index') }}" class="btn btn-default ms-2">Discard</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
        <!-- CONTAINER END -->
    </div>
</div>

@endsection

@push('scripts')
<script src="/plugin/fancyuploader/jquery.ui.widget.js"></script>
<script src="/plugin/fancyuploader/jquery.fileupload.js"></script>
<script src="/plugin/fancyuploader/jquery.iframe-transport.js"></script>
<script src="/plugin/fancyuploader/jquery.fancy-fileupload.js"></script>
<script src="/plugin/fancyuploader/fancy-uploader.js"></script>
@endpush

@push('styles')
<style>
    .ck .ck-powered-by {
        display: none !important;
    }
</style>
@endpush
