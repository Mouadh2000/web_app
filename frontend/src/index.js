/*!

=========================================================
* Argon Dashboard React - v1.2.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-react
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard-react/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
import React from "react";
import PrivateRoutes from 'context/PrivateRoute';
import ReactDOM from "react-dom/client";
import { BrowserRouter, Route, Routes, Navigate } from "react-router-dom";
import {AuthProvider} from 'context/AuthContext';
import "assets/plugins/nucleo/css/nucleo.css";
import "@fortawesome/fontawesome-free/css/all.min.css";
import "assets/scss/argon-dashboard-react.scss";

import AdminLayout from "layouts/Admin.js";
import AuthLayout from "layouts/Auth.js";

const root = ReactDOM.createRoot(document.getElementById("root"));

root.render(
  <BrowserRouter>
  <AuthProvider>
        <Routes>
          <Route path="/auth/*" element={<AuthLayout />} />
          <Route element={<PrivateRoutes/>}>
            <Route path="/admin/*" element={<AdminLayout />} />
            <Route path="*" element={<Navigate to="/admin/index" replace />} />
          </Route>
        </Routes>
  </AuthProvider>
  </BrowserRouter>
);
