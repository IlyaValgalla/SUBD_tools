<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       // return view('categories', ['categories' => Category::all()]);
        $perpage = $request->perpage ?? 5;
        return view('categories',[
            'categories' => Category::paginate($perpage)->withQueryString()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('create-category')) {
            return redirect()->intended('/category')->withErrors(['error' =>
                'У вас нет разрешения на создание категории инструмента']);

        }
        return view('category_create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);
        $category= new Category($validated);
        $category->save();

        return redirect()->intended('/category')->withErrors(['success' =>
            'Вы успешно создали категорию инструмента!']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('category', ['category'=>$category]);


//        return view('category',[
//            'category' => Category::all()->where('id', $id)->first()
//        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        if (! Gate::allows('update-category')) {
            return redirect()->intended('/category')->withErrors(['error' =>
                'У вас нет разрешения на редактирование категории инструмента']);
        }

        //////////
        return view('category_edit', [
            'category' => Category::all()->where('id',$id)->first(),
        ]);
        ////////
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Находим оборудование по ID
        $category = Category::findOrFail($id);

        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id, // Уникальность, исключая текущую запись
        ]);

        // Обновляем оборудование
        $category->update($validated);

        // Перенаправляем пользователя с сообщением об успехе
        return redirect()->intended('/category')->withErrors(['success' =>
            'Категория товара успешно обновлёна!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! Gate::allows('destroy-category')) {
            return redirect()->intended('/category')->withErrors(['error' =>
                'У вас нет разрешения на удаление категории инструмента']);

        }

        Category::destroy($id);
        return redirect()->intended('/category')->withErrors(['success' =>
            'Категория успешно удалёна!']);
    }
}
