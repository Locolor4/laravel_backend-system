<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        return Item::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required']
        ]);

        $item = new Item;
        $item->title = $request->input('title');
        $item->save();

        return $item;
    }

    public function show(Item $item)
    {
        return $item;
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'title' => ['required']
        ]);

        $item->title = $request->input('title');
        $item->save();

        return $item;
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return response()->noContent();
    }
}
