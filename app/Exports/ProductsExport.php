<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Return the collection of products with only the fields we need
        return Product::select('id', 'branchcalled', 'drug', 'response', 'call', 'branchthatcalled', 'created_at')->get();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Branch Name',
            'Drug Requested',
            'Response',
            'Number of Calls',
            'Branch called from',        
            'Date',
        ];
    }
}
