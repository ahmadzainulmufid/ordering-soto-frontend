<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MenuController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }

    private function getToken()
    {
        $token = session('auth_token') ?? request()->cookie('remember_auth_token');
        if ($token) {
            $token = preg_replace('/^Bearer\s+/i', '', trim($token));
        }
        return $token;
    }

    public function index(Request $request)
    {
        try {
            $token = $this->getToken();

            $categoryResponse = Http::withToken($token)->get("{$this->apiUrl}/categories");
            $categories = $categoryResponse->successful() ? ($categoryResponse->json('data') ?? []) : [];

            $productResponse = Http::withToken($token)->get("{$this->apiUrl}/products");
            $products = $productResponse->successful() ? ($productResponse->json('data') ?? []) : [];

            return view('pages.admin.kelola', compact('categories', 'products'));

        } catch (\Exception $e) {
            return view('pages.admin.kelola', [
                'categories' => [],
                'products'   => []
            ])->with('error', 'Gagal terhubung ke API: ' . $e->getMessage());
        }
    }

    /**
     * Tambah Produk Baru dengan File Upload
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|numeric',
            'name'        => 'required|string|min:2|max:150',
            'price'       => 'required|numeric|gt:0',
            'stock'       => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maks 2MB
        ]);

        try {
            $token = $this->getToken();

            $imageUrl = '';
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $imageUrl = asset('storage/' . $path);
            }

            $response = Http::withToken($token)
                ->acceptJson()
                ->post("{$this->apiUrl}/admin/products", [
                    'category_id' => (int) $request->category_id,
                    'name'        => $request->name,
                    'description' => $request->description ?? '',
                    'price'       => (float) $request->price,
                    'image_url'   => $imageUrl,
                    'stock'       => (int) ($request->stock ?? 0),
                ]);

            if ($response->successful()) {
                return redirect()->route('admin.menu.index')
                    ->with('success', "Menu '{$request->name}' berhasil ditambahkan.");
            }

            $errorMessage = $response->json('message') ?? 'Gagal menambahkan menu produk.';
            return redirect()->back()->with('error', $errorMessage)->withInput();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update Produk dengan Upload Gambar Baru (Opsional)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id'  => 'required|numeric',
            'name'         => 'required|string|min:2|max:150',
            'price'        => 'required|numeric|gt:0',
            'stock'        => 'nullable|numeric|min:0',
            'is_available' => 'required',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $token = $this->getToken();
            $isAvailable = filter_var($request->is_available, FILTER_VALIDATE_BOOLEAN);

            $imageUrl = $request->old_image_url ?? '';
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $imageUrl = asset('storage/' . $path);
            }

            $response = Http::withToken($token)
                ->acceptJson()
                ->put("{$this->apiUrl}/admin/products/{$id}", [
                    'category_id'  => (int) $request->category_id,
                    'name'         => $request->name,
                    'description'  => $request->description ?? '',
                    'price'        => (float) $request->price,
                    'image_url'    => $imageUrl,
                    'stock'        => (int) ($request->stock ?? 0),
                    'is_available' => $isAvailable,
                ]);

            if ($response->successful()) {
                return redirect()->route('admin.menu.index')
                    ->with('success', "Menu '{$request->name}' berhasil diperbarui.");
            }

            $errorMessage = $response->json('message') ?? 'Gagal memperbarui produk.';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $token = $this->getToken();

            $response = Http::withToken($token)
                ->acceptJson()
                ->delete("{$this->apiUrl}/admin/products/{$id}");

            if ($response->successful()) {
                return redirect()->route('admin.menu.index')
                    ->with('success', 'Menu produk berhasil dihapus.');
            }

            $errorMessage = $response->json('message') ?? 'Gagal menghapus produk.';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}