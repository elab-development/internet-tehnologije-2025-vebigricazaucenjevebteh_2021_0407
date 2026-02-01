import { Routes, Route, Navigate } from "react-router-dom";

import HomePage from "./pages/HomePage.jsx";
import LoginPage from "./pages/LoginPage.jsx";
import LeaderboardPage from "./pages/LeaderboardPage.jsx";


import "./styles.css";

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/login" element={<LoginPage />} />
      <Route path="/leaderboard" element={<LeaderboardPage />} />


      <Route path="*" element={<Navigate to="/" replace />} />
    </Routes>
  );
}
