<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MenuUserController extends Controller 
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }
    
    public function index(Request $request)
    {
        try {
            $categoryResponse = Http::get("{$this->apiUrl}/categories");
            $categories = $categoryResponse->successful() ? ($categoryResponse->json('data') ?? []) : [];

            $productResponse = Http::get("{$this->apiUrl}/products");
            $products = $productResponse->successful() ? ($productResponse->json('data') ?? []) : [];

            $tableResponse = Http::get("{$this->apiUrl}/tables");
            $tables = $tableResponse->successful() ? ($tableResponse->json('data') ?? []) : [];

            return view('pages.menu', compact('categories', 'products', 'tables'));

        } catch (\Exception $e) {
            return view('pages.menu', [
                'categories' => [],
                'products'   => [],
                'tables'     => []
            ])->with('error', 'Gagal terhubung ke API: ' . $e->getMessage());
        }
    }
}