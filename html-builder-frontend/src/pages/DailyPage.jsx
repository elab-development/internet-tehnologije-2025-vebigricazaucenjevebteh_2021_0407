import { useEffect, useState } from "react";

const API_BASE = "http://localhost:8000/api";

export default function DailyPage() {
  const [daily, setDaily] = useState(null);
  const [loading, setLoading] = useState(true);
  const [selected, setSelected] = useState(null);
  const [result, setResult] = useState(null);


const handleAnswer = (answer) => {
  if (selected) return;

  setSelected(answer);

  if (answer === daily.correct_answer) {
    setResult("Tačno!");
  } else {
    setResult("Netačno!");
  }
};

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
    onClick={() => handleAnswer(a)}
    style={{
      display: "block",
      marginBottom: 10,
      padding: 10,
      width: "300px",
      backgroundColor:
        selected === a
          ? a === daily.correct_answer
            ? "#4CAF50"
            : "#f44336"
          : "#eee"
    }}
  >
    {a}
  </button>

        ))}
        {result && (
  <h3 style={{ marginTop: 20 }}>
    {result}
  </h3>
)}
      </div>
    </div>
  );
}
