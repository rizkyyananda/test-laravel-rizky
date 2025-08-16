<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FamilyList;
use App\Models\Nationality;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome', [
            'customer'    => Customer::with(['nationality','familyLists'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10),
            'nationality' => Nationality::all(), 
        ])->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'name'             => 'required|string|max:100',
                'dob'              => 'required|date', 
                'phone_number'     => 'required|string|max:20',
                'email'            => 'required|email|max:100|unique:customer,email',
                'nationality_id'   => 'required|exists:nationality,id',
                'families'         => 'nullable|array',
                'families.*.name'  => 'required_with:families|string|max:100',
                'families.*.dob'   => 'required_with:families|date',
            ]);

            DB::transaction(function () use ($validated) {
                $customer = Customer::create([
                    'name'           => $validated['name'],
                    'dob'            => $validated['dob'],
                    'phone_number'   => $validated['phone_number'],
                    'email'          => $validated['email'],
                    'nationality_id' => $validated['nationality_id'],
                ]);

                $families = collect($validated['families'] ?? [])
                    ->filter(function ($f) {
                        return !empty($f['name']) || !empty($f['dob']);
                    })
                    ->map(function ($f) {
                        return [
                            'name' => $f['name'] ?? '',
                            'dob'  => $f['dob']  ?? null,
                        ];
                    })
                    ->values()
                    ->all();
                if (!empty($families)) {
                    $customer->familyLists()->createMany($families);
                }
            });

            return redirect()->route('index')->with('success', 'Customer & Family berhasil disimpan.');
        }catch(Exception $e){
            dd($e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        try {
            // Hapus semua familyList terkait
            $customer->familyLists()->delete();

            // Hapus customer
            $customer->delete();

            return redirect()->route('index')
                            ->with('success', 'Customer dan data keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('index')
                            ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function familyDestroy(Customer $customer, FamilyList $family)
    {
        if ($family->customer_id !== $customer->id) {
            abort(404);
        }

        $family->delete();

        return back()->with('success', 'Data keluarga berhasil dihapus.');
    }

}
