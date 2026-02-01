import { Link, useNavigate } from "react-router-dom";
import Button from "./Button";

export default function Navbar() {
  const nav = useNavigate();

  function logout() {
    // kasnije ćemo ovde čistiti token
    nav("/login");
  }

  return (
    <div className="nav">
      <div className="nav-inner container">
        <div className="brand">HTML Builder</div>

        <div className="nav-links">
          <Link to="/">Home</Link>
          <Link to="/leaderboard">Leaderboard</Link>
        </div>

        <Button variant="ghost" onClick={logout}>Logout</Button>
      </div>
    </div>
  );
}
