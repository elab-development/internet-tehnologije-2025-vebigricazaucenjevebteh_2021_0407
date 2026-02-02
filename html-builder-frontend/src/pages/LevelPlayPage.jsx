import { useEffect, useMemo, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import Navbar from "../components/Navbar";
import Card from "../components/Card";
import Button from "../components/Button";

const API_BASE = "http://127.0.0.1:8000/api";

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

  const doc = new DOMParser().parseFromString(html, "text/html");
  const body = doc.body;

  const tags = collectTags(body, []);

  if (!expected || !expected.tag) {

    return { ok: true, errors: [] };
  }


  const need = [];
  (function walk(exp) {
    if (!exp) return;
    if (exp.tag) need.push(exp.tag.toLowerCase());
    if (Array.isArray(exp.children)) exp.children.forEach(walk);
  })(expected);


  for (const t of need) {
    if (!tags.includes(t)) errors.push(`Nedostaje tag <${t}>`);
  }


  let lastIndex = -1;
  for (const t of need) {
    const idx = tags.indexOf(t);
    if (idx !== -1 && idx < lastIndex) {
      errors.push(`Pogrešan redosled: <${t}> se pojavljuje pre očekivanog.`);
      break;
    }
    if (idx !== -1) lastIndex = idx;
  }

  return { ok: errors.length === 0, errors };
}

export default function LevelPlayPage() {
  const { id } = useParams();
  const nav = useNavigate();

  const token = localStorage.getItem("token");
  const [level, setLevel] = useState(null);
  const [loading, setLoading] = useState(true);

  const [code, setCode] = useState("<header></header>\n<main></main>\n<footer></footer>");
  const [showPreview, setShowPreview] = useState(true);

  const [result, setResult] = useState({ ok: null, errors: [] });


  useEffect(() => {
    if (!token) {
      nav("/login");
      return;
    }
  }, [token, nav]);

  useEffect(() => {
    let alive = true;

    async function load() {
      setLoading(true);
      setResult({ ok: null, errors: [] });

      try {
        const r = await fetch(`${API_BASE}/nivos/${id}`);
        if (!r.ok) throw new Error("Ne mogu da učitam nivo.");
        const data = await r.json();

        if (!alive) return;
        setLevel(data);


        if (data?.starter_html) setCode(data.starter_html);
      } catch (e) {
        if (!alive) return;
        setLevel(null);
      } finally {
        if (alive) setLoading(false);
      }
    }

    load();
    return () => (alive = false);
  }, [id]);

  const previewHtml = useMemo(() => {

    return `<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <style>
    body{font-family:system-ui,sans-serif;padding:16px}
    header,main,footer,section,article,aside,nav,figure{border:1px dashed #cbd5e1;padding:10px;margin:8px 0;border-radius:10px}
  </style>
</head>
<body>
${code}
</body>
</html>`;
  }, [code]);

  function onValidate() {
    const expected = level?.expected || null;
    const v = validateHtmlAgainstExpected(code, expected);
    setResult(v);
  }

  if (loading) {
    return (
      <>
        <Navbar />
        <div className="container" style={{ marginTop: 18 }}>
          <p>Učitavanje nivoa...</p>
        </div>
      </>
    );
  }

  if (!level) {
    return (
      <>
        <Navbar />
        <div className="container" style={{ marginTop: 18 }}>
          <Card title="Greška" subtitle="Nivo nije pronađen">
            <Button onClick={() => nav("/")}>Nazad</Button>
          </Card>
        </div>
      </>
    );
  }

  return (
    <>
      <Navbar />

      <div className="container" style={{ marginTop: 18, display: "grid", gap: 14 }}>
        <Card title={level.naziv} subtitle={`Težina: ${level.tezina}`}>
          <p style={{ marginTop: 0, color: "var(--muted)" }}>{level.opis}</p>
          {level.hint ? <p style={{ color: "var(--muted)" }}><b>Hint:</b> {level.hint}</p> : null}
        </Card>

        <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 14 }}>
          <Card title="Editor" subtitle="Unesi HTML strukturu">
            <textarea
              value={code}
              onChange={(e) => setCode(e.target.value)}
              style={{
                width: "100%",
                minHeight: 260,
                padding: 12,
                borderRadius: 12,
                border: "1px solid #d1d5db",
                fontFamily: "ui-monospace, SFMono-Regular, Menlo, monospace",
                fontSize: 13,
              }}
            />

            <div style={{ display: "flex", gap: 10, marginTop: 12 }}>
              <Button onClick={onValidate}>Validate</Button>
              <Button variant="ghost" onClick={() => setShowPreview((s) => !s)}>
                {showPreview ? "Sakrij preview" : "Prikaži preview"}
              </Button>
            </div>

            {result.ok === true ? (
              <p style={{ marginTop: 12, color: "green", fontWeight: 600 }}>✅ Tačno! Nivo je rešen.</p>
            ) : null}

            {result.ok === false ? (
              <div style={{ marginTop: 12 }}>
                <p style={{ color: "crimson", fontWeight: 600, marginBottom: 8 }}>❌ Greške:</p>
                <ul style={{ marginTop: 0 }}>
                  {result.errors.map((e, i) => (
                    <li key={i}>{e}</li>
                  ))}
                </ul>
              </div>
            ) : null}
          </Card>

          {showPreview ? (
            <Card title="Live preview" subtitle="Sandbox prikaz">
              <iframe
                title="preview"
                sandbox="allow-same-origin"
                style={{ width: "100%", height: 360, border: "1px solid #e5e7eb", borderRadius: 12 }}
                srcDoc={previewHtml}
              />
            </Card>
          ) : (
            <Card title="Live preview" subtitle="Sakriven">
              <p style={{ color: "var(--muted)" }}>Klikni “Prikaži preview”.</p>
            </Card>
          )}
        </div>
      </div>
    </>
  );
}
