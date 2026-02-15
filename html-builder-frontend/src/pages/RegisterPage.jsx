import { useState } from "react";
import { useNavigate } from "react-router-dom";

const API = "http://127.0.0.1:8000/api";

export default function RegisterPage() {
  const nav = useNavigate();

  const [ime, setIme] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [password_confirmation, setPasswordConfirmation] = useState("");
  const [error, setError] = useState("");

  async function handleRegister(e) {
    e.preventDefault();
    setError("");

    if (password.length < 6) {
      setError("Lozinka mora da sadrži najmanje 6 karaktera");
      return;
    }

    if (password !== password_confirmation) {
      setError("Lozinke se ne poklapaju");
      return;
    }

    try {
     const r = await fetch(`${API}/auth/register`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          ime,
          email,
          password,
          password_confirmation,
        }),
      });

      const data = await r.json();

      if (!r.ok) {
        setError(data.message || "Greška pri registraciji");
        return;
      }


      localStorage.setItem("auth_token", data.token);
      localStorage.setItem("auth_user", JSON.stringify(data.korisnik));

      nav("/");
    } catch (err) {
      setError("Greška na serveru");
    }
  }

  return (
    <div className="container" style={{ maxWidth: 400, marginTop: 40 }}>
      <h2>Registracija</h2>

      {error && <p style={{ color: "red" }}>{error}</p>}

      <form onSubmit={handleRegister}>
        <input
          placeholder="Ime"
          value={ime}
          onChange={(e) => setIme(e.target.value)}
          required
        />

        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />

        <input
          type="password"
          placeholder="Lozinka"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />

        <input
          type="password"
          placeholder="Potvrdi lozinku"
          value={password_confirmation}
          onChange={(e) => setPasswordConfirmation(e.target.value)}
          required
        />

        <button type="submit">Registruj se</button>
      </form>
    </div>
  );
}
