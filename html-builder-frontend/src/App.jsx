import { Routes, Route, Navigate } from "react-router-dom";

import HomePage from "./pages/HomePage";
import LoginPage from "./pages/LoginPage";
import LevelPlayPage from "./pages/LevelPlayPage";
import ProtectedRoute from "./components/ProtectedRoute";
import LeaderboardPage from "./pages/LeaderboardPage";
import Navbar from "./components/Navbar";
import RegisterPage from "./pages/RegisterPage";
import Statistika from "./pages/Statistika";


export default function App() {
  return (
    <>
      <Navbar />

       <h1 style={{color: "red"}}>TEST APP</h1>
      <Routes>

        <Route path="/" element={<HomePage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route path="/statistika" element={<Statistika />} />


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
