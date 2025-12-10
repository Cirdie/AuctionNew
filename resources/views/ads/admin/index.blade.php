@extends('partials.admin')
@section('title', 'Admin Ads')
@section('content')

@include('layouts.header', ['admin' => true])
@include('layouts.sidebar', ['admin' => true, 'active' => 'ads.all'])

<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            @include('layouts.breadcrumb', [
                'admin' => true,
                'pageTitle' => 'Ads Listing',
                'hasBack' => true,
                'backTitle' => 'Dashboard',
                'backUrl' => route('admin.dashboard')
            ])

            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">All Ads</h3>

                            <!-- ⭐ ADD LISTING BUTTON ⭐ -->
                            <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus me-2"></i> Add Listing
                            </a>
                        </div>

                        <x-admin-ad-table :collection="$ads" />

                    </div>
                </div>
            </div>

        </div>
        <!-- CONTAINER END -->

    </div>
</div>

@endsection
