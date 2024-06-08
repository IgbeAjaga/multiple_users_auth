<?php

namespace App\Http\Controllers;

use App\Models\Incomingcalls;
use Illuminate\Http\Request;

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
    public function show(Incomingcalls $incomingcalls)
    {
        return view('show',compact('incomingcalls'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incomingcalls $incomingcalls)
    {
        return view('editin',compact('incomingcalls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomingUpdateRequest $request, Incomingcalls $incomingcalls): RedirectResponse
    {
        $incomingcalls->update($request->validated());
          
        return redirect()->route('allincoming')
                        ->with('success','Report updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incomingcalls $incomingcalls)
    {
        $incomingcalls->delete();
           
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
    $query = Outgoingcalls::query();

    if ($request->filled('branchcalled')) {
        $query->where('branchcalled', 'like', '%' . $request->branchcalled . '%');
    }

    if ($request->filled('drug')) {
        $query->where('drug', 'like', '%' . $request->drug . '%');
    }

    if ($request->filled('response')) {
        $query->where('response', $request->response);
    }
    if ($request->filled('branchthatcalled')) {
        $query->where('branchthatcalled', 'like', '%' . $request->branchthatcalled . '%');
    }

    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $outgoingcalls = $query->paginate(10);

    // Prepare the aggregated data for the table
    $drugData = $outgoingcalls->groupBy('drug')->map(function ($items, $drug) {
        $branches = [
            'Asokoro' => 0, 'Maitama' => 0, 'Garki' => 0, 'Gimbiya PX' => 0,
            'New Ademola' => 0, 'Old Ademola' => 0, 'Old Gwarinpa' => 0,
            'New Gwarinpa' => 0, 'Gwarina 3' => 0, 'Gana PX' => 0, 'Ferma' => 0
        ];
    
        foreach ($items as $item) {
            if (array_key_exists($item->branchthatcalled, $branches)) {
                $branches[$item->branchthatcalled]++;
            }
        }
    
        return array_merge(['drug' => $drug], $branches);
    });   
        

    return view('search', compact('outgoingcalls', 'drugData'))->with('i', (request()->input('page', 1) - 1) * 10);
}

public function export()
    {
        return Excel::download(new incomingcallsExport, 'incomingcalls.xlsx');
    }
    
    
}
