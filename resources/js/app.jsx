import React from "react";
import { createRoot } from "react-dom/client";

import LoginComponent from "./components/LoginComponent";
import RegisterComponent from "./components/RegisterComponent";
import ProfileComponent from "./components/ProfileComponent";
import DashboardComponent from "./components/DashboardComponent";

// Helper untuk mount komponen jika container elemennya ada
const mountComponent = (id, Component) => {
    const el = document.getElementById(id);
    if (el) {
        createRoot(el).render(
            <React.StrictMode>
                <Component />
            </React.StrictMode>,
        );
    }
};

mountComponent("login-react-root", LoginComponent);
mountComponent("register-react-root", RegisterComponent);
mountComponent("profile-react-root", ProfileComponent);
mountComponent("dashboard-react-root", DashboardComponent);
