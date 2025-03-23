<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Support\Facades\Gate;
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
        if (! Gate::allows('create-equipment')) {
            return redirect()->intended('/equipment')->withErrors(['error' =>
                'У вас нет разрешения на создание инструмента']);

        }
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
        return redirect()->intended('/equipment')->withErrors(['success' =>
            'Вы успешно создали Инструмент!']);

    }

    /**
     * Display the specified resource.
     */

//    public function show(string $id)
//    {   /*return view('equipment',[
//            'equipment' => Equipment::all()->where('id', $id)->first()
//        ]);*/
//
//        $equipment = Equipment::findOrFail($id);
//
//        $equipment = Equipment::with('rentals')->find($id);
//
//        if (!$equipment) {
//            return redirect()->back()->withErrors(['error' => 'Оборудование не найдено']);
//        }
//
//        return view('equipment', ['equipment'=>$equipment]);
//
//
//
////        return view('equipment', [
////            'equipment' => $equipment
////        ]);
//    }


    public function show(string $id)
    {
        if (!Gate::allows('view-equipment-rentals')) {
            return redirect()->route('equipment.index')->withErrors(['error' => 'У вас нет прав для просмотра этой информации']);
        }

        $equipment = Equipment::with('rentals')->findOrFail($id);

        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'Оборудование не найдено']);
        }

        return view('equipment', ['equipment' => $equipment]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! Gate::allows('update-equipment')) {
            return redirect()->intended('/equipment')->withErrors(['error' =>
                'У вас нет разрешения нна редактирование товара']);

        }
        //////////
        return view('equipment_edit', [
           'equipment' => Equipment::all()->where('id',$id)->first(),
           'categories' => Category::all()
        ]);
        ///////
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
        return redirect()->intended('/equipment')->withErrors(['success' =>
            'Товар успешно обновлён!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! Gate::allows('destroy-equipment')) {
            return redirect()->intended('/equipment')->withErrors(['error' =>
                'У вас нет разрешения на удаления товара']);
        }

        Equipment::destroy($id);
        return redirect()->intended('/equipment')->withErrors(['success' =>
            'Товар успешно удалён!']);
    }
}
