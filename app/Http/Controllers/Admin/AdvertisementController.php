<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(20);
        return view('admin.advertisements.index', compact('advertisements'));
    }


    public function create()
    {
        // Pass positions array to view for dropdown
        $positions = Advertisement::positions();
        return view('admin.advertisements.create', compact('positions'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'image'              => 'required|image|max:2048',
            'link'               => 'required|url',
            'position'           => 'required|string',
            'advertiser_name'    => 'nullable|string|max:255',
            'advertiser_contact' => 'nullable|string|max:255',
            'is_active'          => 'nullable|boolean',
            'starts_at'          => 'nullable|date',
            'ends_at'            => 'nullable|date|after_or_equal:starts_at',
        ]);


        $validated['is_active'] = $request->boolean('is_active', true);
        // Store image to storage/app/public/ads/
        $validated['image']     = $request->file('image')->store('ads', 'public');


        Advertisement::create($validated);


        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Advertisement created successfully.');
    }


    public function edit(Advertisement $advertisement)
    {
        $positions = Advertisement::positions();
        return view('admin.advertisements.edit', compact('advertisement', 'positions'));
    }


    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'image'              => 'nullable|image|max:2048',
            'link'               => 'required|url',
            'position'           => 'required|string',
            'advertiser_name'    => 'nullable|string|max:255',
            'advertiser_contact' => 'nullable|string|max:255',
            'is_active'          => 'nullable|boolean',
            'starts_at'          => 'nullable|date',
            'ends_at'            => 'nullable|date|after_or_equal:starts_at',
        ]);


        $validated['is_active'] = $request->boolean('is_active', true);


        // Replace image only if a new one was uploaded
        if ($request->hasFile('image')) {
            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }
            $validated['image'] = $request->file('image')->store('ads', 'public');
        }


        $advertisement->update($validated);


        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Advertisement updated successfully.');
    }


    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image) {
            Storage::disk('public')->delete($advertisement->image);
        }
        $advertisement->delete();


        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Advertisement deleted successfully.');
    }
}

