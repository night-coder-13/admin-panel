<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
            $features = Feature::all();
            return view('features.index', compact('features'));
    }
    public function trash()
    {
        $features = Feature::onlyTrashed()->get();
        return view('features.trash', compact('features'));
    }
    public function restore($feature)
    {
        $feature = Feature::withTrashed()->find($feature);
        $feature->restore();
        return redirect()->route('feature.index')->with(['warning' => 'اسلایدر با عنوان "' . $feature->title . '" بازتولید شد']);
    }
    public function create()
    {
        return view('features.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:4|max:30',
            'icon' => 'required|string',
            'body' => 'required|string|min:10',
        ]);

        Feature::create([
            'title' => $request->title,
            'icon' => $request->icon,
            'body' => $request->body,
        ]);

        return redirect()->route('feature.index')->with(['success' => 'اسلایدر با عنوان "' . $request->title . '" ایجاد شد']);
    }
    public function edit(Feature $feature)
    {
        return view('features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'title' => 'required|string|min:4|max:30',
            'icon' => 'required|string',
            'body' => 'required|string|min:10',
        ]);

        $feature->update([
            'title' => $request->title,
            'icon' => $request->icon,
            'body' => $request->body,
        ]);

        return redirect()->route('feature.index')->with(['success' => 'اسلایدر با عنوان "' . $request->title . '" ویرایش شد']);
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('feature.index')->with(['info' => 'اسلایدر با عنوان "' . $feature->title . '" حذف شد']);
    }
}
