import { useEffect, useState } from "react";
import Card from "../components/Card";
import Button from "../components/Button";

const API_BASE = "http://localhost:8000/api";

export default function DailyChallengePage() {
  const [data, setData] = useState(null);
  const [answers, setAnswers] = useState([]);
  const [selected, setSelected] = useState(null);
  const [correct, setCorrect] = useState(null);

  useEffect(() => {
    fetch(`${API_BASE}/daily-trivia`)
      .then(res => res.json())
      .then(json => {
        setData(json);

        if (json.question) {
          const allAnswers = [
            ...json.question.incorrect_answers,
            json.question.correct_answer
          ].sort(() => Math.random() - 0.5);

          setAnswers(allAnswers);
        }
      });
  }, []);

  if (!data) return <p style={{ padding: 20 }}>Učitavanje...</p>;

  if (!data.question) return <p>Nema pitanja danas.</p>;

  function checkAnswer(answer) {
    setSelected(answer);
    setCorrect(answer === data.question.correct_answer);
  }

  return (
    <div className="container" style={{ marginTop: 20 }}>
      <Card title="🔥 Daily Trivia Challenge" subtitle={`Datum: ${data.datum}`}>
        <h3 dangerouslySetInnerHTML={{ __html: data.question.question }} />

        <div style={{ marginTop: 15 }}>
          {answers.map((a, i) => (
            <Button
              key={i}
              onClick={() => checkAnswer(a)}
              style={{
                margin: 5,
                background:
                  selected === a
                    ? correct
                      ? "green"
                      : "red"
                    : ""
              }}
            >
              <span dangerouslySetInnerHTML={{ __html: a }} />
            </Button>
          ))}
        </div>

        {selected && (
          <p style={{ marginTop: 15 }}>
            {correct ? "Tačan odgovor 🎉" : "Pogrešan odgovor ❌"}
          </p>
        )}
      </Card>
    </div>
  );
}
