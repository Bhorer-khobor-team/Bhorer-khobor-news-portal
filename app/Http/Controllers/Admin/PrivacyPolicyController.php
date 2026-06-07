<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;


class PrivacyPolicyController extends Controller
{
    public function edit()
    {
        // firstOrCreate: get existing row OR create empty one if none exists
        // This is a singleton — always exactly 1 row in the table
        $policy = PrivacyPolicy::firstOrCreate([], ['content' => '']);
        return view('admin.pages.privacy', compact('policy'));
    }


    public function update(Request $request)
    {
        $request->validate(['content' => 'required|string']);


        $policy = PrivacyPolicy::firstOrCreate([], ['content' => '']);
        $policy->update([
            'content' => $request->input('content')
        ]);


        return back()->with('success', 'Privacy policy updated successfully.');
    }
}

