import { useEffect, useState } from "react";
import Card from "../components/Card";
import Button from "../components/Button";
import { useNavigate } from "react-router-dom";

const API_BASE = "http://localhost:8000/api";

export default function HomePage() {
  const [nivos, setNivos] = useState([]);
  const [loading, setLoading] = useState(true);
  const nav = useNavigate();

  useEffect(() => {
    async function load() {
      try {
        const r = await fetch(`${API_BASE}/nivos`);
        const data = await r.json();

        console.log(data);

        setNivos(data);
      } catch (e) {
        console.error(e);
        setNivos([]);
      } finally {
        setLoading(false);
      }
    }
    load();
  }, []);

  return (
    <div className="container" style={{ marginTop: 18 }}>
      <h2>Nivoi</h2>

      {loading ? (
        <p>Učitavanje...</p>
      ) : (
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit, minmax(260px, 1fr))", gap: 14 }}>
          {nivos.map((n) => (
            <Card key={n.id} title={n.naziv} subtitle={`Težina: ${n.tezina}`}>
              <p style={{ marginTop: 0, color: "var(--muted)" }}>{n.opis}</p>
              <Button onClick={() => nav(`/nivos/${n.id}`)}>Otvori nivo</Button>
            </Card>
          ))}
        </div>
      )}
    </div>
  );
}
