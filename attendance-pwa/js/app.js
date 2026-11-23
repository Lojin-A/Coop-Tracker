// Talks to the Attendance service's REST API.
//
// IMPORTANT: change this if your attendance-service runs somewhere else
// (e.g. a Laragon virtual host like http://attendance-service.test, or a
// different port). This matches the APP_URL in attendance-service/.env
// at the time this was written.
const API_BASE = "http://localhost:8000/api";

const els = {
  placementInput: document.getElementById("placement-id"),
  savePlacementBtn: document.getElementById("save-placement"),
  activePlacement: document.getElementById("active-placement"),
  statsCard: document.getElementById("stats-card"),
  statApproved: document.getElementById("stat-approved"),
  statAbsent: document.getElementById("stat-absent"),
  actionCard: document.getElementById("action-card"),
  historyCard: document.getElementById("history-card"),
  todayStatus: document.getElementById("today-status"),
  checkInBtn: document.getElementById("check-in-btn"),
  checkOutBtn: document.getElementById("check-out-btn"),
  actionMessage: document.getElementById("action-message"),
  historyBody: document.querySelector("#history-table tbody"),
};

// TEMPORARY: the placement ID is kept in the browser's own storage, not
// behind a login, because Auth/Placements isn't wired up yet. Once it is,
// this whole block goes away and the ID comes from the logged-in user.
function getStoredPlacementId() {
  return localStorage.getItem("placement_id");
}

function setStoredPlacementId(id) {
  localStorage.setItem("placement_id", id);
}

async function apiGet(path) {
  const res = await fetch(`${API_BASE}${path}`);
  const body = await res.json().catch(() => null);
  return { ok: res.ok, status: res.status, body };
}

async function apiPost(path, data) {
  const res = await fetch(`${API_BASE}${path}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  const body = await res.json().catch(() => null);
  return { ok: res.ok, status: res.status, body };
}

function showMessage(text, isError = false) {
  els.actionMessage.textContent = text;
  els.actionMessage.className = isError ? "message error" : "message";
}

function renderHistory(records) {
  els.historyBody.innerHTML = "";
  for (const r of records) {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${r.date}</td>
      <td>${r.check_in ?? "—"}</td>
      <td>${r.check_out ?? "—"}</td>
      <td>${r.hours ?? "—"}</td>
      <td>${r.status}</td>
    `;
    els.historyBody.appendChild(row);
  }
}

async function refreshStats(placementId) {
  // GET /api/placements/{id}/hours — only using approved_days/absent_days
  // here; approved_hours (lifetime total) isn't shown, since today's hours
  // already appear in the status line above and a running total belongs
  // to the Reports service's weekly progress view, not here.
  const stats = await apiGet(`/placements/${placementId}/hours`);
  if (!stats.ok) return;

  els.statApproved.textContent = stats.body.approved_days;
  els.statAbsent.textContent = stats.body.absent_days;
  els.statsCard.classList.remove("hidden");
}

async function refreshForPlacement(placementId) {
  // GET /api/attendance expects placement_id as a query param.
  const history = await apiGet(`/attendance?placement_id=${placementId}`);
  if (!history.ok) {
    showMessage("Could not load attendance history.", true);
    return;
  }

  renderHistory(history.body);
  refreshStats(placementId);

  const today = new Date().toISOString().slice(0, 10);
  const todayRecord = history.body.find((r) => r.date === today);

  if (!todayRecord) {
    els.todayStatus.textContent = "Not checked in today";
    els.checkInBtn.disabled = false;
    els.checkOutBtn.disabled = true;
  } else if (!todayRecord.check_out) {
    els.todayStatus.textContent = `Checked in at ${todayRecord.check_in}`;
    els.checkInBtn.disabled = true;
    els.checkOutBtn.disabled = false;
  } else {
    els.todayStatus.textContent = `Done for today — ${todayRecord.hours} hours (${todayRecord.status})`;
    els.checkInBtn.disabled = true;
    els.checkOutBtn.disabled = true;
  }
}

function activatePlacement(placementId) {
  setStoredPlacementId(placementId);
  els.activePlacement.textContent = `Active placement: #${placementId}`;
  els.actionCard.classList.remove("hidden");
  els.historyCard.classList.remove("hidden");
  refreshForPlacement(placementId);
}

els.savePlacementBtn.addEventListener("click", () => {
  const id = els.placementInput.value;
  if (!id) return;
  activatePlacement(id);
});

els.checkInBtn.addEventListener("click", async () => {
  const placementId = getStoredPlacementId();
  const result = await apiPost("/check-in", { placement_id: Number(placementId) });

  if (result.ok) {
    showMessage("Checked in.");
  } else {
    showMessage(result.body?.message ?? "Check-in failed.", true);
  }
  refreshForPlacement(placementId);
});

els.checkOutBtn.addEventListener("click", async () => {
  const placementId = getStoredPlacementId();
  const result = await apiPost("/check-out", { placement_id: Number(placementId) });

  if (result.ok) {
    showMessage(`Checked out. ${result.body.hours} hours recorded.`);
  } else {
    showMessage(result.body?.message ?? "Check-out failed.", true);
  }
  refreshForPlacement(placementId);
});

// On load: if a placement was already set up, skip straight to it.
(function init() {
  const existing = getStoredPlacementId();
  if (existing) {
    els.placementInput.value = existing;
    activatePlacement(existing);
  }
})();

// Register the service worker for the "installable" PWA requirement.
if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker.register("service-worker.js");
  });
}
