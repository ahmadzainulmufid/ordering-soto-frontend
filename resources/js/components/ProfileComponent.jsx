import React, { useEffect, useState } from "react";

export default function ProfileComponent() {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        const fetchProfile = async () => {
            const token = localStorage.getItem("token");

            // Validasi string token sebelum fetch
            if (!token || token === "undefined") {
                localStorage.removeItem("token");
                window.location.href = "/login";
                return;
            }

            try {
                const response = await fetch(
                    "http://localhost:8080/api/v1/auth/profile",
                    {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${token}`,
                        },
                    },
                );

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(
                        result.message ||
                            "Sesi berakhir, silakan login kembali.",
                    );
                }

                // Go membalas dengan utils.SuccessResponse (data tersimpan di result.data)
                setUser(result.data);
            } catch (err) {
                setError(err.message);
                localStorage.removeItem("token");
                setTimeout(() => {
                    window.location.href = "/login";
                }, 1500);
            } finally {
                setLoading(false);
            }
        };

        fetchProfile();
    }, []);

    if (loading)
        return <div className="p-4 text-center">Memuat data profil...</div>;

    if (error) {
        return (
            <div className="w-full max-w-md p-4 bg-red-100 border border-red-400 text-red-700 text-center rounded-lg">
                {error}
            </div>
        );
    }

    return (
        <div className="w-full max-w-md bg-white p-6 rounded-xl shadow border border-gray-100">
            <h2 className="text-xl font-bold text-gray-800 mb-4">
                Profil Pengguna
            </h2>
            <div className="space-y-3">
                <div className="flex justify-between border-b pb-2">
                    <span className="text-gray-500">ID User</span>
                    <span className="font-semibold text-gray-800">
                        {user?.id}
                    </span>
                </div>
                <div className="flex justify-between border-b pb-2">
                    <span className="text-gray-500">Nama</span>
                    <span className="font-semibold text-gray-800">
                        {user?.full_name || user?.name || "-"}
                    </span>
                </div>
                <div className="flex justify-between border-b pb-2">
                    <span className="text-gray-500">Email</span>
                    <span className="font-semibold text-gray-800">
                        {user?.email}
                    </span>
                </div>
                <div className="flex justify-between border-b pb-2">
                    <span className="text-gray-500">Role</span>
                    <span className="font-semibold capitalize text-indigo-600">
                        {user?.role}
                    </span>
                </div>
            </div>
            <button
                onClick={() => {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                }}
                className="mt-6 w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-medium transition"
            >
                Logout
            </button>
        </div>
    );
}
