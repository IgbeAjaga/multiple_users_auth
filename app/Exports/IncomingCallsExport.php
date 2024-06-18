<?php

namespace App\Exports;

use App\Models\Incomingcalls;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class IncomingCallsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Incomingcalls::select('id', 'branchcalled', 'drug', 'response', 'call', 'customer', 'phone', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Branch Called',
            'Drug Requested',
            'Response',
            'Number of Calls',
            'Customer Name',
            'Customer Phone',
            'Date'
        ];
    }
}
