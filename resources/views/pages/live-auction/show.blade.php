    @extends('partials.app')
    @section('title', 'Auction Detail')
    @section('description', 'Auction detail page')
    @section('content')

    @include('layouts.breadcrumb', ['admin' => false, 'pageTitle' => 'Auction Detail'])

    <div class="auction-details-section pt-120">
        <div class="container">

            @php
                // Determine the highest (current) bid
                $currentBid = $ad->bids->max('amount') ?? $ad->price;

                // Determine the next minimum bid
                $nextBid = $currentBid + 1;
            @endphp

            <div class="row g-4 mb-50">
                <!-- LEFT IMAGE SECTION -->
                <div class="col-xl-6 col-lg-7 d-flex flex-row align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4">

                    <ul class="nav small-image-list d-flex flex-md-column flex-row justify-content-center gap-4 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        @foreach ($ad->media as $media)
                            <li class="nav-item">
                                <div id="details-img{{ $loop->index + 1 }}"
                                    data-bs-toggle="pill"
                                    data-bs-target="#gallery-img{{ $loop->index + 1 }}"
                                    aria-controls="gallery-img{{ $loop->index + 1 }}">
                                    <img alt="image" src="{{ $media->url }}" class="img-fluid">
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mb-4 d-flex justify-content-lg-start justify-content-center wow fadeInUp"
                        data-wow-duration="1.5s" data-wow-delay=".4s">

                        @foreach ($ad->media as $media)
                            <div class="tab-pane big-image fade {{ $loop->index == 0 ? 'active show' : '' }}" id="gallery-img{{ $loop->index + 1 }}">
                                <div class="auction-gallery-timer d-flex align-items-center justify-content-center">
                                    <h3 class="countdown-classic">{{ $ad->expired_at }}</h3>
                                </div>
                                <img alt="image" src="{{ $media->url }}" class="img-fluid">
                            </div>
                        @endforeach

                    </div>
                </div>

                <!-- RIGHT DETAILS SECTION -->
                <div class="col-xl-6 col-lg-5">
                    <div class="product-details-right wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">

                        <h3>{{ $ad->title }}</h3>
                        <p class="para">{{ shorten_chars($ad->description, 150, true) }}</p>

                        <h4>Bidding Price: <span>{{ money($ad->price) }}</span></h4>
                        <h4>Current Bid: <span>{{ money($currentBid) }}</span></h4>

                        <div class="row d-flex mt-4">
                            <div class="ad-listing-item col-6">
                                <span>Seller Name:</span>
                                <p class="fw-bold">{{ $ad->seller_name }}</p>
                            </div>
                            <div class="ad-listing-item col-6">
                                <span>Seller Email:</span>
                                <p>{{ $ad->seller_email ?? 'Not Available' }}</p>
                            </div>
                            <div class="ad-listing-item col-6">
                                <span>Seller Phone:</span>
                                <p>{{ $ad->seller_mobile ?? 'Not Available' }}</p>
                            </div>
                            <div class="ad-listing-item col-6">
                                <span>Seller Address:</span>
                                <address>{{ $ad->seller_address ?? 'Not Available' }}</address>
                            </div>
                        </div>

                        <!-- BID FORM -->
                        @if($ad->active())
                            <div class="bid-form mt-0">
                                <div class="form-title">
                                    <h5>Bid Now</h5>
                                    <p>
                                        Current Bid: <strong>{{ money($currentBid) }}</strong><br>
                                        Minimum Next Bid: <strong>{{ money($nextBid) }}</strong>
                                    </p>
                                </div>

                                <form action="{{ route('bid.handle', $ad->slug) }}" method="POST">
                                    @csrf

                                    @guest
                                        <x-alert type="warning" icon="bi bi-exclamation-circle-fill">
                                            <p class="mb-0">
                                                You are currently not logged in. Please
                                                <strong><a href="{{ route('user.login') }}">login</a></strong>
                                                to place a bid.
                                            </p>
                                        </x-alert>
                                    @endguest

                                    <div class="form-inner gap-2">
                                        <input type="number"
                                            placeholder="₱0.00"
                                            name="amount"
                                            required
                                            @guest disabled @endguest
                                            @class(['error' => $errors->has('amount')])
                                            min="{{ $nextBid }}"
                                            value="{{ old('amount') }}">

                                        <button
                                            @class([
                                                'eg-btn btn--primary btn--sm' => auth()->check(),
                                                'eg-btn btn--primary btn--sm disabled' => !auth()->check()
                                            ])
                                            @guest disabled @else type="submit" @endguest
                                        >
                                            Place a Bid
                                        </button>
                                    </div>

                                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                                </form>
                            </div>

                        @else
                            <x-alert type="dark" icon="bi bi-exclamation-circle-fill">
                                @if($ad->expired())
                                    <p class="text-dark mb-0">This auction has expired.</p>
                                @elseif($ad->upcoming())
                                    <p class="text-dark mb-0">This auction has not started yet.</p>
                                @else
                                    <p class="text-dark mb-0">This auction is closed.</p>
                                @endif
                            </x-alert>
                        @endif

                    </div>
                </div>
            </div>

            <!-- BIDDING HISTORY + OTHER AUCTIONS -->
            <div class="row d-flex justify-content-center g-4">
                <div class="col-lg-8">
                    <ul class="nav nav-pills d-flex flex-row justify-content-start gap-sm-4 gap-3 mb-45 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".2s">

                        <li class="nav-item">
                            <button class="nav-link active details-tab-btn" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button">Description</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link details-tab-btn" data-bs-toggle="pill"
                                data-bs-target="#pills-bid" type="button">Bidding History</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link details-tab-btn" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button">Other Auctions</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- DESCRIPTION TAB -->
                        <div class="tab-pane fade show active wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s"
                            id="pills-home">
                            <div class="describe-content">
                                {!! $ad->description !!}
                            </div>
                        </div>

                        <!-- BIDDING HISTORY TAB -->
                        <div class="tab-pane fade" id="pills-bid">
                            <div class="bid-list-area">
                                <ul class="bid-list">
                                    @forelse ($ad->bids->sortByDesc('amount') as $bid)
                                        <li>
                                            <div class="row d-flex align-items-center">
                                                <div class="col-7">
                                                    <div class="bidder-area">
                                                        <div class="bidder-img">
                                                            <img alt="image" src="{{ $bid->user->avatar }}" class="avatar-img">
                                                        </div>
                                                        <div class="bidder-content">
                                                            <h6>{{ $bid->user->name }}</h6>
                                                            <p>{{ money($bid->amount) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-5 text-end">
                                                    <p>{{ $bid->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <div class="alert alert-warning">No bids yet.</div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <!-- OTHER AUCTIONS TAB -->
                        <div class="tab-pane fade" id="pills-contact">
                            <div class="row d-flex justify-content-center g-4">
                                @foreach ($ad->relatedAds()->get() as $related)
                                    <x-ad-item-card :ad="$related" type="small" />
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-banner wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="1s">
                            <div class="banner-content">
                                <span>CARS</span>
                                <h3>Toyota AIGID A Classic Cars Sale</h3>
                                <a href="{{ route('auction-details', $ad->slug) }}"
                                class="eg-btn btn--primary card--btn">Details</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <x-metric-card :class="'pt-120'" />

    @push('scripts')
        <script src="/assets/js/countdown.js"></script>
    @endpush

    @endsection
