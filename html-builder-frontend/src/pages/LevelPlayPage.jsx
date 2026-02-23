import React from "react";
import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";

import Card from "../components/Card";
import Button from "../components/Button";
import DragDropLevel from "../components/DragDropLevel";

const API_BASE = "http://127.0.0.1:8000/api";

export default function LevelPlayPage() {
  const { id } = useParams();
  const nav = useNavigate();

  const [level, setLevel] = useState(null);
  const [loading, setLoading] = useState(true);
  const [imageUrl, setImageUrl] = useState(null);

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
    async function loadImage() {
      try {
        const r = await fetch(
          "https://api.pexels.com/v1/search?query=technology&per_page=1&page=" +
            Math.floor(Math.random() * 10 + 1),
          {
            headers: {
              Authorization: "DZlsJgXs7d1qWG59W1XxOVnn8NuYXh5Lzk4LArgTkmfUzv0gHOP1zDSE"
            }
          }
        );

        const data = await r.json();

        if (data.photos && data.photos.length > 0) {
          setImageUrl(data.photos[0].src.large);
        }
      } catch (e) {
        console.error("Greška pri učitavanju slike:", e);
        setImageUrl(null);
      }
    }

    loadImage();
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

       {imageUrl && (
        <img
          src={imageUrl}
          alt="Random"
          style={{
            width: "100%",
            borderRadius: 12
          }}
        />
      )}

      <DragDropLevel level={level} />
    </div>
  );
}
