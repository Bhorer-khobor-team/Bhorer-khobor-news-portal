<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\TermsCondition;
use Illuminate\Http\Request;


class TermsController extends Controller
{
    public function edit()
    {
        $terms = TermsCondition::firstOrCreate([], ['content' => '']);
        return view('admin.pages.terms', compact('terms'));
    }


    public function update(Request $request)
    {
        $request->validate(['content' => 'required|string']);


        $terms = TermsCondition::firstOrCreate([], ['content' => '']);
        $terms->update(['content' => $request->input('content')]);


        return back()->with('success', 'Terms & Conditions updated successfully.');
    }
}

