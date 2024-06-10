@extends('products.layout')

@section('content')

<div class="card mt-5">
  <div class="card-body">

    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
      <a class="btn btn-primary btn-sm" href="{{ route('allincoming') }}">
        <i class="fa fa-arrow-left"></i> Back
      </a>
      <button class="btn btn-success btn-sm" onclick="window.print()">
        <i class="fa fa-print"></i> Print
      </button>
    </div>

    <!-- Small Table to show aggregated data -->
    <h2 class="card-header text-center text-primary"><strong>SUMMARY OF:</strong> 
    @if(request('drug'))  {{ request('drug') }} @endif
    @if(request('response')) drugs {{ request('response') }} - @endif
    @if(request('branchcalled')) {{ request('branchcalled') }} branch @endif
    @if(request('customer')) {{ request('customer') }} customer @endif
    @if(request('phone')) {{ request('phone') }} phone @endif
    @if(request('date_from')) from {{ request('date_from') }} @endif
    @if(request('date_to')) to {{ request('date_to') }} @endif
    </h2>
    <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>Drug</th>
                    <th>Asokoro</th>
                    <th>Maitama</th>
                    <th>Garki</th>
                    <th>Gimbiya PX</th>
                    <th>New Ademola</th>
                    <th>Old Ademola</th>
                    <th>Old Gwarinpa</th>
                    <th>New Gwarinpa</th>
                    <th>Gwarina 3</th>
                    <th>Gana PX</th>
                    <th>Ferma</th>
                    <th>Wholesale</th>
                    <th>Gan Aso Guz</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drugData as $drug => $branches)
                    <tr>
                        <td>{{ $drug }}</td>
                        @foreach($branches as $branch => $count)
                            <td>{{ $count }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <h2 class="card-header text-center text-primary"><strong>DETAILS OF:</strong> 
        @if(request('drug'))  {{ request('drug') }} @endif
        @if(request('response')) drugs {{ request('response') }} - @endif
        @if(request('branchcalled')) {{ request('branchcalled') }} branch @endif
        @if(request('customer')) {{ request('customer') }} customer @endif
        @if(request('phone')) {{ request('phone') }} phone @endif
        @if(request('date_from')) from {{ request('date_from') }} @endif
        @if(request('date_to')) to {{ request('date_to') }} @endif
        </h2>
    <table class="table table-bordered table-striped mt-4">
      <thead>
        <tr>
          <th width="80px">SN</th>
          <th>Branch Called</th>
          <th>Drug Requested</th>
          <th>Response</th>
          <th>Number of Calls</th>
          <th>Branch called from</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($incomingcalls as $incomingcall)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $incomingcall->branchcalled }}</td>
            <td>{{ $incomingcall->drug }}</td>
            <td>{{ $incomingcall->response }}</td>
            <td>{{ $incomingcall->call }}</td>
            <td>{{ $incomingcall->branchthatcalled }}</td>
            <td>{{ $incomingcall->customer }}</td>
            <td>{{ $incomingcall->phone }}</td>              
            <td>{{ $incomingcall->created_at->format('Y-m-d H:i:s') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="7">No results found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {!! $incomingcalls->links() !!}
  </div>
</div>
@endsection
