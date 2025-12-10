@extends('partials.app')
@section('title', 'Listing Bid - ' . $bid->ad->title)
@section('content')

@include('layouts.breadcrumb', [
    'admin'     => false,
    'pageTitle' => 'Listing Bid',
    'hasBack'   => true,
    'backUrl'   => route('user.listing-bids'),
    'backTitle' => 'My Bids',
    'routeItem' => $bid->ad->title,
])

<div class="dashboard-section pt-120 pb-120">
    <div class="container">
        <div class="row g-4">
            @include('layouts.sidebar', ['active' => 'bidding', 'admin' => false])

            <div class="col-lg-9">
                <div class="tab-pane">

                    {{-- ===================== AD DETAILS ===================== --}}
                    <div class="ad-listing-wrapper">
                        <div class="row gy-2 d-flex">

                            {{-- IMAGES --}}
                            <div class="col-xl-6 col-lg-7 d-flex flex-row align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4">
                                <ul class="nav small-image-list d-flex flex-md-column flex-row justify-content-center gap-4 wow fadeInDown"
                                    data-wow-duration="1.5s" data-wow-delay=".4s">
                                    @foreach ($bid->ad->media as $media)
                                        <li class="nav-item">
                                            <div id="details-img{{ $loop->index + 1 }}"
                                                 data-bs-toggle="pill"
                                                 data-bs-target="#gallery-img{{ $loop->index + 1 }}">
                                                <img alt="image" src="{{ $media->url }}" class="img-fluid">
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content mb-4 d-flex justify-content-lg-start justify-content-center wow fadeInUp"
                                     data-wow-duration="1.5s" data-wow-delay=".4s">
                                    @foreach ($bid->ad->media as $media)
                                        <div class="tab-pane big-image fade {{ $loop->index == 0 ? 'active show' : '' }}"
                                             id="gallery-img{{ $loop->index + 1 }}">
                                            <div class="auction-gallery-timer d-flex align-items-center justify-content-center">
                                                <h3>Ad Images</h3>
                                            </div>
                                            <img alt="image" src="{{ $media->url }}" class="img-fluid">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- AD INFO --}}
                            <div class="col-xl-6 col-lg-5">
                                <div class="ad-listing-item">
                                    <span>Title:</span>
                                    <h3>{{ $bid->ad->title }}</h3>
                                </div>

                                <div class="ad-listing-item">
                                    <span>Starting Price:</span>
                                    <h5>{{ money($bid->ad->price) }}</h5>
                                </div>

                                <div class="ad-listing-item">
                                    <span>Timeframe:</span>
                                    <p>
                                        {{ $bid->ad->started_at->format('d M Y h:i A') }}
                                        -
                                        {{ $bid->ad->expired_at->format('d M Y h:i A') }}
                                    </p>
                                </div>

                                <div class="row d-flex">
                                    <div class="ad-listing-item col-6">
                                        <span>Ad Status:</span>
                                        <p class="text-{{ $bid->ad->status->color() }}">
                                            {{ $bid->ad->status->label() }}
                                        </p>
                                    </div>

                                    <div class="ad-listing-item col-6">
                                        <span>Bid Status:</span>
                                        <p class="text-{{ is_null($bid->is_accepted) ? 'warning' : ($bid->is_accepted ? 'success' : 'danger') }}">
                                            {{ is_null($bid->is_accepted) ? 'Pending' : ($bid->is_accepted ? 'Accepted' : 'Rejected') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ===================== WINNING BID ===================== --}}
                    @if ($bid->is_accepted)
                        <div class="ad-listing-wrapper mt-4">
                            <h3>My Winning Bid:</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Bidder Name</th>
                                        <th scope="col">Bidder Email</th>
                                        <th scope="col">Bidder Phone</th>
                                        <th scope="col">Bid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $bid->user->name }}</td>
                                        <td>{{ $bid->user->email }}</td>
                                        <td>{{ $bid->user->mobile }}</td>
                                        <td>{{ money($bid->amount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="ad-listing-wrapper mt-4">
                            <h3>My Winning Bid:</h3>
                            <p class="text-danger text-center">No Winning Bid</p>
                        </div>
                    @endif

                    {{-- ===================== PAYMENT SECTION ===================== --}}
                    @if ($bid->is_accepted)
                        @php
                            $payment = $bid->payment;
                        @endphp

                        {{-- SUCCESSFUL PAYMENT --}}
                        @if ($payment && $payment->status === \App\Enums\PaymentStatus::SUCCESS)
                            <div class="ad-listing-wrapper mt-4">
                                <h3>Payment Details</h3>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Payment ID</th>
                                            <td>{{ $payment->txn_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>{{ $payment->payment_method }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td class="text-success fw-bold text-uppercase">
                                                {{ $payment->status->label() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>{{ money($payment->amount) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>{{ $payment->created_at->format('d M Y h:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        {{-- PENDING PAYMENT -> JUST MESSAGE, NO FORM --}}
                        @elseif ($payment && $payment->status === \App\Enums\PaymentStatus::PENDING)
                            <div class="ad-listing-wrapper mt-4">
                                <h3>Payment Status</h3>
                                <p class="text-warning text-center fw-semibold">
                                    Your payment is currently <strong>PENDING</strong>.<br>
                                    Please wait while the admin reviews and confirms your payment.
                                </p>
                                <p class="text-center small text-muted">
                                    You will see the updated status here once it has been approved or rejected.
                                </p>
                            </div>

                        {{-- FAILED PAYMENT -> SHOW FORM TO RETRY --}}
                        @elseif ($payment && $payment->status === \App\Enums\PaymentStatus::FAILED)
                            <div class="ad-listing-wrapper mt-4">
                                <h3>Payment</h3>
                                <p class="text-danger text-center">
                                    Your last payment attempt <strong>FAILED</strong>. Please try again.
                                </p>

                                <div class="d-flex justify-content-center mt-4">
                                    <x-payable-form :bid="$bid" :user="auth()->user()" />
                                </div>
                            </div>

                        {{-- NO PAYMENT YET -> SHOW FORM --}}
                        @else
                            <div class="ad-listing-wrapper mt-4">
                                <h3>Payment</h3>
                                <p class="text-center">
                                    You have not submitted your payment yet. Please complete the form below.
                                </p>

                                <div class="d-flex justify-content-center mt-4">
                                    <x-payable-form :bid="$bid" :user="auth()->user()" />
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

<x-metric-card />

@endsection
