import { useEffect, useState } from "react";

const API_BASE = "http://localhost:8000/api";

export default function DailyPage() {
  const [daily, setDaily] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(`${API_BASE}/daily`)
      .then(res => res.json())
      .then(data => {
        setDaily(data);
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Učitavanje...</p>;

  if (!daily) return <p>Nema pitanja danas.</p>;

  return (


    <div style={{ padding: 40 }}>
        <h1>OVO JE MOJ DAILY</h1>
      <h2>Daily izazov ({daily.date})</h2>

      <h3>{daily.question}</h3>

      <div style={{ marginTop: 20 }}>
        {daily.answers.map((a, index) => (
          <button
            key={index}
            style={{
              display: "block",
              marginBottom: 10,
              padding: 10,
              width: "300px"
            }}
          >
            {a}
          </button>
        ))}
      </div>
    </div>
  );
}
