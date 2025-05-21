<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InterestController extends Controller
{

public function save(Request $request)
{
    $validatedData = $request->validate([
        'interests' => 'required|array',
        'interests.*' => 'string'
    ]);
    
    $user = auth()->user();
    $interestIds = \App\Models\Interest::whereIn('name', $validatedData['interests'])->pluck('id');
    
    $user->interests()->sync($interestIds);
    
    return response()->json(['success' => true]);

}
}