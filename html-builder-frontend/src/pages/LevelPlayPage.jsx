import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";

import Card from "../components/Card";
import Button from "../components/Button";
import DragDropLevel from "../components/DragDropLevel";

const API_BASE = "http://localhost:8000/api";


export default function LevelPlayPage() {
console.log("LevelPlayPage renderovan");
  const { id } = useParams();
  const nav = useNavigate();

  const [level, setLevel] = useState(null);
  const [loading, setLoading] = useState(true);
  const [pexelsImage, setPexelsImage] = useState(null);

  const isGuest = !localStorage.getItem("auth_token");

  useEffect(() => {
    async function load() {
      try {
        const r = await fetch(`${API_BASE}/nivos/${id}`);
        if (!r.ok) throw new Error("Nivo nije pronađen");

        const data = await r.json();

        if (
          isGuest &&
          data.tezina === 3
        ) {
          nav("/login", { replace: true });
          return;
        }

        setLevel(data);
      } catch (e) {
        console.error(e);
        setLevel(null);
      } finally {
        setLoading(false);
      }
    }

    load();
  }, [id, isGuest, nav]);


  useEffect(() => {
  console.log("Level ID je:", id);

  fetch(`${API_BASE}/external/pexels?nivo=1`)
    .then(res => res.json())
    .then(data => {
      console.log("Pexels odgovor:", data);

      if (data.photos && data.photos.length > 0) {
        const randomIndex = Math.floor(Math.random() * data.photos.length);
        setPexelsImage(data.photos[randomIndex].src.medium);
      }
    })
    .catch(err => console.error("Greška:", err));

}, [id]);



  if (loading) {
    return <p style={{ padding: 20 }}>Učitavanje nivoa...</p>;
  }

  if (!level) {
    return (
      <Card title="Greška">
        <p>Nivo nije pronađen.</p>
        <Button onClick={() => nav("/")}>Nazad</Button>
      </Card>
    );
  }

  return (
    <div className="container" style={{ marginTop: 18, display: "grid", gap: 14 }}>
      <Card title={level.naziv} subtitle={`Težina: ${level.tezina}`}>
        <p>{level.opis}</p>

        {isGuest && (
          <p style={{ fontSize: 13, opacity: 0.7 }}>
            Gost režim – napredak se ne čuva
          </p>
        )}
      </Card>


      {id === "1" && pexelsImage && (
        <img
          src={pexelsImage}
          alt="Level visual"
          style={{
            width: "100%",
            maxHeight: "300px",
            objectFit: "cover",
            borderRadius: "12px"
          }}
        />
      )}

      <DragDropLevel level={level} />
    </div>
  );
}
