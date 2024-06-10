<?php

namespace App\Http\Controllers;

use App\Models\Outgoingcalls;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\OutgoingStoreRequest;
use App\Exports\ProductsExport;
use App\Http\Requests\OutgoingUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class OutgoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outgoingcalls = Outgoingcalls::latest()->paginate(5);
          
        return view('alloutgoing', compact('outgoingcalls'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
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
        'branchthatcalled' => 'required|string|max:255',
        // Add other fields as needed
        ]);

        Outgoingcalls::create($validatedData);
           
        return redirect()->route('alloutgoing')
                         ->with('success', 'Outgoing calls reported successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Outgoingcalls $outgoingcall)
    {
        return view('show',compact('outgoingcall'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outgoingcalls $outgoingcall)
    {
        return view('edit',compact('outgoingcall'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OutgoingUpdateRequest $request, Outgoingcalls $outgoingcall): RedirectResponse
    {
        $outgoingcall->update($request->validated());
          
        return redirect()->route('alloutgoing')
                        ->with('success','Report updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outgoingcalls $outgoingcall)
    {
        $outgoingcall->delete();
           
        return redirect()->route('alloutgoing')
                        ->with('success','Outgoing calls deleted successfully');
    }

    /**
 * Show the form for creating a new resource.
 */

/**
 * Search the products based on various criteria.
 */
public function search(Request $request): \Illuminate\Contracts\View\View
    {
        $query = Outgoingcalls::query();

        if ($request->filled('branchcalled')) {
            $query->where('branchcalled', 'like', '%' . $request->branchcalled . '%');
        }

        if ($request->filled('branchthatcalled')) {
            $query->where('branchthatcalled', 'like', '%' . $request->branchthatcalled . '%');
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

        $outgoingcalls = $query->paginate(10);

        // Prepare the aggregated data for the table
        $drugData = [];
        foreach ($outgoingcalls as $call) {
            $drug = $call->drug;
            $branch = $call->branchcalled;
            
            if (!isset($drugData[$drug])) {
                $drugData[$drug] = [
                    'Asokoro' => 0, 'Maitama' => 0, 'Garki' => 0, 'Gimbiya PX' => 0,
                    'New Ademola' => 0, 'Old Ademola' => 0, 'Old Gwarinpa' => 0,
                    'New Gwarinpa' => 0, 'Gwarina 3' => 0, 'Gana PX' => 0, 'Ferma' => 0
                ];
            }

            if (array_key_exists($branch, $drugData[$drug])) {
                $drugData[$drug][$branch]++;
            }
        }

        return view('search', compact('outgoingcalls', 'drugData'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    
    
public function export()
    {
        return Excel::download(new ProductsExport, 'outgoingcalls.xlsx');
    }
    
    
}

