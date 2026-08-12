import React, { useEffect, useState } from "react";

export default function DashboardComponent() {
    const [user, setUser] = useState(null);

    useEffect(() => {
        const token = localStorage.getItem("token");
        if (!token) {
            window.location.href = "/login";
            return;
        }

        // Ambil info profil singkat untuk salam selamat datang
        fetch("http://localhost:8080/api/v1/auth/profile", {
            headers: { Authorization: `Bearer ${token}` },
        })
            .then((res) => res.json())
            .then((data) => {
                if (data?.data) setUser(data.data);
            })
            .catch(() => {
                localStorage.removeItem("token");
                window.location.href = "/login";
            });
    }, []);

    return (
        <div className="min-h-screen bg-gray-50 p-6">
            <header className="flex justify-between items-center bg-white p-4 rounded-xl shadow mb-6">
                <h1 className="text-xl font-bold text-indigo-600">
                    SotoAyam Dashboard
                </h1>
                <div className="flex items-center space-x-4">
                    <span className="text-sm text-gray-600">
                        Halo, <strong>{user?.email || "User"}</strong>
                    </span>
                    <a
                        href="/profile"
                        className="text-sm text-indigo-600 hover:underline"
                    >
                        Profil
                    </a>
                </div>
            </header>

            <main className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="bg-white p-6 rounded-xl shadow">
                    <h3 className="text-gray-500 text-sm font-medium">
                        Status Sistem
                    </h3>
                    <p className="text-2xl font-bold text-green-600 mt-2">
                        Aktif (API Go)
                    </p>
                </div>
                <div className="bg-white p-6 rounded-xl shadow">
                    <h3 className="text-gray-500 text-sm font-medium">
                        Role Anda
                    </h3>
                    <p className="text-2xl font-bold text-indigo-600 mt-2 capitalize">
                        {user?.role || "-"}
                    </p>
                </div>
                <div className="bg-white p-6 rounded-xl shadow">
                    <h3 className="text-gray-500 text-sm font-medium">
                        Akses Cepat
                    </h3>
                    <button
                        onClick={() => (window.location.href = "/profile")}
                        className="mt-2 text-sm bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-100 font-medium"
                    >
                        Lihat Detail Profil
                    </button>
                </div>
            </main>
        </div>
    );
}
