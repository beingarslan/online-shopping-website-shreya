@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <form action="" method="get">
                            @csrf
                            {{-- seller id --}}
                            <div class="form-group">
                                <label for="seller_id">Seller ID</label>
                                <input type="text" name="seller_id" id="seller_id" class="form-control"
                                    placeholder="Seller ID" aria-describedby="helpId">
                            </div>

                            {{-- search button --}}
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>

                        {{-- results --}}
                        <div class="mt-3">
                            @if (isset($results))
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item ID</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Currency</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">URL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>{{ $result->itemId }}</td>
                                                <td>{{ $result->title }}</td>
                                                <td>{{ $result->sellingStatus->currentPrice->value }}</td>
                                                <td>{{ $result->sellingStatus->currentPrice->currencyId }}</td>
                                                <td>{{ $result->condition->conditionDisplayName }}</td>
                                                <td>{{ $result->location }}</td>
                                                <td><a href="{{ $result->viewItemURL }}" target="_blank">View Item</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // search button
        $('button[type="submit"]').on('click', function(e) {
            e.preventDefault();
            // seller id
            var seller_id = $('#seller_id').val();
            // check seller id
            if (seller_id == '') {
                alert('Please enter seller id');
                return false;
            }
            // redirect to search_for_online_items
            window.location.href = '/search_for_online_items?seller_id=' + seller_id;
        });
    });
</script>

@endsection