<?php

namespace App\Http\Controllers\Filtering;

use App\DataTables\TableOneDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class YajraDataTableController extends Controller
{
    public function index(TableOneDataTable $dataTable)
    {
        return $dataTable->render('table_one');
    }
}
