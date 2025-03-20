<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 5;
        return view('equipments',[
            'equipments' => Equipment::paginate($perpage)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipment_create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:equipments|max:255',
            'price' => 'required|integer',
            'category_id' => 'integer',
            'quantity_in_stock' => 'required|integer|min:0',
        ]);
        $equipment= new Equipment($validated);
        $equipment->save();
        return redirect('/equipment');

    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {   /*return view('equipment',[
            'equipment' => Equipment::all()->where('id', $id)->first()
        ]);*/
        $equipment = Equipment::with('rentals')->find($id);

        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'Оборудование не найдено']);
        }

        return view('equipment', [
            'equipment' => $equipment
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('equipment_edit', [
           'equipment' => Equipment::all()->where('id',$id)->first(),
           'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Находим оборудование по ID
        $equipment = Equipment::findOrFail($id);

        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|max:255|unique:equipments,name,' . $equipment->id, // Уникальность, исключая текущую запись
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'quantity_in_stock' => 'required|integer|min:0',
        ]);

        // Обновляем оборудование
        $equipment->update($validated);

        // Перенаправляем пользователя с сообщением об успехе
        return redirect('/equipment')->with('success', 'Товар успешно обновлён.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Equipment::destroy($id);
        return redirect('/equipment');
    }
}
