<?php

namespace App\Http\Controllers\Filtering;

use App\DataTables\TableOneDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YajraDataTableController extends Controller
{
    public function index(Request $request, TableOneDataTable $dataTable)
    {
        Log::info("\nSTART DATE: " . $request->start_date);
        Log::info("\nEND DATE: " . $request->end_date);
        Log::info("\CATEGORY DATE: " . $request->end_date);
        return $dataTable->render('table_one');
    }
}
