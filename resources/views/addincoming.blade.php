@extends('products.layout')
    
@section('content')
  
<div class="card mt-5">
  <h2 class="card-header text-primary text-center">Add New Incoming Report</h2>
  <div class="card-body">
  
    
  
    <form action="{{ route('incomingcalls.store') }}" method="POST">
        @csrf
  
        <div class="mb-3">
            <label for="inputBranchcalled" class="form-label"><strong>Branch Called:</strong></label>
            <select name="branchcalled" id="inputBranchcalled" class="form-select @error('branchcalled') is-invalid @enderror">
                <option value="">Select Branch</option>
                <option value="Asokoro">Asokoro</option>
                <option value="Maitama">Maitama</option>
                <option value="Garki">Garki</option>
                <option value="Gimbiya PX">Gimbiya PX</option>
                <option value="New Ademola">New Ademola</option>
                <option value="Old Ademola">Old Ademola</option>
                <option value="Old Gwarinpa">Old Gwarinpa</option>
                <option value="New Gwarinpa">New Gwarinpa</option>
                <option value="Gwarina 3">Gwarina 3</option>
                <option value="Gana PX">Gana PX</option>
                <option value="Ferma">Ferma</option>
                <option value="Wholesale">Wholesale</option>
                <option value="Gan Aso Guz">Gan Aso Guz</option>                  
            </select>
            @error('branchcalled')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
  
        <div class="mb-3">
            <label for="inputDrug" class="form-label"><strong>Drug Requested:</strong></label>
            <input 
                type="text" 
                name="drug" 
                class="form-control @error('drug') is-invalid @enderror" 
                id="inputDrug" 
                placeholder="Name of Drug Requested e.g Amoksiklav 1g">
            @error('drug')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputResponse" class="form-label"><strong>Response:</strong></label>
            <select name="response" id="inputResponse" class="form-select @error('response') is-invalid @enderror">
                <option value="">Select Response</option>
                <option value="in_stock">in_stock</option>
                <option value="out_of_stock">out_of_stock</option>
                <option value="no_response">no_response</option>              
            </select>
            @error('response')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputCall" class="form-label"><strong>Number of Calls:</strong></label>
            <input 
                type="text" 
                name="call" 
                class="form-control @error('call') is-invalid @enderror" 
                id="inputCall" 
                placeholder="Number of  Calls Made e.g 1">
            @error('call')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- New fields: customer name and phone -->
        <div class="mb-3">
            <label for="inputCustomer" class="form-label"><strong>Customer Name:</strong></label>
            <input 
                type="text" 
                name="customer" 
                class="form-control @error('customer') is-invalid @enderror" 
                id="inputCustomer" 
                placeholder="Customer Name">
            @error('customer')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputPhone" class="form-label"><strong>Customer Phone:</strong></label>
            <input 
                type="text" 
                name="phone" 
                class="form-control @error('phone') is-invalid @enderror" 
                id="inputPhone" 
                placeholder="Phone Number">
            @error('phone')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- End of new fields -->

        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
    </form>
  
  </div>
</div>
@endsection
