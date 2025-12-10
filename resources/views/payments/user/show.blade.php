@extends('partials.app')
@section('title', 'Payments')
@section('content')

@include('layouts.breadcrumb', [
    'admin'     => false,
    'pageTitle' => 'Payments',
    'hasBack'   => true,
    'backUrl'   => route('user.payments.index'),
    'backTitle' => 'Payments',
    'routeItem' => $payment->txn_id,
])

<div class="dashboard-section pt-120 pb-120">
    <div class="container">
        <div class="row g-4">
            @include('layouts.sidebar', ['active' => 'payments', 'admin' => false])

            <div class="col-lg-9">
                <div class="tab-pane">
                    <div class="payment-detail-wrapper">
                        <div class="mb-4">
                            <h3>Payment Details</h3>
                        </div>

                        <div class="row">
                            {{-- Transaction ID --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Transaction ID:</span>
                                    <h5>
                                        {{ $payment->txn_id }}
                                        <a href="javascript:void(0)"
                                           onclick="copyToClipboard('{{ $payment->txn_id }}')"
                                           title="Copy to clipboard"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           class="copy-btn"
                                           data-clipboard-text="{{ $payment->txn_id }}">
                                            <i class="far fa-copy"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>

                            {{-- Amount --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Amount:</span>
                                    <h5>{{ money($payment->amount) }}</h5>
                                </div>
                            </div>

                            {{-- Payment Method --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Payment Method:</span>
                                    <h5 class="badge bg-primary text-uppercase rounded-3 py-2 px-3">
                                        {{ $payment->payment_method ?? 'N/A' }}
                                    </h5>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Status:</span>
                                    <h5 class="text-{{ $payment->status->color() }}">
                                        {{ $payment->status->label() }}
                                    </h5>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Date:</span>
                                    <h5>{{ $payment->created_at->format('d M, Y h:i A') }}</h5>
                                </div>
                            </div>

                            {{-- Payer Email --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Payer Email:</span>
                                    <h5>{{ $payment->payer_email ?? 'N/A' }}</h5>
                                </div>
                            </div>

                            {{-- Bid link --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Bid Paid For:</span>
                                    <h5>
                                        <a href="{{ route('user.listing-bids.show', $payment->bid->id) }}"
                                           class="text-green">
                                            View Bid
                                        </a>
                                    </h5>
                                </div>
                            </div>

                            {{-- Ad link --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Ad Paid For:</span>
                                    <h5>
                                        <a href="{{ route('auction-details', $payment->bid->ad->slug) }}"
                                           class="text-green">
                                            View Ad
                                        </a>
                                    </h5>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="payment-detail-item">
                                    <span>Payment Description:</span>
                                    <h5>{{ $payment->description ?? 'No description' }}</h5>
                                </div>
                            </div>

                        </div> {{-- row --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-metric-card />

@push('scripts')
<script>
    function copyToClipboard(text) {
        const input = document.body.appendChild(document.createElement("input"));
        input.value = text;
        input.focus();
        input.select();
        document.execCommand('copy');
        input.parentNode.removeChild(input);
    }
</script>
@endpush

@endsection
