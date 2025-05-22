<?php

namespace App\Http\Controllers;

use App\Models\GatePass;
use Illuminate\Http\Request;

class HODController extends Controller
{
    /**
     * Store Gate Pass Request
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'rollnos' => 'required|string', // Comma-separated roll numbers
            'names' => 'required|string',  // Comma-separated names
            'department' => 'required|string|max:255',
            'reason' => 'required|string',
            'timing' => 'required|string',
        ]);

        // Process roll numbers and names
        $rollnos = array_map('trim', explode(',', $validated['rollnos']));
        $names = array_map('trim', explode(',', $validated['names']));

        // Ensure counts match
        if (count($rollnos) !== count($names)) {
            return redirect()->back()->with('error', 'The number of roll numbers and names do not match.');
        }

        // Store the gate pass request
        GatePass::create([
            'rollnos' => implode(',', $rollnos),
            'names' => implode(',', $names),
            'department' => $validated['department'],
            'reason' => $validated['reason'],
            'timing' => $validated['timing'],
            'status' => 'waiting', // Default status
            'info' => null,        // Initialize info as null
        ]);

        return redirect()->back()->with('success', 'Gate pass request submitted successfully.');
    }

    /**
     * Display Gate Pass Requests
     */
    public function showRequests()
    {
        $requests = GatePass::all(); // Retrieve all requests

        // Determine the appropriate view
        $view = request()->routeIs('office') ? 'pass.office' : 'pass.requests';

        return view($view, compact('requests'));
    }

    /**
     * Delete Gate Pass Request
     */
    public function deleteRequest($id)
    {
        $request = GatePass::find($id);

        if ($request) {
            $request->delete();
            session()->forget('status_' . $id);
            return redirect()->back()->with('success', 'Request deleted successfully.');
        }

        return redirect()->back()->with('error', 'Request not found.');
    }

    /**
     * Update Gate Pass Status
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,waiting',
        ]);

        $gatePass = GatePass::find($id);

        if (!$gatePass) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        $gatePass->status = $validated['status']; // Update status in DB
        $gatePass->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    /**
     * Show Security Page for Approved Requests
     */
    public function showSecurityPage()
    {
        $approvedRequests = GatePass::where('status', 'approved')->get();

        return view('pass.security', compact('approvedRequests'));
    }

    /**
     * Confirm Gate Pass for Security
     */
    public function confirmRequest($id)
    {
        $request = GatePass::find($id);

        if (!$request) {
            return redirect()->route('security')->with('error', 'Request not found.');
        }

        $request->status = 'confirmed';
        $request->save();

        return redirect()->route('security')->with('success', 'Gate pass confirmed successfully.');
    }

    /**
     * Update Info for Gate Pass Request (Security Information)
     */
    public function updateInfo(Request $request, $id)
    {
        $validated = $request->validate([
            'info' => 'required|string|max:255',  // Info text (e.g., Student exited from the college)
        ]);

        $gatePass = GatePass::find($id);

        if (!$gatePass) {
            return response()->json([
                'success' => false,
                'message' => 'Gate pass request not found.'
            ]);
        }

        // Update the 'info' field in the database
        $gatePass->info = $validated['info'];
        $gatePass->save();

        // Return success response with updated info
        return response()->json([
            'success' => true,
            'info' => $validated['info'],
            'message' => 'Gate pass information updated successfully.'
        ]);
    }
}
