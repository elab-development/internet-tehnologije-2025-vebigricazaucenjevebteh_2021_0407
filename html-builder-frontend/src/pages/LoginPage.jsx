import { useState } from "react";
import { useNavigate, useSearchParams } from "react-router-dom";
import Card from "../components/Card";
import Input from "../components/Input";
import Button from "../components/Button";

export default function LoginPage() {
  const [searchParams] = useSearchParams();
  const redirect = searchParams.get("redirect") || "/leaderboard";
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  async function onSubmit(e) {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const res = await fetch("http://127.0.0.1:8000/api/auth/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password }),
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.message || "Greška pri loginu");
        return;
      }

      localStorage.setItem("auth_token", data.token);
      localStorage.setItem("auth_user", JSON.stringify(data.user));

      navigate(redirect);
    } catch (err) {
      console.error(err);
      setError("Backend nije dostupan");
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="container" style={{ maxWidth: 420, marginTop: 60 }}>
      <Card title="Login">
        <form onSubmit={onSubmit}>
          <Input label="Email" value={email} onChange={e => setEmail(e.target.value)} />
          <Input label="Lozinka" type="password" value={password} onChange={e => setPassword(e.target.value)} />

          {error && <p style={{ color: "red" }}>{error}</p>}

          <Button type="submit" disabled={loading}>
            {loading ? "Učitavanje..." : "Uloguj se"}
          </Button>
        </form>
      </Card>
    </div>
  );
}

