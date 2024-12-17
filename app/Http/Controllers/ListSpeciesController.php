<?php

namespace App\Http\Controllers;

use App\Models\ListSpecies;
use App\Http\Requests\StoreListSpeciesRequest;
use App\Http\Requests\UpdateListSpeciesRequest;
use Illuminate\Http\Request;

class ListSpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

     // Fungsi untuk mengambil data taksonomi
     public function getTaksonSatwa(Request $request)
     {
         // Get filter parameters from request
         $class = $request->query('class');
         $genus = $request->query('genus');
         $species = $request->query('spesies');
         $subspecies = $request->query('subspesies');
     
         // Initialize the query
         $query = ListSpecies::query();
     
         // Apply filters if provided
         if ($class) {
             $query->where('class', $class);
         }
         if ($genus) {
             $query->where('genus', $genus);
         }
         if ($species) {
             $query->where('spesies', $species);
         }
         if ($subspecies) {
             $query->where('subspesies', $subspecies);
         }
     
         // Get filtered data
         $taksonHewan = $query->get(['class', 'genus', 'spesies', 'subspesies']);
     
         // Return filtered data as JSON
         return response()->json($taksonHewan);
     }
     
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListSpeciesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ListSpecies $listSpecies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListSpecies $listSpecies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListSpeciesRequest $request, ListSpecies $listSpecies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListSpecies $listSpecies)
    {
        //
    }

    public function getSpecies(){}
}