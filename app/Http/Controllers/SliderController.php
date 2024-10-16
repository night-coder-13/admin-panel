<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $trash = Slider::onlyTrashed()->get();
        if(count($trash) != 0){
            $trash = true;
            $sliders = Slider::all();
            return view('sliders.index', compact(['sliders' , 'trash']));
        }else{
            $trash = false;
            $sliders = Slider::all();
            return view('sliders.index', compact(['sliders' , 'trash']));
        }
    }
    public function trash()
    {
        $sliders = Slider::onlyTrashed()->get();
        return view('sliders.trash', compact('sliders'));
    }
    public function restore($slider)
    {
        $slider = Slider::withTrashed()->find($slider);
        $slider->restore();
        return redirect()->route('slider.index')->with(['warning' => 'اسلایدر با عنوان "' . $slider->title . '" بازتولید شد']);
    }
    public function create()
    {
        return view('sliders.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:4|max:30',
            'url' => 'required|string',
            'title_url' => 'required|string',
            'body' => 'required|string|min:10',
        ]);

        Slider::create([
            'title' => $request->title,
            'url' => $request->url,
            'title_url' => $request->title_url,
            'body' => $request->body,
        ]);

        return redirect()->route('slider.index')->with(['success' => 'اسلایدر با عنوان "' . $request->title . '" ایجاد شد']);
    }
    public function edit(Slider $slider)
    {
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|min:4|max:30',
            'url' => 'required|string',
            'title_url' => 'required|string',
            'body' => 'required|string|min:10',
        ]);

        $slider->update([
            'title' => $request->title,
            'url' => $request->url,
            'title_url' => $request->title_url,
            'body' => $request->body,
        ]);

        return redirect()->route('slider.index')->with(['success' => 'اسلایدر با عنوان "' . $request->title . '" ویرایش شد']);
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('slider.index')->with(['info' => 'اسلایدر با عنوان "' . $slider->title . '" حذف شد']);
    }
}
