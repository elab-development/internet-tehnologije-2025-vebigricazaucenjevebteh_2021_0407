import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import Navbar from "../components/Navbar";
import Card from "../components/Card";

export default function LeaderboardPage() {
  const nav = useNavigate();
  const [rows, setRows] = useState([]);

  useEffect(() => {
    const token = localStorage.getItem("token");

    if (!token) {
      nav("/login");
      return;
    }

    // demo podaci
    setRows([
      { id: 1, ime: "Anja Milenović", poeni: 1400 },
      { id: 2, ime: "Jelena Maksimović", poeni: 1270 },
      { id: 3, ime: "Milan Jovanović", poeni: 1150 },
    ]);
  }, [nav]);

  return (
    <>
      <Navbar />
      <div className="container" style={{ marginTop: 18 }}>
        <h2>Leaderboard</h2>

        <Card>
          {rows.map((r, i) => (
            <div
              key={r.id}
              style={{
                display: "flex",
                justifyContent: "space-between",
                padding: "10px 0",
                borderBottom: i === rows.length - 1 ? "none" : "1px solid #eee",
              }}
            >
              <div>#{i + 1} {r.ime}</div>
              <div style={{ fontWeight: 600 }}>{r.poeni}</div>
            </div>
          ))}
        </Card>
      </div>
    </>
  );
}
