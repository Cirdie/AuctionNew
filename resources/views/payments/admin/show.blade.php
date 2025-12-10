@extends('partials.admin')
@section('title', 'Payment Details' . ' - ' . $payment->txn_id)
@section('content')

@include('layouts.header', ['admin' => true])
@include('layouts.sidebar', ['admin' => true, 'active' => 'payments'])

<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            @include('layouts.breadcrumb', ['admin' => true, 'pageTitle' => 'Payment Details', 'hasBack' => true, 'backTitle' => 'All Payments', 'backUrl' => route('admin.payments.index')])
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card productdesc">
                        <div class="card-body">
                            <div class="panel panel-primary">
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active pt-5" id="tab6" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td class="fw-bold">Transaction ID</td>
                                                            <td>
                                                                <i class="fa-regular fa-money-from-bracket"></i>
                                                                {{ $payment->txn_id }}
                                                                <i class="fa-regular fa-copy copy-text" onclick="copyTransactionID('{{ $payment->txn_id }}')"></i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">Payer Name</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="avatar bradius"
                                                                       style="background-image: url({{$payment->payer->avatar}})"></span>
                                                                    <div class="ms-3 mt-0 d-block">
                                                                       <a href="{{route('admin.users.show', $payment->payer->id)}}"
                                                                          class="mb-0 fs-14 fw-semibold text-info">
                                                                            {{ $payment->payer->name }}
                                                                       </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">Amount</td>
                                                            <td> {{ money($payment->amount) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">Status</td>
                                                            <td><span class="bg-{{ $payment->status->color() }} badge text-uppercase px-2">{{ $payment->status->label() }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">Method</td>
                                                            <td class="text-capitalize">{{ $payment->method ?? 'GCash' }}</td>
                                                        </tr>

                                                        <!-- GCash Receipt -->
                                                        @if($payment->gcash_receipt_path)
                                                        <tr>
                                                            <td class="fw-bold">GCash Receipt</td>
                                                            <td>
                                                                <div class="mt-2">
                                                                    <a href="javascript:void(0);" class="text-info" data-bs-toggle="modal" data-bs-target="#gcashReceiptModal">
                                                                        See Receipt
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endif

                                                        <tr>
                                                            <td class="fw-bold">Payer Address</td>
                                                            <td>
                                                                <div class="mt-2 d-block">
                                                                    {{ $payment->delivery_address ?? 'No address provided' }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">Linked Bid</td>
                                                            <td>
                                                                @if($payment->bid?->exists())
                                                                    <a href="{{ route('admin.bids.show', $payment->bid->id) }}">See linked bid here - {{ $payment->bid->id }}</a>
                                                                @else
                                                                    <span class="text-danger">No bid linked</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">Linked Ad</td>
                                                            <td>
                                                                @if($payment->ad?->exists())
                                                                    <a href="{{ route('admin.ads.show', $payment->ad->slug) }}">See linked ad here - {{ $payment->ad->title }}</a>
                                                                @else
                                                                    <span class="text-danger">No ad linked</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">Created At</td>
                                                            <td> {{ $payment->created_at->format('d M Y h:i A') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Modal for GCash Receipt -->
<div class="modal fade" id="gcashReceiptModal" tabindex="-1" aria-labelledby="gcashReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcashReceiptModalLabel">GCash Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Show GCash Receipt Image -->
                <div class="text-center">
                    <img src="{{ asset('storage/' . $payment->gcash_receipt_path) }}"
                         alt="GCash Receipt"
                         class="img-fluid"
                         style="max-width: 50%; height: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Accept/Reject Buttons Outside the Table -->
                        <div class="col-12 mt-4">
                            <form action="{{ route('admin.payments.update.status', $payment->txn_id) }}" method="POST" class="w-100">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="status" value="SUCCESS">
                                <button type="submit" class="account-btn w-100">
                                    <i class="bi bi-credit-card-2-front-fill"></i>
                                    Accept Payment
                                </button>
                            </form>

                            <form action="{{ route('admin.payments.update.status', $payment->txn_id) }}" method="POST" class="w-100 mt-3">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="status" value="FAILED">
                                <button type="submit" class="account-btn w-100">
                                    <i class="bi bi-x-circle"></i>
                                    Reject Payment
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- CONTAINER END -->
    </div>
</div>

@endsection

@push('scripts')
<script>
    function copyTransactionID(txn_id) {
        navigator.clipboard.writeText(txn_id);
        alert('Transaction ID copied to clipboard');
    }
</script>
@endpush
