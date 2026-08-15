<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DiningTableController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }

    /**
     * Helper privat untuk mengambil Token dari Session/Cookie
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
     * Tampilkan Halaman Daftar Meja Makan (Dining Table)
     */
    public function index(Request $request)
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return view('pages.admin.table', ['tables' => []])
                    ->with('error', 'Sesi login telah habis atau token tidak ditemukan. Silakan login kembali.');
            }

            // Call Go API endpoint: GET /admin/tables
            $response = Http::withToken($token)->get("{$this->apiUrl}/admin/tables");

            $tables = [];
            if ($response->successful()) {
                $tables = $response->json('data') ?? [];
            } else {
                session()->flash('error', $response->json('message') ?? 'Gagal mengambil data Meja Makan.');
            }

            return view('pages.admin.table', compact('tables'));
        } catch (\Exception $e) {
            return view('pages.admin.table', ['tables' => []])
                ->with('error', 'Gagal terhubung ke server API: ' . $e->getMessage());
        }
    }

    /**
     * Tambah Meja Makan Baru (Sesuai CreateDiningTableRequest DTO: table_number)
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:50',
        ], [
            'table_number.required' => 'Nomor meja wajib diisi.',
        ]);

        try {
            $token = $this->getToken();

            if (!$token) {
                return redirect()->route('login')->with('error', 'Silakan login kembali.');
            }

            // Kirim payload sesuai DTO Go: {"table_number": "Meja 01"}
            $response = Http::withToken($token)
                ->acceptJson()
                ->post("{$this->apiUrl}/admin/tables", [
                    'table_number' => $request->table_number,
                ]);

            if ($response->successful()) {
                return redirect()->route('admin.kelola.table')
                    ->with('success', "Meja '{$request->table_number}' berhasil ditambahkan.");
            }

            $errorMessage = $response->json('message') 
                ?? $response->json('error') 
                ?? ('Gagal menambahkan meja (HTTP Code: ' . $response->status() . ')');

            return redirect()->back()->with('error', $errorMessage)->withInput();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Perbarui Data Meja (Sesuai UpdateDiningTableRequest DTO: table_number & is_active)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'table_number' => 'required|string|max:50',
            'is_active'    => 'required',
        ]);

        try {
            $token = $this->getToken();

            if (!$token) {
                return redirect()->route('login')->with('error', 'Silakan login kembali.');
            }

            $isActive = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);

            // Kirim payload sesuai DTO Go: {"table_number": "Meja 01", "is_active": true}
            $response = Http::withToken($token)
                ->acceptJson()
                ->put("{$this->apiUrl}/admin/tables/{$id}", [
                    'table_number' => $request->table_number,
                    'is_active'    => $isActive,
                ]);

            if ($response->successful()) {
                return redirect()->route('admin.kelola.table')
                    ->with('success', "Data Meja '{$request->table_number}' berhasil diperbarui.");
            }

            $errorMessage = $response->json('message') ?? 'Gagal memperbarui data meja.';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Meja Makan
     */
    public function destroy($id)
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return redirect()->route('login')->with('error', 'Silakan login kembali.');
            }

            // Endpoint plural: /admin/tables/{id}
            $response = Http::withToken($token)
                ->acceptJson()
                ->delete("{$this->apiUrl}/admin/tables/{$id}");

            if ($response->successful()) {
                return redirect()->route('admin.kelola.table')
                    ->with('success', 'Meja makan berhasil dihapus.');
            }

            $errorMessage = $response->json('message') ?? 'Gagal menghapus meja makan.';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}