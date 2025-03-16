<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'Пользователь не найден');
        }

        // Загружаем все аренды пользователя с инструментами
        $rentals = Rental::where('user_id', $id)->with('equipment')->get();

        $totalPlannedCost = $rentals->sum(function ($rental) {
            $startDate = Carbon::parse($rental->start_date);
            $endDate = Carbon::parse($rental->end_date);
            $days = $startDate->diffInDays($endDate);

            if ($days == 0) {
                $days = 1; // Если аренда на 1 день, корректируем
            }

            $quantity = $rental->quantity ?? 1; // Укороченная проверка

            return $rental->equipment ? $days * $rental->equipment->price * $quantity : 0;
        });

        return view('user', [
            'user' => $user,
            'rentals' => $rentals,
            'totalPlannedCost' => $totalPlannedCost,
            'totalActualAmount' => $rentals->sum('actual_amount')
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
