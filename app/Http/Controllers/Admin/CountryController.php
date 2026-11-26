<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('id')->paginate(10);

        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:countries,name'],
        ]);

        Country::create($data);

        return redirect()->route('admin.countries.index')->with('success', 'Страна добавлена');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.form', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('countries', 'name')->ignore($country->id)],
        ]);

        $country->update($data);

        return redirect()->route('admin.countries.index')->with('success', 'Страна изменена');
    }

    public function destroy(Country $country)
    {
        if ($country->films()->exists()) {
            return back()->with('error', 'Нельзя удалить страну: к ней привязаны фильмы');
        }

        $country->delete();

        return redirect()->route('admin.countries.index')->with('success', 'Страна удалена');
    }
}