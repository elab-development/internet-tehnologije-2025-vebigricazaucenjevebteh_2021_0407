import React, { useMemo, useState } from "react";
import { DndContext, useDraggable, useDroppable } from "@dnd-kit/core";


function DraggableBlock({ id, label }) {
  const { attributes, listeners, setNodeRef, transform } = useDraggable({ id });

  const style = {
    padding: 10,
    border: "1px solid #d1d5db",
    borderRadius: 10,
    background: "white",
    cursor: "grab",
    transform: transform
      ? `translate3d(${transform.x}px, ${transform.y}px, 0)`
      : undefined,
  };

  return (
    <div ref={setNodeRef} style={style} {...listeners} {...attributes}>
      {label}
    </div>
  );
}


function DropZone({ id, title, children }) {
  const { isOver, setNodeRef } = useDroppable({ id });

  return (
    <div
      ref={setNodeRef}
      style={{
        padding: 12,
        border: `2px dashed ${isOver ? "#3b82f6" : "#cbd5e1"}`,
        borderRadius: 14,
        minHeight: 80,
        background: isOver ? "#eff6ff" : "#f8fafc",
      }}
    >
      <div style={{ fontSize: 12, opacity: 0.7, marginBottom: 8 }}>
        {title}
      </div>
      {children}
    </div>
  );
}


function validatePhase(tree, phase, blocks) {
  const rules = phase?.rules || [];
  const errors = [];

  for (const r of rules) {
    if (r.type === "slotOrder") {
      const got = tree[r.slot] || [];
      if (JSON.stringify(got) !== JSON.stringify(r.order)) {
        errors.push(`Pogrešan redosled u slotu "${r.slot}".`);
      }
    }

    if (r.type === "requireBlocks") {
      const all = Object.values(tree).flat();
      for (const b of r.blocks) {
        if (!all.includes(b)) {
          errors.push(`Nedostaje blok: ${b}`);
        }
      }
    }

    if (r.type === "forbidTag") {
      const all = Object.values(tree).flat();
      const bad = all.some((id) => blocks[id]?.tag === r.tag);
      if (bad) errors.push(`Ne smeš koristiti <${r.tag}>.`);
    }

    if (r.type === "aMustBeInsideLi") {
      const allTags = Object.values(tree)
        .flat()
        .map((id) => blocks[id]?.tag);

      if (allTags.includes("a") && !allTags.includes("li")) {
        errors.push("<a> mora biti unutar <li>.");
      }
    }

    if (r.type === "liMustBeInsideUl") {
      const allTags = Object.values(tree)
        .flat()
        .map((id) => blocks[id]?.tag);

      if (allTags.includes("li") && !allTags.includes("ul")) {
        errors.push("<li> mora biti unutar <ul>.");
      }
    }
  }

  return { ok: errors.length === 0, errors };
}


export default function DragDropLevel({ level }) {
  const cfg = level?.level_config;
  const blocks = cfg?.blocks || {};
  const phases = cfg?.phases || [];

  const [phaseIdx, setPhaseIdx] = useState(0);
  const phase = phases[phaseIdx];

  const [tree, setTree] = useState({ root: [] });
  const [result, setResult] = useState({ ok: null, errors: [], msg: "" });

  const paletteIds = useMemo(() => phase?.palette || [], [phase]);

  function onDragEnd(e) {
    const { active, over } = e;
    if (!over) return;

    const blockId = active.id;
    const slotId = over.id;

    const next = { ...tree };
    Object.keys(next).forEach((k) => {
      next[k] = next[k].filter((x) => x !== blockId);
    });

    if (!next[slotId]) next[slotId] = [];
    next[slotId].push(blockId);

    setTree(next);
  }

  function validate() {
    const v = validatePhase(tree, phase, blocks);
    setResult({
      ok: v.ok,
      errors: v.errors,
      msg: v.ok ? phase?.success || "✅ Tačno!" : "",
    });
  }

  function nextPhase() {
    setTree({ root: [] });
    setResult({ ok: null, errors: [], msg: "" });
    setPhaseIdx((i) => i + 1);
  }

  const dropSlots = useMemo(() => {
  const s = new Set(["root", ...(phase?.slots || [])]);
  return Array.from(s);
}, [phase]);

  return (
    <DndContext onDragEnd={onDragEnd}>
      <div style={{ display: "grid", gridTemplateColumns: "340px 1fr", gap: 16 }}>


        <div style={{ display: "grid", gap: 12 }}>

          <div style={{ fontWeight: 800, fontSize: 18 }}>
            {phase?.title}
          </div>


          {phase?.taskText && (
            <div
              style={{
                background: "#f1f5f9",
                padding: 12,
                borderRadius: 12,
                fontSize: 14,
              }}
            >
              {phase.taskText}
            </div>
          )}

          <div style={{ display: "grid", gap: 8 }}>
            {paletteIds.map((id) => (
              <DraggableBlock
                key={id}
                id={id}
                label={blocks[id]?.label || id}
              />
            ))}
          </div>

          <button
            onClick={validate}
            style={{
              padding: 10,
              borderRadius: 10,
              border: "1px solid #d1d5db",
            }}
          >
            Validate
          </button>

          {result.ok === true && (
            <div style={{ color: "green", fontWeight: 700 }}>
              {result.msg}
              {phaseIdx < phases.length - 1 && (
                <div style={{ marginTop: 8 }}>
                  <button
                    onClick={nextPhase}
                    style={{
                      padding: 10,
                      borderRadius: 10,
                      border: "1px solid #d1d5db",
                    }}
                  >
                    Sledeća faza →
                  </button>
                </div>
              )}
            </div>
          )}

          {result.ok === false && (
            <div style={{ color: "crimson" }}>
              <b>Greške:</b>
              <ul>
                {result.errors.map((e, i) => (
                  <li key={i}>{e}</li>
                ))}
              </ul>
            </div>
          )}
        </div>


        <div style={{ display: "grid", gap: 12 }}>
          <div style={{ fontWeight: 700 }}>Canvas</div>

          {dropSlots.map((slot) => (
            <DropZone key={slot} id={slot} title={`Slot: ${slot}`}>
              <div style={{ display: "grid", gap: 8 }}>
                {(tree[slot] || []).map((bid, i) => (
                  <div
                    key={`${bid}-${i}`}
                    style={{
                      padding: 10,
                      borderRadius: 10,
                      background: "#fff",
                      border: "1px solid #e5e7eb",
                    }}
                  >
                    {blocks[bid]?.label || bid}
                  </div>
                ))}
              </div>
            </DropZone>
          ))}
        </div>

      </div>
    </DndContext>
  );
}
