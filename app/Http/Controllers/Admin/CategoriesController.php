<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;
use Yajra\DataTables\Html\Builder;

class CategoriesController extends Controller
{
    public function index(Builder $builder): Response
    {
        return Inertia::render('admin/categories/index', [
            'categories' => Category::all()
        ]);
    }
}
