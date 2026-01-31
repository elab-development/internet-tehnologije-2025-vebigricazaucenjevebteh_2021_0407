import { useEffect, useState } from "react";
import Navbar from "../components/Navbar";
import Card from "../components/Card";
import Button from "../components/Button";

export default function HomePage() {
  const [nivoi, setNivoi] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {

    setTimeout(() => {
      setNivoi([
        { id: 1, naziv: "Level 1: Basic HTML", opis: "Osnove strukture", tezina: 1 },
        { id: 2, naziv: "Level 2: Lists & Links", opis: "Liste i linkovi", tezina: 2 },
        { id: 3, naziv: "Level 3: Semantic", opis: "Semantički tagovi", tezina: 3 },
      ]);
      setLoading(false);
    }, 300);
  }, []);

  return (
    <>
      <Navbar />
      <div className="container" style={{ marginTop: 18 }}>
        <h2>Nivoi</h2>

        {loading ? (
          <p>Učitavanje...</p>
        ) : (
          <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit, minmax(260px, 1fr))", gap: 14 }}>
            {nivoi.map((n) => (
              <Card key={n.id} title={n.naziv} subtitle={`Težina: ${n.tezina}`}>
                <p style={{ marginTop: 0, color: "var(--muted)" }}>{n.opis}</p>
                <Button onClick={() => alert(`Otvaram nivo ${n.id}`)}>Otvori</Button>
              </Card>
            ))}
          </div>
        )}
      </div>
    </>
  );
}
