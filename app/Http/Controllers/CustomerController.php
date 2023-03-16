<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $customers = [];
        $allCustomers = Customer::all();
        foreach($allCustomers as $customer)
        {
            if ($request->user()->can('anyAction', $customer)) array_push($customers, $customer);
        }
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $user = $request->user();
        return view('customers.create', ["user"=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(["user_id"=>['required']]);

        Customer::create(['user_id' => $request->input('user_id')]);
        return redirect("customers");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        $customer = Customer::find($id);

        if ($request->user()->can('anyAction', $customer))
        return view("customers.show", ["customer" => $customer]);
        else abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        $customer = Customer::find($id);
        if ($request->user()->can('anyAction', $customer))
        return view("customers.edit", ["customer" => $customer]);
        else abort(403);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate(["user_id" => "required"]);
        $customer = Customer::find($id);
        if ($request->user()->can('anyAction', $customer))
        {
            $customer->user_id = $request->input("user_id");
            $customer->save();
            return redirect("customers/".$id);
        }
        else abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        $customer = Customer::find($id);
        if ($request->user()->can('anyAction', $customer))
        {
            $customer->delete();
            return redirect('/customers');
        }
        else abort(403);
    }
}
