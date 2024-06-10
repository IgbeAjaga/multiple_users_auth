<?php

namespace App\Http\Controllers;

use App\Models\Incomingcalls;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\IncomingStoreRequest;
use App\Exports\ProductsExport;
use App\Http\Requests\IncomingUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomingcalls = Incomingcalls::latest()->paginate(5);
          
        return view('allincoming', compact('incomingcalls'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addincoming');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'branchcalled' => 'required|string|max:255',
        'drug' => 'required|string|max:255',
        'response' => 'required|string|max:255',
        'call' => 'required|integer',
        'customer' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        // Add other fields as needed
        ]);

        Incomingcalls::create($validatedData);
           
        return redirect()->route('allincoming')
                         ->with('success', 'Incominging calls reported successfully.');
    }

   /**
     * Display the specified resource.
     */
    public function show(Incomingcalls $incomingcall)
    {
        return view('showin',compact('incomingcall'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incomingcalls $incomingcall)
    {
        return view('editin',compact('incomingcall'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomingUpdateRequest $request, Incomingcalls $incomingcall): RedirectResponse
    {
        $incomingcall->update($request->validated());
          
        return redirect()->route('allincoming')
                        ->with('success','Report updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incomingcalls $incomingcall)
    {
        $incomingcall->delete();
           
        return redirect()->route('allincoming')
                        ->with('success','Incoming calls deleted successfully');
    }
     /**
     * Show the form for creating a new resource.
     */
  
    /**
     * Search the products based on various criteria.
     */
    public function search(Request $request): \Illuminate\Contracts\View\View
    {
        $query = Incomingcalls::query();

        if ($request->filled('branchcalled')) {
            $query->where('branchcalled', 'like', '%' . $request->branchcalled . '%');
        }

        if ($request->filled('customer')) {
            $query->where('customer', 'like', '%' . $request->customer . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('drug')) {
            $query->where('drug', 'like', '%' . $request->drug . '%');
        }

        if ($request->filled('response')) {
            $query->where('response', $request->response);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $incomingcalls = $query->paginate(10);

        // Prepare the aggregated data for the table
        $drugData = [];
        foreach ($incomingcalls as $call) {
            $drug = $call->drug;
            $branch = $call->branchcalled;
            
            if (!isset($drugData[$drug])) {
                $drugData[$drug] = [
                    'Asokoro' => 0, 'Maitama' => 0, 'Garki' => 0, 'Gimbiya PX' => 0,
                    'New Ademola' => 0, 'Old Ademola' => 0, 'Old Gwarinpa' => 0,
                    'New Gwarinpa' => 0, 'Gwarina 3' => 0, 'Gana PX' => 0, 'Ferma' => 0, 
                    'Wholesale' => 0, 'Gan Aso Guz' => 0
                ];
            }

            if (array_key_exists($branch, $drugData[$drug])) {
                $drugData[$drug][$branch]++;
            }
        }

        return view('searchin', compact('incomingcalls', 'drugData'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

public function export()
    {
        return Excel::download(new incomingcallsExport, 'incomingcalls.xlsx');
    }
    
    
}

