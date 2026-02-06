import React, { useMemo, useState, useEffect } from "react";
import { DndContext, useDraggable, useDroppable } from "@dnd-kit/core";



function newInstanceId(baseId) {
  const rand =
    typeof crypto !== "undefined" && crypto.randomUUID
      ? crypto.randomUUID()
      : `${Date.now()}_${Math.random().toString(16).slice(2)}`;
  return `${baseId}__${rand}`;
}



function PaletteBlock({ baseId, label }) {
  const dragId = `p:${baseId}`;

  const { attributes, listeners, setNodeRef, transform } = useDraggable({
    id: dragId,
  });

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



function PlacedBlock({ instanceId, label, onRemove }) {
  const { attributes, listeners, setNodeRef, transform } = useDraggable({
    id: instanceId,
  });

  const style = {
    padding: 10,
    borderRadius: 10,
    background: "#fff",
    border: "1px solid #e5e7eb",
    display: "flex",
    alignItems: "center",
    justifyContent: "space-between",
    gap: 10,
    cursor: "grab",
    transform: transform
      ? `translate3d(${transform.x}px, ${transform.y}px, 0)`
      : undefined,
  };

  return (
    <div ref={setNodeRef} style={style} {...listeners} {...attributes}>
      <span>{label}</span>


      <button
        type="button"
        onPointerDown={(e) => e.stopPropagation()}
        onMouseDown={(e) => e.stopPropagation()}
        onClick={(e) => {
          e.stopPropagation();
          onRemove(instanceId);
        }}
        style={{
          border: "1px solid #e5e7eb",
          background: "#f8fafc",
          borderRadius: 8,
          padding: "2px 8px",
          cursor: "pointer",
        }}
        title="Obriši blok"
      >
        ✕
      </button>
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



function validatePhase(baseTree, phase) {
  const rules = phase?.rules || [];
  const errors = [];

  for (const r of rules) {
    if (r.type === "blockInSlot") {
      const list = baseTree[r.slot] || [];
      if (!list.includes(r.block)) {
        errors.push(`Blok ${r.block} mora biti u slotu "${r.slot}"`);
      }
    }

    if (r.type === "slotOrder") {
      const got = baseTree[r.slot] || [];
      const want = r.order || [];
      if (JSON.stringify(got) !== JSON.stringify(want)) {
        errors.push(`Pogrešan redosled u slotu "${r.slot}"`);
      }
    }

    if (r.type === "requireBlocks") {
      const all = Object.values(baseTree).flat();
      for (const b of r.blocks || []) {
        if (!all.includes(b)) errors.push(`Nedostaje blok: ${b}`);
      }
    }
  }

  return { ok: errors.length === 0, errors };
}



export default function DragDropLevel({ level }) {
  const cfg = level?.level_config || {};
  const blocks = cfg.blocks || {};
  const phases = Array.isArray(cfg.phases) ? cfg.phases : [];

  const [phaseIdx, setPhaseIdx] = useState(0);
  const phase = phases[phaseIdx];

  const [tree, setTree] = useState({ root: [] });
  const [instanceBase, setInstanceBase] = useState({});
  const [result, setResult] = useState({ ok: null, errors: [], msg: "" });


  useEffect(() => {
    setPhaseIdx(0);
    setTree({ root: [] });
    setInstanceBase({});
    setResult({ ok: null, errors: [], msg: "" });
  }, [level?.id]);

  if (!phases.length) return <p>Nema faza u level_config.</p>;
  if (!Object.keys(blocks).length) return <p>Nema blokova.</p>;
  if (!phase) return <p>Nema faze.</p>;

  const paletteIds = useMemo(() => phase.palette || [], [phase]);

  const dropSlots = useMemo(
    () => Array.from(new Set(["root", ...(phase.slots || [])])),
    [phase]
  );

  const baseTree = useMemo(() => {
    const bt = {};
    for (const slot of Object.keys(tree)) {
      bt[slot] = (tree[slot] || []).map((id) => instanceBase[id]);
    }
    return bt;
  }, [tree, instanceBase]);



  function onDragEnd(e) {
    const { active, over } = e;
    if (!over) return;

    const toSlot = over.id;
    const activeId = String(active.id);


    if (activeId.startsWith("p:")) {
      const baseId = activeId.slice(2);
      const instId = newInstanceId(baseId);

      setInstanceBase((m) => ({ ...m, [instId]: baseId }));

      setTree((prev) => ({
        ...prev,
        [toSlot]: [...(prev[toSlot] || []), instId],
      }));

      return;
    }


    const instId = activeId;

    setTree((prev) => {
      const next = { ...prev };

      for (const k of Object.keys(next)) {
        next[k] = (next[k] || []).filter((x) => x !== instId);
      }

      next[toSlot] = [...(next[toSlot] || []), instId];
      return next;
    });
  }



  function removeInstance(instId) {
    setTree((prev) => {
      const next = { ...prev };
      for (const k of Object.keys(next)) {
        next[k] = (next[k] || []).filter((x) => x !== instId);
      }
      return next;
    });

    setInstanceBase((prev) => {
      const copy = { ...prev };
      delete copy[instId];
      return copy;
    });
  }



  async function validate() {
    const v = validatePhase(baseTree, phase);

    setResult({
      ok: v.ok,
      errors: v.errors,
      msg: v.ok ? phase.success || "✅ Tačno!" : "",
    });

    if (!v.ok) return;


    const token = localStorage.getItem("auth_token");
    if (!token) return;

    try {
      await fetch(
        `http://127.0.0.1:8000/api/nivos/${level.id}/phases/${phaseIdx}/complete`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify({ poeni: 100 }),
        }
      );
    } catch (e) {
      console.error("Upis poena nije uspeo:", e);
    }
  }

  function nextPhase() {
    setTree({ root: [] });
    setInstanceBase({});
    setResult({ ok: null, errors: [], msg: "" });
    setPhaseIdx((i) => i + 1);
  }



  return (
    <DndContext onDragEnd={onDragEnd}>
      <div style={{ display: "grid", gridTemplateColumns: "340px 1fr", gap: 16 }}>

        <div style={{ display: "grid", gap: 12 }}>
          <div style={{ fontWeight: 800, fontSize: 18 }}>{phase.title}</div>

          {phase.taskText && (
            <div style={{ background: "#f1f5f9", padding: 12, borderRadius: 12 }}>
              {phase.taskText}
            </div>
          )}

          {paletteIds.map((baseId) => (
            <PaletteBlock
              key={baseId}
              baseId={baseId}
              label={blocks[baseId]?.label || baseId}
            />
          ))}

          <button onClick={validate}>Validate</button>

          {result.ok === true && (
            <div style={{ color: "green", fontWeight: 700 }}>
              {result.msg}
              {phaseIdx < phases.length - 1 && (
                <button onClick={nextPhase}>Sledeća faza →</button>
              )}
            </div>
          )}

          {result.ok === false && (
            <ul style={{ color: "crimson" }}>
              {result.errors.map((e, i) => (
                <li key={i}>{e}</li>
              ))}
            </ul>
          )}
        </div>


        <div style={{ display: "grid", gap: 12 }}>
          {dropSlots.map((slot) => (
            <DropZone key={slot} id={slot} title={`Slot: ${slot}`}>
              {(tree[slot] || []).map((instId) => (
                <PlacedBlock
                  key={instId}
                  instanceId={instId}
                  label={blocks[instanceBase[instId]]?.label}
                  onRemove={removeInstance}
                />
              ))}
            </DropZone>
          ))}
        </div>
      </div>
    </DndContext>
  );
}
