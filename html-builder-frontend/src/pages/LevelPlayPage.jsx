import { useEffect, useMemo, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";

import Navbar from "../components/Navbar";
import Card from "../components/Card";
import Button from "../components/Button";
import DragDropLevel from "../components/DragDropLevel";

const API_BASE = "http://127.0.0.1:8000/api";

/* =========================
   POMOĆNE FUNKCIJE
========================= */

function collectTags(node, out = []) {
  if (!node) return out;
  if (node.nodeType === 1) out.push(node.tagName.toLowerCase());
  for (const child of node.children || []) collectTags(child, out);
  return out;
}

function validateHtmlAgainstExpected(html, expected) {
  const errors = [];

  if (!html || html.trim().length < 3) {
    return { ok: false, errors: ["Nisi uneo HTML."] };
  }

  if (!expected || !expected.tag) {
    return { ok: true, errors: [] };
  }

  const doc = new DOMParser().parseFromString(html, "text/html");
  const body = doc.body;
  const tags = collectTags(body, []);

  const need = [];
  (function walk(exp) {
    if (!exp) return;
    if (exp.tag) need.push(exp.tag.toLowerCase());
    if (Array.isArray(exp.children)) exp.children.forEach(walk);
  })(expected);

  for (const t of need) {
    if (!tags.includes(t)) {
      errors.push(`Nedostaje tag <${t}>`);
    }
  }

  let lastIndex = -1;
  for (const t of need) {
    const idx = tags.indexOf(t);
    if (idx !== -1 && idx < lastIndex) {
      errors.push(`Pogrešan redosled tagova.`);
      break;
    }
    if (idx !== -1) lastIndex = idx;
  }

  return { ok: errors.length === 0, errors };
}

/* =========================
   KLASIČNI EDITOR KOMPONENTA
========================= */

function ClassicEditor({ level }) {
  const [code, setCode] = useState(level.starter_html || "");
  const [showPreview, setShowPreview] = useState(true);
  const [result, setResult] = useState({ ok: null, errors: [] });

  const previewHtml = useMemo(() => {
    return `<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<style>
body{font-family:system-ui;padding:16px}
header,main,footer,section,article,aside,nav{
  border:1px dashed #cbd5e1;
  padding:10px;
  margin:8px 0;
  border-radius:8px;
}
</style>
</head>
<body>
${code}
</body>
</html>`;
  }, [code]);

  function onValidate() {
    const v = validateHtmlAgainstExpected(code, level.expected);
    setResult(v);
  }

  return (
    <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 14 }}>
      <Card title="Editor">
        <textarea
          value={code}
          onChange={(e) => setCode(e.target.value)}
          style={{
            width: "100%",
            minHeight: 260,
            padding: 12,
            fontFamily: "monospace",
          }}
        />

        <div style={{ display: "flex", gap: 10, marginTop: 12 }}>
          <Button onClick={onValidate}>Validate</Button>
          <Button variant="ghost" onClick={() => setShowPreview((s) => !s)}>
            {showPreview ? "Sakrij preview" : "Prikaži preview"}
          </Button>
        </div>

        {result.ok === true && (
          <p style={{ color: "green", marginTop: 12 }}>
            ✅ Tačno! Nivo je rešen.
          </p>
        )}

        {result.ok === false && (
          <ul style={{ color: "crimson", marginTop: 12 }}>
            {result.errors.map((e, i) => (
              <li key={i}>{e}</li>
            ))}
          </ul>
        )}
      </Card>

      {showPreview && (
        <Card title="Live preview">
          <iframe
            title="preview"
            style={{ width: "100%", height: 360 }}
            sandbox="allow-same-origin"
            srcDoc={previewHtml}
          />
        </Card>
      )}
    </div>
  );
}

/* =========================
   GLAVNA STRANICA NIVOA
========================= */

export default function LevelPlayPage() {
  const { id } = useParams();
  const nav = useNavigate();

  const [level, setLevel] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function load() {
      setLoading(true);
      try {
        const r = await fetch(`${API_BASE}/nivos/${id}`);
        if (!r.ok) throw new Error("Nivo nije pronađen");
        const data = await r.json();
        setLevel(data);
      } catch {
        setLevel(null);
      } finally {
        setLoading(false);
      }
    }
    load();
  }, [id]);

  if (loading) {
    return (
      <>
        <Navbar />
        <p style={{ padding: 20 }}>Učitavanje nivoa...</p>
      </>
    );
  }

  if (!level) {
    return (
      <>
        <Navbar />
        <Card title="Greška">
          <Button onClick={() => nav("/")}>Nazad</Button>
        </Card>
      </>
    );
  }

  return (
    <>
      <Navbar />

      <div className="container" style={{ marginTop: 18, display: "grid", gap: 14 }}>
        <Card title={level.naziv} subtitle={`Težina: ${level.tezina}`}>
          <p>{level.opis}</p>
          {level.hint && <p><b>Hint:</b> {level.hint}</p>}
        </Card>

        {/* OVDE SE BIRA MOD IGRE */}
        {level.level_config?.mode === "dragdrop" ? (
          <DragDropLevel level={level} />
        ) : (
          <ClassicEditor level={level} />
        )}
      </div>
    </>
  );
}
