<?php

namespace App\Http\Controllers;

use App\Models\family_members;
use App\Http\Requests\Storefamily_membersRequest;
use App\Http\Requests\Updatefamily_membersRequest;

class FamilyMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Storefamily_membersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(family_members $family_members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(family_members $family_members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatefamily_membersRequest $request, family_members $family_members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(family_members $family_members)
    {
        //
    }
}
