<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;

class PageController extends Controller
{
    public function privacy()
    {
        $policy = PrivacyPolicy::first();

        return view('public.pages.privacy', compact('policy'));
    }

    public function terms()
    {
        $terms = TermsCondition::first();

        return view('public.pages.terms', compact('terms'));
    }
}
