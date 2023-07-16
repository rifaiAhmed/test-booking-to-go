<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Family_list;
use App\Models\Nationality;

class ThisIsController extends Controller
{
    public function index()
    {
        $title = 'Home';
        $nationalitys = Nationality::all()->toArray();
        $custs = Customer::join(
            'nationality',
            'customer.nationality_id',
            '=',
            'nationality.nationality_id'
        )
            ->select(
                'customer.cst_name',
                'nationality.nationality_name',
                'customer.cst_id'
            )
            ->get();
        $data = [
            'title' => $title,
            'custs' => $custs,
            'nationals' => $nationalitys,
        ];
        return view('home', ['data' => $data]);
    }

    public function dataAll()
    {
        $data = Customer::join(
            'nationality',
            'customer.nationality_id',
            '=',
            'nationality.nationality_id'
        )
            ->select('customer.cst_name', 'nationality.nationality_name')
            ->get();

        return $data;
    }

    public function insertCustomer(Request $request)
    {
        $customer = new Customer();
        $customer->nationality_id = $request['nationality'];
        $customer->cst_name = $request['name'];
        $customer->cst_phone_num = $request['phone'];
        $customer->cst_email = $request['email'];
        $customer->cst_dob = $request['dob'];
        $customer->save();

        return response()->json(['status' => 'insert'], 200);
    }

    public function detail($id)
    {
        $customer = Customer::join(
            'nationality',
            'customer.nationality_id',
            '=',
            'nationality.nationality_id'
        )
            ->select(
                'customer.cst_id',
                'customer.cst_name',
                'nationality.nationality_name',
                'customer.cst_dob'
            )
            ->where('customer.cst_id', $id)
            ->first();
        $title = 'Detail';
        $familyLists = Family_list::where('cst_id', $id)->get();

        $data = [
            'customer' => $customer,
            'title' => $title,
            'familys' => $familyLists,
        ];

        return view('detail', ['data' => $data]);
    }

    public function deleteFam($id)
    {
        $fam = Family_list::find($id);

        if ($fam) {
            $fam->delete();
        }

        return response()->json(['status' => 'insert'], 200);
    }

    public function insertFam(Request $request)
    {
        $fam = new Family_list();
        $fam->cst_id = $request['cst_id'];
        $fam->fi_relation = $request['relation'];
        $fam->fi_name = $request['name'];
        $fam->fi_dob = $request['dob'];
        $fam->save();

        return response()->json(['status' => 'insert'], 200);
    }

    public function deleteCust($id)
    {
        $fam = Customer::find($id);

        if ($fam) {
            $fam->delete();
        }

        return response()->json(['status' => 'insert'], 200);
    }
}
