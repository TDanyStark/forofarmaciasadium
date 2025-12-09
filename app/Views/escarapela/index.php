<?= $this->extend('layouts/dashboardLayout') ?>

<?= $this->section('content') ?>
<script type="module"
  crossorigin>(function () { const l = document.createElement("link").relList; if (l && l.supports && l.supports("modulepreload")) return; for (const t of document.querySelectorAll('link[rel="modulepreload"]')) p(t); new MutationObserver(t => { for (const e of t) if (e.type === "childList") for (const n of e.addedNodes) n.tagName === "LINK" && n.rel === "modulepreload" && p(n) }).observe(document, { childList: !0, subtree: !0 }); function f(t) { const e = {}; return t.integrity && (e.integrity = t.integrity), t.referrerPolicy && (e.referrerPolicy = t.referrerPolicy), t.crossOrigin === "use-credentials" ? e.credentials = "include" : t.crossOrigin === "anonymous" ? e.credentials = "omit" : e.credentials = "same-origin", e } function p(t) { if (t.ep) return; t.ep = !0; const e = f(t); fetch(t.href, e) } })(); (function () { function _(l) { try { return JSON.parse(l) } catch { return null } } document.addEventListener("DOMContentLoaded", function () { const l = { name: "attendee test" }, f = _(localStorage.getItem("user_info")), p = f && f.name ? f : l, t = document.getElementById("badgeID_badge-name"), e = document.getElementById("badgeID_badge"), n = e ? e.querySelector(".badgeID_badge-image") : null, r = e ? e.querySelector(".badgeID_badge-overlay") : null; if (t && (t.textContent = p.name || ""), !e) return; const D = 10; e.style.transformStyle = "preserve-3d"; const v = "transform 220ms ease, box-shadow 220ms ease"; e.style.transition = v; let d = !1, b = null, $ = null; const S = 5e3; function A() { d = !0, $ && (clearTimeout($), $ = null), b && (clearInterval(b), b = null), e.style.transition = v } function w() { if (d) return; const o = 1200, a = `transform ${o}ms cubic-bezier(0.22,0.8,0.2,1), box-shadow ${o}ms ease`; e.style.transition = a, n && (n.style.transition = `transform ${o}ms ease`), r && (r.style.transition = `transform ${o}ms ease`); const c = 3, u = -3; requestAnimationFrame(() => { requestAnimationFrame(() => { e.style.transform = `perspective(1000px) rotateX(${c}deg) rotateY(${u}deg)`, n && (n.style.transform = "translateZ(30px) translate(3px, -3px) scale(1.02)"), r && (r.style.transform = "translateZ(60px) translate(2px, -2px)") }) }), setTimeout(() => { if (d) return; const i = 900, m = `transform ${i}ms cubic-bezier(0.22,0.8,0.2,1), box-shadow ${i}ms ease`; e.style.transition = m, n && (n.style.transition = `transform ${i}ms ease`), r && (r.style.transition = `transform ${i}ms ease`), e.style.transform = "", n && (n.style.transform = ""), r && (r.style.transform = ""), setTimeout(() => { d || (e.style.transition = v, n && (n.style.transition = ""), r && (r.style.transition = "")) }, i) }, 2200) } $ = setTimeout(() => { d || (w(), b = setInterval(w, S)) }, S), e.addEventListener("mousemove", function (o) { d || A(); const a = e.getBoundingClientRect(), c = o.clientX - a.left, u = o.clientY - a.top, i = a.width / 2, m = a.height / 2, y = (c - i) / i, g = (u - m) / m, E = g * D, x = y * -D; e.style.transform = `perspective(1000px) rotateX(${E}deg) rotateY(${x}deg)`; const h = 30, I = 60; n && (n.style.transform = `translateZ(${h}px) translate(${y * 10}px, ${g * 10}px) scale(1.02)`), r && (r.style.transform = `translateZ(${I}px) translate(${y * 6}px, ${g * 6}px)`) }), e.addEventListener("mouseleave", function () { e.style.transform = "", n && (n.style.transform = ""), r && (r.style.transform = "") }); const T = e.querySelector(".user-info"); T && (T.style.pointerEvents = "auto"); const q = localStorage.getItem("_token"); q && (async function () { try { const o = `https://api.vfairs.com/v3/user/get-user-by-token?token=${encodeURIComponent(q)}&secret=secret_user`, a = await fetch(o, { method: "GET", credentials: "omit" }); if (!a.ok) throw new Error("Network response was not ok: " + a.status); const c = await a.json(), u = c && c.data && c.data.user_info && c.data.user_info.extracted_cv; if (!u) return; const i = u.split(/\r?\n/).map(s => s.trim()).filter(Boolean), m = s => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(s), y = s => /\d{1,2}\/\d{1,2}\/\d{2,4}/.test(s) || /\d{4}-\d{2}-\d{2}/.test(s), g = s => /^(masculino|femenino|male|female)$/i.test(s), E = s => /^(attendee|test|attest)$/i.test(s) || /^\d+$/.test(s), x = i.filter(s => !m(s) && !y(s) && !g(s) && !E(s)), h = x[0] || "", I = x[1] || "", L = document.getElementById("badgeID_badge-city") || r && r.querySelector("#badgeID_badge-city") || e.querySelector("#badgeID_badge-city"), O = document.getElementById("badgeID_badge-pharmacy") || r && r.querySelector("#badgeID_badge-pharmacy") || e.querySelector("#badgeID_badge-pharmacy"); L && (L.textContent = h ? `${h}` : ""), O && (O.textContent = I ? `${I}` : "") } catch (o) { console.error("Error fetching/parsing vFairs token info", o) } })() }) })();</script>
