<?php

namespace App\Http\Controllers\Filtering;

use App\DataTables\TableOneDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class YajraDataTableController extends Controller
{
    public function index(Request $request, TableOneDataTable $dataTable)
    {
        $my_data = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
        ];
        Log::info("\nAA DATA: " . json_encode($my_data));
        return $dataTable->with(['data' => $my_data])->render('table_one');
    }

    public function table_two()
    {
        return view('table_two');
    }

    public function table_two_data(Request $request)
    {
        $users = User::query()->get();
        return DataTables::of($users);
    }
}
