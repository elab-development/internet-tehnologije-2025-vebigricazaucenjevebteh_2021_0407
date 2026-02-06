import { useEffect, useState } from "react";
import Card from "../components/Card";

export default function LeaderboardPage() {
  const [rows, setRows] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function load() {
      try {
        const res = await fetch("http://127.0.0.1:8000/api/leaderboard", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
          },
        });

        const data = await res.json();
        setRows(data);
      } catch (e) {
        console.error("Greška pri učitavanju leaderboarda", e);
      } finally {
        setLoading(false);
      }
    }

    load();
  }, []);

  return (
    <div className="container" style={{ marginTop: 20 }}>
      <h2>Leaderboard</h2>

      <Card>
        {loading && <p>Učitavanje...</p>}

        {!loading && rows.length === 0 && (
          <p>Nema podataka.</p>
        )}

        {!loading &&
          rows.map((r, i) => (
            <div
              key={r.email || i}
              style={{
                display: "flex",
                justifyContent: "space-between",
                padding: "10px 0",
                borderBottom: "1px solid #eee",
              }}
            >
              <div>
                #{i + 1} {r.email}
              </div>

              <div style={{ fontWeight: 600 }}>
                {r.ukupno_poena} poena
              </div>
            </div>
          ))}
      </Card>
    </div>
  );
}

