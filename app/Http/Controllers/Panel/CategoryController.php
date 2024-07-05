<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(): View
    {
        return view('categories.index');
    }
    protected function all(): ?Object
    {
        return Category::all();
    }
}