<style rel="stylesheet" crossorigin>
  :root {
    --gray: #747d84;
    --background-color: #747d84
  }

  .badgeID_container_body {
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: var(--background-color);
    font-family: Avenir !important
  }

  .badgeID_container_body * {
    box-sizing: border-box;
    margin: 0;
    padding: 0
  }

  .badgeID_badge {
    width: 400px;
    max-width: 100%;
    aspect-ratio: 5 / 7;
    position: relative;
    transform-style: preserve-3d;
    transition: transform .5s
  }

  .badgeID_badge-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    filter: drop-shadow(0 4px 20px #ff00335a)
  }

  .badgeID_badge-overlay {
    position: absolute;
    top: 45%;
    right: 10%;
    width: 80%;
    color: #000;
    padding: 10px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    text-align: center;
    height: 30%
  }

  .badgeID_name {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #ff0032;
    line-height: 1
  }

  .badge-field {
    font-size: 16px;
    color: #333;
    margin-top: 6px
  }

  .badgeID_badge-city {
    font-weight: 600;
    font-size: 20px;
    color: var(--gray);
    line-height: 1.2
  }

  .badgeID_badge-pharmacy {
    font-size: 20px;
    font-weight: 600;
    line-height: 1.2
  }
</style>


<div class="badgeID_container_body">
  <!-- Static badge markup: image + centered overlay (name & email). JS only for 3D and populating data -->
  <div class="badgeID_badge-wrap">
    <div class="badgeID_badge" id="badgeID_badge">
      <img
        src="https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/176254824807-11-2025-escarapelas-foro-gastroenterologi-a-png1762548248.png"
        alt="badge image" class="badgeID_badge-image" />
      <div class="badgeID_badge-overlay">
        <div class="badgeID_user-info">
          <div class="badgeID_name" id="badgeID_badge-name">attendee name</div>
          <!-- Added persistent placeholders for parsed fields -->
          <div class="badgeID_badge-city" id="badgeID_badge-city">Ciudad</div>
          <div class="badgeID_badge-pharmacy" id="badgeID_badge-pharmacy">Farmacia</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
