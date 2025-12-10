<form class="row bid-filter">
    <div class="col-sm-12 col-md-3">
        <div id="data-table_filter" class="dataTables_filter">
            <label>Search for a username, transaction IDs, etc</label>
            <input type="search" name="search" class="form-control form-control" placeholder="Search username, transaction IDs..."
                aria-controls="data-table" value="{{ request()->search }}">
            <span class="text-danger">{{ $errors->first('search') }}</span>
        </div>
    </div>

    <!-- Remove Price Range -->
    <div class="col-sm-12 col-md-3">
        <div class="row mb-4">
            <div class="col-md-12">
                <label>Payment Method</label>
                <select name="payment_method" class="form-control form-select select2" data-bs-placeholder="Select Payment Method">
                    <option value="">All</option>
                    <option value="GCASH" @selected('GCASH' == request()->payment_method)>GCash</option>
                    <option value="COD" @selected('COD' == request()->payment_method)>COD</option>
                </select>
                <span class="text-danger">{{ $errors->first('payment_method') }}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="row mb-4">
            <div class="col-md-12">
                <label>Date from:</label>
                <input type="date" class="form-control" placeholder="Select date from" name="date_from" value="{{ request()->date_from }}">
                <span class="text-danger">{{ $errors->first('date_from') }}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="row mb-4">
            <div class="col-md-12">
                <label>Date to:</label>
                <input type="date" class="form-control" placeholder="Select date to" name="date_to" value="{{ request()->date_to }}">
                <span class="text-danger">{{ $errors->first('date_to') }}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-1 align-self-end">
        <div class="row mb-4">
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="Filter">
            </div>
        </div>
    </div>
</form>
