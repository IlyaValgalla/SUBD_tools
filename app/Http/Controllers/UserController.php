<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
  /*  public function show(string $id)
    {
        $user = User::all()->where('id', $id)->first();

        return view('user',[
           'user' => $user,
            'equipment' => $user->equipments->all() ]);
    }*/
/////////////////////////////////////////////////////////////////
   /* public function show(string $id)
    {
        // Получаем пользователя по ID
        $user = User::all()->where('id', $id)->first();

        // Если пользователь не найден, возвращаем 404
        if (!$user) {
            abort(404, 'Пользователь не найден');
        }

        // Получаем оборудование пользователя
        $equipment = $user->equipments;

        // Вычисляем общую стоимость аренды для пользователя
        $total = DB::table('rentals')
            ->selectRaw('sum(planned_cost) as total')
            ->where('user_id', $id) // Используем user_id, так как rentals связаны с пользователем
            ->first();

        // Возвращаем данные в представление
        return view('user', [
            'user' => $user,
            'equipment' => $user->equipments->all(),
            'total' => $total->total ?? 0 // Если сумма не найдена, возвращаем 0
        ]);
    }*/

    public function show(string $id)
    {
        // Получаем пользователя по ID
        $user = User::find($id);

        // Если пользователь не найден, возвращаем 404
        if (!$user) {
            abort(404, 'Пользователь не найден');
        }

        // Получаем оборудование пользователя
        $equipments = $user->equipments;

        // Вычисляем суммарные стоимости
        $totalPlannedCost = $equipments->sum('pivot.planned_cost');
        $totalActualAmount = $equipments->sum('pivot.actual_amount');

        // Возвращаем данные в представление
        return view('user', [
            'user' => $user,
            'totalPlannedCost' => $totalPlannedCost,
            'totalActualAmount' => $totalActualAmount
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
