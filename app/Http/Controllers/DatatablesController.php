<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;


class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('datatables.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {

       // $data = DB::table('users')->select('name','email','password');

        //$data = User::select(['name', 'email'])->get();

        return datatables()->of(DB::table('users'))->toJson();

        //return DataTables::of($data)->make(true);

    }
}