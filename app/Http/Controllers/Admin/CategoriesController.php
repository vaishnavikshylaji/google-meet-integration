<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Inertia\Inertia;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $dataTable =  DataTables::of(Category::query())
                ->make(true);
        }

        $html = $dataTable->columns([
            Column::make('id'),
            Column::make('name')
        ]);

        return Inertia::render('admin/categories/index', [
            'categories' => $html
        ]);
    }
}
