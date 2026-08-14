<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }

    /**
     * Helper privat untuk memastikan format Token adalah Bearer murni
     */
    private function getToken()
    {
        $token = session('auth_token');

        if (!$token) {
            $token = request()->cookie('remember_auth_token');
        }

        if ($token && Str::startsWith($token, 'Bearer ')) {
            $token = Str::replaceFirst('Bearer ', '', $token);
        }

        return $token;
    }

    /**
     * Tampilkan Halaman Daftar Kategori
     */
    public function index(Request $request)
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return view('pages.admin.category', ['categories' => []])
                    ->with('error', 'Sesi login telah habis atau token tidak ditemukan. Silakan login kembali.');
            }

            // Client HTTP Laravel withToken otomatis menambahkan header: "Authorization: Bearer <token>"
            $response = Http::withToken($token)->get("{$this->apiUrl}/categories");

            $categories = [];
            if ($response->successful()) {
                $categories = $response->json('data') ?? [];
            } else {
                session()->flash('error', $response->json('message') ?? 'Gagal mengambil data kategori.');
            }

            return view('pages.admin.category', compact('categories'));
        } catch (\Exception $e) {
            return view('pages.admin.category', ['categories' => []])
                ->with('error', 'Gagal terhubung ke server API: ' . $e->getMessage());
        }
    }

    /**
     * Tambah Kategori Baru (CreateCategoryRequest DTO)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
        ]);

        try {
            $token = $this->getToken();

            if (!$token) {
                return redirect()->route('login')->with('error', 'Silakan login kembali.');
            }

            // Kirim request ke endpoint Go API /admin/categories
            $response = Http::withToken($token)
                ->acceptJson()
                ->post("{$this->apiUrl}/admin/categories", [
                    'name' => $request->name,
                ]);

            if ($response->successful()) {
                return redirect()->route('admin.kelola.category')
                    ->with('success', "Kategori '{$request->name}' berhasil ditambahkan.");
            }

            // Ambil pesan error spesifik dari response Go API
            $errorMessage = $response->json('message') 
                ?? $response->json('error') 
                ?? ('Gagal menambahkan kategori (HTTP Code: ' . $response->status() . ')');

            return redirect()->back()->with('error', $errorMessage)->withInput();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Perbarui Kategori (UpdateCategoryRequest DTO)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'is_active' => 'required',
        ]);

        try {
            $token = $this->getToken();

            if (!$token) {
                return redirect()->route('login')->with('error', 'Silakan login kembali.');
            }

            $isActive = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);

            $response = Http::withToken($token)
                ->acceptJson()
                ->put("{$this->apiUrl}/admin/categories/{$id}", [
                    'name' => $request->name,
                    'is_active' => $isActive,
                ]);

            if ($response->successful()) {
                return redirect()->route('admin.kelola.category')
                    ->with('success', "Kategori '{$request->name}' berhasil diperbarui.");
            }

            $errorMessage = $response->json('message') ?? 'Gagal memperbarui kategori.';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Kategori
     */
    public function destroy($id)
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return redirect()->route('login')->with('error', 'Silakan login kembali.');
            }

            $response = Http::withToken($token)
                ->acceptJson()
                ->delete("{$this->apiUrl}/admin/categories/{$id}");

            if ($response->successful()) {
                return redirect()->route('admin.kelola.category')
                    ->with('success', 'Kategori berhasil dihapus.');
            }

            $errorMessage = $response->json('message') ?? 'Gagal menghapus kategori.';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}