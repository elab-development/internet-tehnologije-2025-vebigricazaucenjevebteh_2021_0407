import { Routes, Route, Navigate } from "react-router-dom";

import HomePage from "./pages/HomePage";
import LoginPage from "./pages/LoginPage";
import LevelPlayPage from "./pages/LevelPlayPage";
import ProtectedRoute from "./components/ProtectedRoute";
import LeaderboardPage from "./pages/LeaderboardPage";
import Navbar from "./components/Navbar";
import RegisterPage from "./pages/RegisterPage";
import Statistika from "./pages/Statistika";
import DailyPage from "./pages/DailyPage";


export default function App() {
  return (
    <>
      <Navbar />

      <Routes>

        <Route path="/" element={<HomePage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route path="/statistika" element={<Statistika />} />
        <Route path="/daily" element={<DailyPage />} />


        <Route
          path="/leaderboard"
          element={
            <ProtectedRoute>
              <LeaderboardPage />
            </ProtectedRoute>
          }
        />


        <Route path="/nivos/:id" element={<LevelPlayPage />} />


        <Route path="*" element={<Navigate to="/" />} />
      </Routes>
    </>
  );
}
