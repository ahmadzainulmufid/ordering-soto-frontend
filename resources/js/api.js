// resources/js/api.js
const API_BASE_URL = "http://localhost:8080/api/v1"; // Sesuaikan port backend Go Anda

export async function apiRequest(endpoint, options = {}) {
    const token = localStorage.getItem("token");

    const headers = {
        "Content-Type": "application/json",
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
        ...options.headers,
    };

    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        ...options,
        headers,
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "Terjadi kesalahan pada server");
    }

    return data;
}
