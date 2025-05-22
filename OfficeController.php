<?php

namespace App\Http\Controllers;

use App\Models\GatePass;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Show all waiting gate pass requests.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all gate pass requests that are in the "waiting" status
        $requests = GatePass::where('status', 'waiting')->get();

        // Return the 'office.requests' view with the list of waiting requests
        return view('office.requests', compact('requests'));
    }

    /**
     * Approve a gate pass request.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveRequest($id)
    {
        // Find the gate pass by ID
        $request = GatePass::findOrFail($id);

        // Update the status to 'approved'
        $request->status = 'approved';
        $request->save();

        // Redirect back to the office requests page with success message
        return redirect()->route('office.requests')->with('success', 'Gate pass request approved.');
    }

    /**
     * Waitlist a gate pass request (optional).
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function waitlistRequest($id)
    {
        // Find the gate pass by ID
        $request = GatePass::findOrFail($id);

        // Reset the status to 'waiting'
        $request->status = 'waiting';
        $request->save();

        // Redirect back to the office requests page with success message
        return redirect()->route('office.requests')->with('success', 'Gate pass request is now waitlisted.');
    }
}

