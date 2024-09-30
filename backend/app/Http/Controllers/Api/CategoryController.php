<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Получаем все категории верхнего уровня 
        $categories = Category::whereNull('parent_id')
            ->with('childrenRecursive') // Подгружаем дочерние категории)
            ->orderBy('order') // Сортируем по порядку
            ->get();

        return response()->json($categories);
    }

    public function getCategory(Request $request)
    {
        // Если ID не передан, выбираем категории верхнего уровня 
        if (!$request->has('id')) {
            $categories = Category::whereNull('parent_id')->get();

            // Сортировка категорий по алфавиту, если указана
            if ($request->has('sort')) {
                if ($request->sort === 'alpha_asc') {
                    $categories = $categories->sortBy('name')->values();
                } elseif ($request->sort === 'alpha_desc') {
                    $categories = $categories->sortByDesc('name')->values();
                }
            }

            return response()->json([
                'current_category' => null,
                'parent_category' => null,
                'parent_category_id' => null,
                'categories' => $categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                    ];
                }),
                'products' => [],
                'breadcrumbs' => [], 
            ]);
        }

        // Получаем категорию по ID
        $category = Category::with('parent', 'children', 'products')->findOrFail($request->get('id'));

        // Формируем путь для категории
        $breadcrumbs = [];
        $current = $category;
        while ($current) {
            array_unshift($breadcrumbs, [
                'id' => $current->id,
                'name' => $current->name
            ]);
            $current = $current->parent;
        }

        // Сортировка категорий
        if ($request->has('sort')) {
            // Сортировка подкатегорий по алфавиту
            if ($request->sort === 'alpha_asc') {
                $category->children = $category->children->sortBy('name')->values();
            } elseif ($request->sort === 'alpha_desc') {
                $category->children = $category->children->sortByDesc('name')->values();
            }
        }

        // Если категория имеет подкатегории
        if ($category->children->isNotEmpty()) {
            return response()->json([
                'current_category' => $category->name,
                'parent_category' => $category->parent ? $category->parent->name : null,
                'parent_category_id' => $category->parent ? $category->parent->id : null,
                'categories' => $category->children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                    ];
                }),
                'products' => [],
                'breadcrumbs' => $breadcrumbs, 
            ]);
        }

        // Если категория на последнем уровне, возвращаем товары
        $products = $category->products;

        // Сортировка товаров
        if ($request->has('sort')) {
            if ($request->sort === 'alpha_asc') {
                $products = $products->sortBy('name')->values();
            } elseif ($request->sort === 'alpha_desc') {
                $products = $products->sortByDesc('name')->values();
            } elseif ($request->sort === 'price_asc') {
                $products = $products->sortBy('price')->values();
            } elseif ($request->sort === 'price_desc') {
                $products = $products->sortByDesc('price')->values();
            }
        }

        return response()->json([
            'current_category' => $category->name,
            'parent_category' => $category->parent ? $category->parent->name : null,
            'parent_category_id' => $category->parent ? $category->parent->id : null,
            'categories' => [],
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                ];
            }),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
