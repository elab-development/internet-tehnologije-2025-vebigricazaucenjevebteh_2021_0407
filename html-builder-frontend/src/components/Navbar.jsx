import { Link, useNavigate } from "react-router-dom";
import Button from "./Button";

export default function Navbar() {
  const nav = useNavigate();
  const token = localStorage.getItem("token");

  function logout() {
    localStorage.removeItem("token");
    nav("/login");
  }

  return (
    <div className="nav">
      <div className="nav-inner container">
        <div className="brand">HTML Builder</div>

        <div className="nav-links">
          <Link to="/">Home</Link>
          <Link to="/leaderboard">Leaderboard</Link>
          {!token ? <Link to="/login">Login</Link> : null}
        </div>

        {token ? (
          <Button variant="ghost" onClick={logout}>
            Logout
          </Button>
        ) : null}
      </div>
    </div>
  );
}
