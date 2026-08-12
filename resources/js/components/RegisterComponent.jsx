import React, { useState } from "react";

export default function RegisterComponent() {
    const [fullName, setFullName] = useState(""); // Ubah dari 'name' ke 'fullName'
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState(""); // Opsional
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [role, setRole] = useState("cashier"); // Set default role yang valid di Go
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError("");
        setSuccess("");

        if (password !== confirmPassword) {
            setError("Konfirmasi kata sandi tidak cocok!");
            return;
        }

        if (password.length < 8) {
            setError("Kata sandi minimal 8 karakter!");
            return;
        }

        setLoading(true);

        try {
            const response = await fetch(
                "http://localhost:8080/api/v1/auth/register",
                {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    // 🟢 SESUAIKAN DENGAN GO DTO STRUCT
                    body: JSON.stringify({
                        full_name: fullName,
                        email: email,
                        phone: phone,
                        password: password,
                        role: role,
                    }),
                },
            );

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || "Registrasi gagal");
            }

            setSuccess("Pendaftaran berhasil! Mengalihkan ke halaman login...");
            setTimeout(() => {
                window.location.href = "/login";
            }, 1500);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="w-full max-w-md bg-white p-8 rounded-xl shadow border border-gray-100">
            <h2 className="text-2xl font-bold mb-2 text-center text-gray-800">
                Daftar Akun (React)
            </h2>
            <p className="text-sm text-gray-500 mb-6 text-center">
                Buat akun baru untuk mulai menggunakan sistem
            </p>

            {error && (
                <div className="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 text-sm rounded">
                    {error}
                </div>
            )}
            {success && (
                <div className="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 text-sm rounded">
                    {success}
                </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        value={fullName}
                        onChange={(e) => setFullName(e.target.value)}
                        required
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Nomor Telepon (Opsional)
                    </label>
                    <input
                        type="text"
                        value={phone}
                        onChange={(e) => setPhone(e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Role Akses
                    </label>
                    <select
                        value={role}
                        onChange={(e) => setRole(e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                    >
                        <option value="admin">Admin</option>
                        <option value="cashier">Cashier</option>
                        <option value="kitchen">Kitchen</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Password (Min. 8 Karakter)
                    </label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Password
                    </label>
                    <input
                        type="password"
                        value={confirmPassword}
                        onChange={(e) => setConfirmPassword(e.target.value)}
                        required
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                    />
                </div>
                <button
                    type="submit"
                    disabled={loading}
                    className="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium transition"
                >
                    {loading ? "Memproses..." : "Daftar Sekarang"}
                </button>
            </form>

            <p className="mt-4 text-center text-sm text-gray-600">
                Sudah punya akun?{" "}
                <a href="/login" className="text-indigo-600 hover:underline">
                    Masuk
                </a>
            </p>
        </div>
    );
}
