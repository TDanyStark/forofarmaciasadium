<?= $this->extend('layouts/dashboardLayout') ?>

<?= $this->section('content') ?>

  <script type="module"
    crossorigin>var Ce = (p, f) => () => (f || p((f = { exports: {} }).exports, f), f.exports); var Ee = Ce((be, ce) => {
        (function () { const f = document.createElement("link").relList; if (f && f.supports && f.supports("modulepreload")) return; for (const S of document.querySelectorAll('link[rel="modulepreload"]')) V(S); new MutationObserver(S => { for (const y of S) if (y.type === "childList") for (const R of y.addedNodes) R.tagName === "LINK" && R.rel === "modulepreload" && V(R) }).observe(document, { childList: !0, subtree: !0 }); function L(S) { const y = {}; return S.integrity && (y.integrity = S.integrity), S.referrerPolicy && (y.referrerPolicy = S.referrerPolicy), S.crossOrigin === "use-credentials" ? y.credentials = "include" : S.crossOrigin === "anonymous" ? y.credentials = "omit" : y.credentials = "same-origin", y } function V(S) { if (S.ep) return; S.ep = !0; const y = L(S); fetch(S.href, y) } })(); (function (p) { p.Games = p.Games || {}, p.Games.wordsearch = { start: function (f, L = {}) { return new Promise(V => { const S = ["INTESTINAL", "SEGURIDAD", "EFICACIA", "BAJOVOLUMEN", "PREPARACION", "COLONOSCOPIA", "LIMALIMON", "CEREZA"], y = L.size || 12, R = L.timeLimit || 120; let I = [], N = [], w = !1, b = [], j = null, $ = !1, Z = null, q = R; f.innerHTML = ""; const W = document.createElement("h2"); W.textContent = "Sopa de letras"; const E = document.createElement("p"); E.textContent = "Encuentra las palabras clave, relacionadas con la eficaz limpieza intestinal y la preparación de Bajo Volumen para la Colonoscopia. Selecciona con click o touch y arrastre."; const A = document.createElement("div"); A.className = "danielamado_grid"; const k = document.createElement("aside"); k.className = "danielamado_sidebar"; const T = document.createElement("ul"); T.className = "danielamado_word-list"; const H = document.createElement("div"); H.className = "danielamado_status"; const B = document.createElement("span"); B.id = "danielamado_wsFound"; const Y = document.createElement("span"); Y.id = "danielamado_wsTotal"; const U = document.createElement("span"); U.className = "danielamado_ws-label", U.textContent = "Palabras encontradas:", H.appendChild(U); const Q = document.createElement("div"); Q.className = "danielamado_wordsearch_founds_and_total", Q.appendChild(B), Q.appendChild(document.createTextNode("/")), Q.appendChild(Y), H.appendChild(Q), k.appendChild(document.createElement("h3")).textContent = "Palabras", k.appendChild(T), k.appendChild(H), f.appendChild(W), f.appendChild(E); const G = document.createElement("section"); G.className = "danielamado_game_wordsearch", G.appendChild(A), G.appendChild(k), f.appendChild(G); const z = [[0, 1], [1, 0], [-1, 0], [0, -1], [1, 1], [1, -1], [-1, 1], [-1, -1]]; function te() { I = []; for (let o = 0; o < y; o++) { const a = []; for (let i = 0; i < y; i++)a.push(""); I.push(a) } } function ne() { N = []; const o = S.slice().sort((a, i) => i.length - a.length); for (const a of o) { const i = a.toUpperCase(); let g = !1; for (let C = 0; C < 500 && !g; C++) { const _ = z[Math.floor(Math.random() * z.length)], F = Math.floor(Math.random() * y), D = Math.floor(Math.random() * y), O = []; let J = !0; for (let P = 0; P < i.length; P++) { const ae = F + _[0] * P, X = D + _[1] * P; if (ae < 0 || ae >= y || X < 0 || X >= y) { J = !1; break } const oe = I[ae][X]; if (oe !== "" && oe !== i[P]) { J = !1; break } O.push({ r: ae, c: X }) } if (J) { for (let P = 0; P < i.length; P++)I[O[P].r][O[P].c] = i[P]; N.push({ word: i, coords: O, found: !1 }), g = !0 } } if (!g) return !1 } return !0 } function re() { const o = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; for (let a = 0; a < y; a++)for (let i = 0; i < y; i++)I[a][i] || (I[a][i] = o[Math.floor(Math.random() * o.length)]) } function K() { A.innerHTML = ""; for (let o = 0; o < y; o++)for (let a = 0; a < y; a++) { const i = document.createElement("div"); i.className = "danielamado_cell", i.dataset.r = o, i.dataset.c = a, i.textContent = I[o][a], A.appendChild(i) } } function ee() { T.innerHTML = ""; for (const o of N) { const a = document.createElement("li"); a.textContent = o.word, o.found && a.classList.add("found"), a.dataset.word = o.word, T.appendChild(a) } Y.textContent = N.length, M() } function M() { const o = N.filter(a => a.found).length; if (B.textContent = o, o === N.length) { let a = 0; if (q > 0) { a = Math.max(0, Math.floor(q)); const i = new CustomEvent("game-score", { detail: { game: "wordsearch", delta: a } }); p.dispatchEvent(i) } m(), V(o * 10 + a) } } function n(o, a) { return A.querySelector(`.danielamado_cell[data-r='${o}'][data-c='${a}']`) } function l() { A.querySelectorAll(".danielamado_cell.danielamado_selecting").forEach(o => o.classList.remove("danielamado_selecting")) } function s(o) { for (const { r: a, c: i } of o) { const g = n(a, i); g && g.classList.add("danielamado_found") } } function t() { if (b.length === 0) return; const o = b.map(i => I[i.r][i.c]).join(""), a = o.split("").reverse().join(""); for (const i of N) if (!i.found && (i.word === o || i.word === a)) { i.found = !0, s(i.coords); const g = T.querySelector(`li[data-word='${i.word}']`); g && g.classList.add("danielamado_found"); const C = new CustomEvent("game-score", { detail: { game: "wordsearch", delta: 10 } }); p.dispatchEvent(C), M(); break } } function e(o, a) { if (b.length && b[b.length - 1].r === o && b[b.length - 1].c === a || b.find(_ => _.r === o && _.c === a)) return; if (b.length === 0) { b.push({ r: o, c: a }); const _ = n(o, a); _ && _.classList.add("danielamado_selecting"), j = null, $ = !1; return } if (b.length === 1) { const _ = b[0].r, F = b[0].c, D = o - _, O = a - F, J = Math.sign(D), P = Math.sign(O); J === 0 || P === 0 || Math.abs(D) === Math.abs(O) || ($ = !0), j = { dr: J, dc: P }; const X = Math.max(Math.abs(D), Math.abs(O)); for (let oe = 1; oe <= X; oe++) { const ie = _ + j.dr * oe, le = F + j.dc * oe; if (!b.find(se => se.r === ie && se.c === le)) { b.push({ r: ie, c: le }); const se = n(ie, le); se && se.classList.add("danielamado_selecting") } } return } if ($ || !j) return; const i = b[b.length - 1], g = i.r + j.dr, C = i.c + j.dc; if (o === g && a === C) { b.push({ r: o, c: a }); const _ = n(o, a); _ && _.classList.add("danielamado_selecting") } } function r(o) { o.preventDefault(), w = !0, b = [], j = null, $ = !1, l(); const a = o.touches ? document.elementFromPoint(o.touches[0].clientX, o.touches[0].clientY) : o.target, i = a && a.closest ? a.closest(".danielamado_cell") : null; i && e(+i.dataset.r, +i.dataset.c) } function c(o) { if (!w) return; const a = o.touches ? o.touches[0] : null, i = a ? document.elementFromPoint(a.clientX, a.clientY) : o.target, g = i && i.closest ? i.closest(".danielamado_cell") : null; g && e(+g.dataset.r, +g.dataset.c) } function u(o) { w && (w = !1, t(), b = [], j = null, $ = !1, l()) } function h() { A.addEventListener("mousedown", r), A.addEventListener("mousemove", c), p.addEventListener("mouseup", u), A.addEventListener("touchstart", r, { passive: !1 }), A.addEventListener("touchmove", c, { passive: !1 }), p.addEventListener("touchend", u) } function d() { m(), q = R, v(), Z = setInterval(() => { q--, v(), q <= 0 && (m(), V(0)) }, 1e3) } function m() { Z && (clearInterval(Z), Z = null) } function v() { const o = new CustomEvent("game-timer", { detail: { game: "wordsearch", timeLeft: q } }); p.dispatchEvent(o) } function x() { te(); let o = !1, a = 0; for (; !o && a < 8;)te(), o = ne(), a++; if (!o) { V(0); return } re(), K(), ee(), h(), d() } x() }) } } })(window); (function (p) { p.Games = p.Games || {}, p.Games.memory = { start: function (f, L = {}) { return new Promise(V => { const S = L.timeLimit || 90, y = L.pairs || 8; let R = null, I = S, N = 0, w = 0; f.innerHTML = ""; const b = document.createElement("h2"); b.textContent = "Encuentra las Parejas"; const j = document.createElement("p"); j.textContent = "Asocia correctamente cada par de imágenes asociadas a Síndrome de Intestino Irritable."; const $ = document.createElement("div"); $.className = "danielamado_memory-board"; const Z = document.createElement("div"); Z.className = "danielamado_status"; const q = document.createElement("span"); q.className = "danielamado_mem-label", q.textContent = "Parejas encontradas:"; const W = document.createElement("div"); W.className = "danielamado_memory_status_wrap"; const E = document.createElement("span"); E.id = "danielamado_memMatches", E.className = "danielamado_mem-matches", E.textContent = `0/${y}`; const A = document.createTextNode(" "), k = document.createElement("span"); k.id = "danielamado_memMoves", k.className = "danielamado_mem-moves", k.textContent = "Movimientos: 0", W.appendChild(E), W.appendChild(A), W.appendChild(k), Z.appendChild(q), Z.appendChild(W); const T = document.createElement("div"); T.className = "danielamado_message", f.appendChild(b), f.appendChild(j), f.appendChild($), f.appendChild(Z), f.appendChild(T); const H = ["https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1516-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1515-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1514-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1513-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1512-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1511-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1510-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1509-png1762551288.png"], B = L.images && L.images.length ? L.images.slice() : H.slice(); for (; B.length < y;)B.push(...B.slice(0, y - B.length)); B.sort(() => .5 - Math.random()); const Y = B.slice(0, y), U = []; for (const s of Y) U.push({ img: s }), U.push({ img: s }); for (let s = U.length - 1; s > 0; s--) { const t = Math.floor(Math.random() * (s + 1));[U[s], U[t]] = [U[t], U[s]] } function Q() { $.innerHTML = "", $.style.gridTemplateColumns = "repeat(4, 80px)"; for (let s = 0; s < U.length; s++) { const t = U[s], e = document.createElement("button"); e.className = "danielamado_mem-card", e.dataset.index = s; const r = document.createElement("div"); r.className = "danielamado_flip-card-inner"; const c = document.createElement("div"); c.className = "danielamado_flip-card-front"; const u = document.createElement("div"); u.className = "danielamado_flip-card-back"; const h = document.createElement("img"); h.src = t.img, h.alt = "card", h.style.width = "100%", h.style.height = "100%", h.style.objectFit = "cover", u.appendChild(h), r.appendChild(c), r.appendChild(u), e.appendChild(r), $.appendChild(e) } } let G = null, z = null; function te(s, t) { if (s.classList.contains("danielamado_found")) return; const e = s.querySelector(".danielamado_flip-card-inner"); e && (e.classList.contains("danielamado_is-flipped") || e.classList.add("danielamado_is-flipped")) } function ne(s) { const t = s.querySelector(".danielamado_flip-card-inner"); t && t.classList.remove("danielamado_is-flipped") } function re(s) { const t = s.target.closest(".danielamado_mem-card"); if (!t) return; const e = +t.dataset.index; if (!t.classList.contains("danielamado_flipped") && !(G && z)) { if (te(t), !G) { G = { el: t, idx: e }; return } if (z = { el: t, idx: e }, N++, K(), U[G.idx].img === U[z.idx].img) { G.el.classList.add("danielamado_found"), z.el.classList.add("danielamado_found"), w++; const r = new CustomEvent("game-score", { detail: { game: "memory", delta: 10 } }); if (p.dispatchEvent(r), G = null, z = null, w === y) { let c = 0; if (I > 0) { c = Math.max(0, Math.floor(I)); const u = new CustomEvent("game-score", { detail: { game: "memory", delta: c } }); p.dispatchEvent(u) } n(), T.textContent = "¡Completaste la actividad!", V(w * 10 + c) } } else setTimeout(() => { ne(G.el), ne(z.el), G = null, z = null }, 1e3) } } function K() { const s = document.getElementById("danielamado_memMatches"), t = document.getElementById("danielamado_memMoves"); s && (s.textContent = `${w}/${y}`), t && (t.innerHTML = `Movimientos: <div>${N}</div>`) } function ee() { n(), I = S, M(), R = setInterval(() => { I--, M(), I <= 0 && (n(), T.textContent = "Tiempo agotado", V(w * 10)) }, 1e3) } function M() { const s = new CustomEvent("game-timer", { detail: { game: "memory", timeLeft: I } }); p.dispatchEvent(s) } function n() { R && (clearInterval(R), R = null) } $.addEventListener("click", re); function l() { G = null, z = null, w = 0, N = 0, T.textContent = "", Q(), K(), ee() } l() }) } } })(window); (function (p) { p.Games = p.Games || {}, p.Games.guessword = { start: function (f, L = {}) { return new Promise(V => { const S = L.timeLimit || 120, R = (L.questions && L.questions.length ? L.questions.slice() : [{ q: " ", a: "ACIDEZ GASTRICA" }, { q: " ", a: "PANTOPRAZOL" }, { q: " ", a: "SELECTIVIDAD" }, { q: " ", a: "IBP INNOVADOR" }, { q: " ", a: "DEXLANSOPRAZOL" }]).map(M => ({ q: M.q, a: String(M.a).toUpperCase() })); let I = null, N = S, w = 0, b = 0, j = 0; f.innerHTML = ""; const $ = document.createElement("h2"); $.textContent = "Completa las palabras"; const Z = document.createElement("p"); Z.textContent = "Incluye las letras que faltan, para completar las palabras asociadas a Inhibidores de Bomba de Protones"; const q = document.createElement("div"); q.className = "danielamado_gw-question"; const W = document.createElement("div"); W.className = "danielamado_gw-hint"; const E = document.createElement("div"); E.className = "danielamado_gw-input-row"; const A = document.createElement("input"); A.type = "text", A.placeholder = "Escribe tu respuesta aquí", A.id = "danielamado_gwAnswer"; const k = document.createElement("button"); k.textContent = "Responder", k.className = "danielamado_btn danielamado_btn-primary", k.setAttribute("aria-label", "Responder"); const T = document.createElement("button"); T.textContent = "Saltar", T.className = "danielamado_btn danielamado_btn-secondary", T.setAttribute("aria-label", "Saltar"); const H = document.createElement("div"); H.className = "danielamado_gw-controls", H.appendChild(k), H.appendChild(T), E.appendChild(A), E.appendChild(H); const B = document.createElement("div"); B.className = "danielamado_message", f.appendChild($), f.appendChild(Z), f.appendChild(q), f.appendChild(W), f.appendChild(E), f.appendChild(B); function Y(M) { return String(M || "").toUpperCase().replace(/\s+/g, "") } function U() { return Y(R[w].a) } function Q() { return R[w].q } function G() { q.innerHTML = ""; const M = document.createElement("div"); M.className = "danielamado_gw-progress", M.textContent = `Palabra ${w + 1}/${R.length}`; const n = document.createTextNode(`${Q()}`); q.appendChild(M), q.appendChild(n); const l = R[w].a, s = l.split(""), t = []; for (let d = 0; d < s.length; d++)s[d] !== " " && t.push(d); const e = Math.min(3, t.length); for (let d = t.length - 1; d > 0; d--) { const m = Math.floor(Math.random() * (d + 1)), v = t[d]; t[d] = t[m], t[m] = v } const r = new Set(t.slice(0, e)); for (let d = 0; d < s.length; d++)s[d] === " " || r.has(d), d < s.length - 1; W.innerHTML = ""; const c = document.createElement("div"); c.className = "danielamado_gw-hint-label", c.textContent = "Pista:", W.appendChild(c); const u = document.createElement("div"); u.className = "danielamado_gw-code"; for (let d = 0; d < s.length; d++) { const m = s[d]; if (m === " ") { const x = document.createElement("div"); x.className = "danielamado_gw-code-space", u.appendChild(x); continue } const v = document.createElement("div"); v.className = "danielamado_gw-code-box", r.has(d) ? (v.classList.add("danielamado_filled"), v.textContent = m) : v.textContent = "", u.appendChild(v) } W.appendChild(u); const h = document.createElement("div"); h.className = "danielamado_gw-remaining", h.textContent = `Letras faltantes: ${Y(l).length - r.size}`, W.appendChild(h), A.value = "", A.focus() } function z(M) { const n = new CustomEvent("game-score", { detail: { game: "guessword", delta: M } }); p.dispatchEvent(n), b += M } function te() { const M = Y(A.value), n = U(); if (!M) { B.textContent = "Escribe una respuesta."; return } if (M === n) { if (B.textContent = "Correcto! +10 puntos.", z(10), j++, w++, w >= R.length) { if (j > 0 && N > 0) { const l = Math.max(0, Math.floor(N)); z(l), B.textContent += ` Bonus +${l} por terminar antes del tiempo.` } else N > 0 && (B.textContent += " No se otorga bonus por terminar antes porque no respondiste correctamente ninguna pregunta."); K(), setTimeout(() => { V(b) }, 700); return } setTimeout(() => { B.textContent = "", G() }, 700) } else B.textContent = "Incorrecto. Intenta de nuevo." } function ne() { if (w++, w >= R.length) { if (j > 0 && N > 0) { const M = Math.max(0, Math.floor(N)); z(M), B.textContent = `Terminaste (con saltos). Bonus +${M} por terminar antes del tiempo.` } else N > 0 && (B.textContent = "Terminaste (con saltos). No se otorga bonus por terminar antes porque no respondiste correctamente ninguna pregunta."); K(), setTimeout(() => { V(b) }, 700); return } G() } k.addEventListener("click", te), A.addEventListener("keydown", M => { M.key === "Enter" && te() }), T.addEventListener("click", ne); function re() { K(), N = S, ee(), I = setInterval(() => { N--, ee(), N <= 0 && (K(), B.textContent = "Tiempo agotado", V(b)) }, 1e3) } function K() { I && (clearInterval(I), I = null) } function ee() { const M = new CustomEvent("game-timer", { detail: { game: "guessword", timeLeft: N } }); p.dispatchEvent(M) } G(), re() }) } } })(window); var ce = {}; (function p(f, L, V, S) {
          var y = !!(f.Worker && f.Blob && f.Promise && f.OffscreenCanvas && f.OffscreenCanvasRenderingContext2D && f.HTMLCanvasElement && f.HTMLCanvasElement.prototype.transferControlToOffscreen && f.URL && f.URL.createObjectURL), R = typeof Path2D == "function" && typeof DOMMatrix == "function", I = (function () { if (!f.OffscreenCanvas) return !1; try { var t = new OffscreenCanvas(1, 1), e = t.getContext("2d"); e.fillRect(0, 0, 1, 1); var r = t.transferToImageBitmap(); e.createPattern(r, "no-repeat") } catch { return !1 } return !0 })(); function N() { } function w(t) { var e = L.exports.Promise, r = e !== void 0 ? e : f.Promise; return typeof r == "function" ? new r(t) : (t(N, N), null) } var b = (function (t, e) { return { transform: function (r) { if (t) return r; if (e.has(r)) return e.get(r); var c = new OffscreenCanvas(r.width, r.height), u = c.getContext("2d"); return u.drawImage(r, 0, 0), e.set(r, c), c }, clear: function () { e.clear() } } })(I, new Map), j = (function () { var t = Math.floor(16.666666666666668), e, r, c = {}, u = 0; return typeof requestAnimationFrame == "function" && typeof cancelAnimationFrame == "function" ? (e = function (h) { var d = Math.random(); return c[d] = requestAnimationFrame(function m(v) { u === v || u + t - 1 < v ? (u = v, delete c[d], h()) : c[d] = requestAnimationFrame(m) }), d }, r = function (h) { c[h] && cancelAnimationFrame(c[h]) }) : (e = function (h) { return setTimeout(h, t) }, r = function (h) { return clearTimeout(h) }), { frame: e, cancel: r } })(), $ = (function () {
            var t, e, r = {}; function c(u) { function h(d, m) { u.postMessage({ options: d || {}, callback: m }) } u.init = function (m) { var v = m.transferControlToOffscreen(); u.postMessage({ canvas: v }, [v]) }, u.fire = function (m, v, x) { if (e) return h(m, null), e; var o = Math.random().toString(36).slice(2); return e = w(function (a) { function i(g) { g.data.callback === o && (delete r[o], u.removeEventListener("message", i), e = null, b.clear(), x(), a()) } u.addEventListener("message", i), h(m, o), r[o] = i.bind(null, { data: { callback: o } }) }), e }, u.reset = function () { u.postMessage({ reset: !0 }); for (var m in r) r[m](), delete r[m] } } return function () {
              if (t) return t; if (!V && y) {
                var u = ["var CONFETTI, SIZE = {}, module = {};", "(" + p.toString() + ")(this, module, true, SIZE);", "onmessage = function(msg) {", "  if (msg.data.options) {", "    CONFETTI(msg.data.options).then(function () {", "      if (msg.data.callback) {", "        postMessage({ callback: msg.data.callback });", "      }", "    });", "  } else if (msg.data.reset) {", "    CONFETTI && CONFETTI.reset();", "  } else if (msg.data.resize) {", "    SIZE.width = msg.data.resize.width;", "    SIZE.height = msg.data.resize.height;", "  } else if (msg.data.canvas) {", "    SIZE.width = msg.data.canvas.width;", "    SIZE.height = msg.data.canvas.height;", "    CONFETTI = module.exports.create(msg.data.canvas);", "  }", "}"].join(`
`); try { t = new Worker(URL.createObjectURL(new Blob([u]))) } catch (h) { return typeof console < "u" && typeof console.warn == "function" && console.warn("🎊 Could not load worker", h), null } c(t)
              } return t
            }
          })(), Z = { particleCount: 50, angle: 90, spread: 45, startVelocity: 45, decay: .9, gravity: 1, drift: 0, ticks: 200, x: .5, y: .5, shapes: ["square", "circle"], zIndex: 100, colors: ["#26ccff", "#a25afd", "#ff5e7e", "#88ff5a", "#fcff42", "#ffa62d", "#ff36ff"], disableForReducedMotion: !1, scalar: 1 }; function q(t, e) { return e ? e(t) : t } function W(t) { return t != null } function E(t, e, r) { return q(t && W(t[e]) ? t[e] : Z[e], r) } function A(t) { return t < 0 ? 0 : Math.floor(t) } function k(t, e) { return Math.floor(Math.random() * (e - t)) + t } function T(t) { return parseInt(t, 16) } function H(t) { return t.map(B) } function B(t) { var e = String(t).replace(/[^0-9a-f]/gi, ""); return e.length < 6 && (e = e[0] + e[0] + e[1] + e[1] + e[2] + e[2]), { r: T(e.substring(0, 2)), g: T(e.substring(2, 4)), b: T(e.substring(4, 6)) } } function Y(t) { var e = E(t, "origin", Object); return e.x = E(e, "x", Number), e.y = E(e, "y", Number), e } function U(t) { t.width = document.documentElement.clientWidth, t.height = document.documentElement.clientHeight } function Q(t) { var e = t.getBoundingClientRect(); t.width = e.width, t.height = e.height } function G(t) { var e = document.createElement("canvas"); return e.style.position = "fixed", e.style.top = "0px", e.style.left = "0px", e.style.pointerEvents = "none", e.style.zIndex = t, e } function z(t, e, r, c, u, h, d, m, v) { t.save(), t.translate(e, r), t.rotate(h), t.scale(c, u), t.arc(0, 0, 1, d, m, v), t.restore() } function te(t) { var e = t.angle * (Math.PI / 180), r = t.spread * (Math.PI / 180); return { x: t.x, y: t.y, wobble: Math.random() * 10, wobbleSpeed: Math.min(.11, Math.random() * .1 + .05), velocity: t.startVelocity * .5 + Math.random() * t.startVelocity, angle2D: -e + (.5 * r - Math.random() * r), tiltAngle: (Math.random() * (.75 - .25) + .25) * Math.PI, color: t.color, shape: t.shape, tick: 0, totalTicks: t.ticks, decay: t.decay, drift: t.drift, random: Math.random() + 2, tiltSin: 0, tiltCos: 0, wobbleX: 0, wobbleY: 0, gravity: t.gravity * 3, ovalScalar: .6, scalar: t.scalar, flat: t.flat } } function ne(t, e) { e.x += Math.cos(e.angle2D) * e.velocity + e.drift, e.y += Math.sin(e.angle2D) * e.velocity + e.gravity, e.velocity *= e.decay, e.flat ? (e.wobble = 0, e.wobbleX = e.x + 10 * e.scalar, e.wobbleY = e.y + 10 * e.scalar, e.tiltSin = 0, e.tiltCos = 0, e.random = 1) : (e.wobble += e.wobbleSpeed, e.wobbleX = e.x + 10 * e.scalar * Math.cos(e.wobble), e.wobbleY = e.y + 10 * e.scalar * Math.sin(e.wobble), e.tiltAngle += .1, e.tiltSin = Math.sin(e.tiltAngle), e.tiltCos = Math.cos(e.tiltAngle), e.random = Math.random() + 2); var r = e.tick++ / e.totalTicks, c = e.x + e.random * e.tiltCos, u = e.y + e.random * e.tiltSin, h = e.wobbleX + e.random * e.tiltCos, d = e.wobbleY + e.random * e.tiltSin; if (t.fillStyle = "rgba(" + e.color.r + ", " + e.color.g + ", " + e.color.b + ", " + (1 - r) + ")", t.beginPath(), R && e.shape.type === "path" && typeof e.shape.path == "string" && Array.isArray(e.shape.matrix)) t.fill(n(e.shape.path, e.shape.matrix, e.x, e.y, Math.abs(h - c) * .1, Math.abs(d - u) * .1, Math.PI / 10 * e.wobble)); else if (e.shape.type === "bitmap") { var m = Math.PI / 10 * e.wobble, v = Math.abs(h - c) * .1, x = Math.abs(d - u) * .1, o = e.shape.bitmap.width * e.scalar, a = e.shape.bitmap.height * e.scalar, i = new DOMMatrix([Math.cos(m) * v, Math.sin(m) * v, -Math.sin(m) * x, Math.cos(m) * x, e.x, e.y]); i.multiplySelf(new DOMMatrix(e.shape.matrix)); var g = t.createPattern(b.transform(e.shape.bitmap), "no-repeat"); g.setTransform(i), t.globalAlpha = 1 - r, t.fillStyle = g, t.fillRect(e.x - o / 2, e.y - a / 2, o, a), t.globalAlpha = 1 } else if (e.shape === "circle") t.ellipse ? t.ellipse(e.x, e.y, Math.abs(h - c) * e.ovalScalar, Math.abs(d - u) * e.ovalScalar, Math.PI / 10 * e.wobble, 0, 2 * Math.PI) : z(t, e.x, e.y, Math.abs(h - c) * e.ovalScalar, Math.abs(d - u) * e.ovalScalar, Math.PI / 10 * e.wobble, 0, 2 * Math.PI); else if (e.shape === "star") for (var C = Math.PI / 2 * 3, _ = 4 * e.scalar, F = 8 * e.scalar, D = e.x, O = e.y, J = 5, P = Math.PI / J; J--;)D = e.x + Math.cos(C) * F, O = e.y + Math.sin(C) * F, t.lineTo(D, O), C += P, D = e.x + Math.cos(C) * _, O = e.y + Math.sin(C) * _, t.lineTo(D, O), C += P; else t.moveTo(Math.floor(e.x), Math.floor(e.y)), t.lineTo(Math.floor(e.wobbleX), Math.floor(u)), t.lineTo(Math.floor(h), Math.floor(d)), t.lineTo(Math.floor(c), Math.floor(e.wobbleY)); return t.closePath(), t.fill(), e.tick < e.totalTicks } function re(t, e, r, c, u) { var h = e.slice(), d = t.getContext("2d"), m, v, x = w(function (o) { function a() { m = v = null, d.clearRect(0, 0, c.width, c.height), b.clear(), u(), o() } function i() { V && !(c.width === S.width && c.height === S.height) && (c.width = t.width = S.width, c.height = t.height = S.height), !c.width && !c.height && (r(t), c.width = t.width, c.height = t.height), d.clearRect(0, 0, c.width, c.height), h = h.filter(function (g) { return ne(d, g) }), h.length ? m = j.frame(i) : a() } m = j.frame(i), v = a }); return { addFettis: function (o) { return h = h.concat(o), x }, canvas: t, promise: x, reset: function () { m && j.cancel(m), v && v() } } } function K(t, e) { var r = !t, c = !!E(e || {}, "resize"), u = !1, h = E(e, "disableForReducedMotion", Boolean), d = y && !!E(e || {}, "useWorker"), m = d ? $() : null, v = r ? U : Q, x = t && m ? !!t.__confetti_initialized : !1, o = typeof matchMedia == "function" && matchMedia("(prefers-reduced-motion)").matches, a; function i(C, _, F) { for (var D = E(C, "particleCount", A), O = E(C, "angle", Number), J = E(C, "spread", Number), P = E(C, "startVelocity", Number), ae = E(C, "decay", Number), X = E(C, "gravity", Number), oe = E(C, "drift", Number), ie = E(C, "colors", H), le = E(C, "ticks", Number), se = E(C, "shapes"), fe = E(C, "scalar"), he = !!E(C, "flat"), me = Y(C), ue = D, de = [], ge = t.width * me.x, ve = t.height * me.y; ue--;)de.push(te({ x: ge, y: ve, angle: O, spread: J, startVelocity: P, color: ie[ue % ie.length], shape: se[k(0, se.length)], ticks: le, decay: ae, gravity: X, drift: oe, scalar: fe, flat: he })); return a ? a.addFettis(de) : (a = re(t, de, v, _, F), a.promise) } function g(C) { var _ = h || E(C, "disableForReducedMotion", Boolean), F = E(C, "zIndex", Number); if (_ && o) return w(function (P) { P() }); r && a ? t = a.canvas : r && !t && (t = G(F), document.body.appendChild(t)), c && !x && v(t); var D = { width: t.width, height: t.height }; m && !x && m.init(t), x = !0, m && (t.__confetti_initialized = !0); function O() { if (m) { var P = { getBoundingClientRect: function () { if (!r) return t.getBoundingClientRect() } }; v(P), m.postMessage({ resize: { width: P.width, height: P.height } }); return } D.width = D.height = null } function J() { a = null, c && (u = !1, f.removeEventListener("resize", O)), r && t && (document.body.contains(t) && document.body.removeChild(t), t = null, x = !1) } return c && !u && (u = !0, f.addEventListener("resize", O, !1)), m ? m.fire(C, D, J) : i(C, D, J) } return g.reset = function () { m && m.reset(), a && a.reset() }, g } var ee; function M() { return ee || (ee = K(null, { useWorker: !0, resize: !0 })), ee } function n(t, e, r, c, u, h, d) { var m = new Path2D(t), v = new Path2D; v.addPath(m, new DOMMatrix(e)); var x = new Path2D; return x.addPath(v, new DOMMatrix([Math.cos(d) * u, Math.sin(d) * u, -Math.sin(d) * h, Math.cos(d) * h, r, c])), x } function l(t) { if (!R) throw new Error("path confetti are not supported in this browser"); var e, r; typeof t == "string" ? e = t : (e = t.path, r = t.matrix); var c = new Path2D(e), u = document.createElement("canvas"), h = u.getContext("2d"); if (!r) { for (var d = 1e3, m = d, v = d, x = 0, o = 0, a, i, g = 0; g < d; g += 2)for (var C = 0; C < d; C += 2)h.isPointInPath(c, g, C, "nonzero") && (m = Math.min(m, g), v = Math.min(v, C), x = Math.max(x, g), o = Math.max(o, C)); a = x - m, i = o - v; var _ = 10, F = Math.min(_ / a, _ / i); r = [F, 0, 0, F, -Math.round(a / 2 + m) * F, -Math.round(i / 2 + v) * F] } return { type: "path", path: e, matrix: r } } function s(t) { var e, r = 1, c = "#000000", u = '"Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji", "EmojiOne Color", "Android Emoji", "Twemoji Mozilla", "system emoji", sans-serif'; typeof t == "string" ? e = t : (e = t.text, r = "scalar" in t ? t.scalar : r, u = "fontFamily" in t ? t.fontFamily : u, c = "color" in t ? t.color : c); var h = 10 * r, d = "" + h + "px " + u, m = new OffscreenCanvas(h, h), v = m.getContext("2d"); v.font = d; var x = v.measureText(e), o = Math.ceil(x.actualBoundingBoxRight + x.actualBoundingBoxLeft), a = Math.ceil(x.actualBoundingBoxAscent + x.actualBoundingBoxDescent), i = 2, g = x.actualBoundingBoxLeft + i, C = x.actualBoundingBoxAscent + i; o += i + i, a += i + i, m = new OffscreenCanvas(o, a), v = m.getContext("2d"), v.font = d, v.fillStyle = c, v.fillText(e, g, C); var _ = 1 / r; return { type: "bitmap", bitmap: m.transferToImageBitmap(), matrix: [_, 0, 0, _, -o * _ / 2, -a * _ / 2] } } L.exports = function () { return M().apply(this, arguments) }, L.exports.reset = function () { M().reset() }, L.exports.create = K, L.exports.shapeFromPath = l, L.exports.shapeFromText = s
        })((function () { return typeof window < "u" ? window : typeof self < "u" ? self : this || {} })(), ce, !1); const pe = ce.exports; ce.exports.create; (function (p) {
          const f = document.getElementById("danielamado_gameArea"), L = document.getElementById("danielamado_startBtn"), V = document.getElementById("danielamado_emailInput"), S = document.getElementById("danielamado_playerEmail"), y = document.getElementById("danielamado_totalPoints"), R = document.getElementById("danielamado_timeLeft"), I = document.getElementById("danielamado_globalMessage"), N = document.getElementById("danielamado_intro"), w = document.querySelector(".danielamado_email-row"); p.App = p.App || {}, p.App.pointsStore = p.App.pointsStore || {}; const b = "games_progress"; function j() { try { const n = localStorage.getItem(b); return n ? JSON.parse(n) || {} : {} } catch (n) { return console.warn("Could not read progress from localStorage:", n), {} } } function $(n) { try { localStorage.setItem(b, JSON.stringify(n || {})) } catch (l) { console.warn("Could not write progress to localStorage:", l) } } function Z(n) { return n && j()[n] || null } async function q(n, l, s, t) { if (!n) return; const e = "https://market-support.com/api/apps/adium/foro2025/receive_score.php", r = { email: String(n), puntaje: Number(l) || 0, ultimo: !!s, user_id: t || null }; try { await fetch(e, { method: "POST", headers: { "Content-Type": "application/json" }, keepalive: !0, body: JSON.stringify(r) }), console.info("Score sent", r) } catch (c) { console.warn("Could not send score to endpoint:", c, r), setTimeout(() => { try { fetch(e, { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(r) }).then(() => console.info("Retry score sent", r)).catch(() => { }) } catch { } }, 1200) } } function W(n, l) { if (!n) return; const s = j(); s[n] = l || null, $(s) } let E = null, A = null, k = !1, T = null, H = null; const B = "/api/user/email"; function Y(n) { if (typeof n != "string") return null; const l = n.trim().toLowerCase(); return l.includes("@") ? l : null } function U(n, { persist: l = !1 } = {}) { const s = Y(n); if (!s) return !1; if (E = s, l) try { localStorage.setItem("login_user_email", s) } catch (t) { console.warn("No se pudo guardar el email en localStorage:", t) } if (S && (S.textContent = s), y && (y.textContent = p.App.pointsStore[s] || 0), w && (w.style.display = "none"), !k) { const t = document.getElementById("gameStartBanner"); t && (t.remove(), M()) } return !0 } function Q() { const n = p.App && p.App.emailLookupPath; if (typeof n == "string" && n.trim()) { const l = n.trim(); if (!l.includes("<"+"?=")) return l } return B } function G(n) { if (!n) return null; if (/^https?:\/\//i.test(n)) return n; const l = n.charAt(0) === "/"; return p.location.origin + (l ? n : `/${n}`) } function z() { if (H) return H; const n = Q(), l = G(n); return l ? (H = fetch(l, { credentials: "same-origin" }).then(s => !s || !s.ok ? null : s.json()).then(s => !s || !s.email ? !1 : U(s.email, { persist: !0 })).catch(s => (console.warn("No se pudo obtener email desde API:", s), !1)).finally(() => { H = null }), H) : Promise.resolve(!1) } try { const n = localStorage.getItem("login_user_email"); n && U(n) } catch (n) { console.warn("localStorage unavailable:", n) } if (!E) { const n = () => { z().then(l => { !l && w && (w.style.display = "") }) }; document.readyState === "loading" ? document.addEventListener("DOMContentLoaded", n, { once: !0 }) : n() } try { const n = localStorage.getItem("user_info"); if (n) { const l = JSON.parse(n); l && l.uuid && (A = String(l.uuid)) } } catch { } function te(n) { const l = Math.floor(n / 60).toString().padStart(2, "0"), s = (n % 60).toString().padStart(2, "0"); return `${l}:${s}` } p.addEventListener("game-timer", n => { const l = n.detail || {}; if (!l.game || l.game !== T) return; const s = l.timeLeft; R.textContent = te(s) }), p.addEventListener("game-score", n => { const l = n.detail || {}, s = Number(l.delta) || 0, t = E; if (!t) return; const r = (p.App.pointsStore[t] || 0) + s; p.App.pointsStore[t] = r, y.textContent = r }); async function ne() { k = !0, N.style.display = "none", I.textContent = ""; const n = E; p.App.pointsStore[n]; async function l(g, C, _) { if (!p.Games || !p.Games[g] || typeof p.Games[g].start != "function") return I.textContent = `Modulo de juego "${g}" no disponible.`, await new Promise(F => setTimeout(F, 700)), 0; try { return await p.Games[g].start(C, _ || {}) || 0 } catch (F) { return console.error(`Error ejecutando juego ${g}:`, F), I.textContent = `Error en el juego ${g}: ${F.message || F}`, 0 } } function s(g, C, _, F) { return new Promise(D => { f.innerHTML = ""; const O = document.createElement("div"); O.className = "danielamado_interstitial-banner"; const J = document.createElement("h3"); J.textContent = `Fin de ${g}`, O.appendChild(J); const P = document.createElement("p"); P.className = "danielamado_interstitial-points", P.textContent = `Puntos obtenidos: ${C >= 0 ? "+" + C : C}`, O.appendChild(P); const ae = document.createElement("p"); ae.className = "danielamado_interstitial-next", ae.textContent = `Siguiente: ${_} — ${F}`, O.appendChild(ae); const X = document.createElement("button"); X.className = "danielamado_interstitial-start-btn danielamado_btn_accent", X.textContent = "Comenzar la siguiente actividad", X.addEventListener("click", () => { O.remove(), D() }), O.appendChild(X), f.appendChild(O) }) } I.textContent = "Actividad 1: Sopa de letras", f.innerHTML = ""; const t = document.createElement("div"); t.className = "danielamado_game_card_wordsearch danielamado_game_container", f.appendChild(t), T = "wordsearch"; const e = p.App.pointsStore[n] || 0; await l("wordsearch", t, { timeLimit: 300 }), T = null; const c = (p.App.pointsStore[n] || 0) - e; try { q(n, c, !1, A) } catch (g) { console.warn("sendScoreToEndpoint error (wordsearch):", g) } await s("Sopa de letras", c, "actividad de Parejas", "Encuentra las parejas girando las cartas."), I.textContent = "Actividad 2: Encuentra las parejas", f.innerHTML = ""; const u = document.createElement("div"); u.className = "danielamado_game_card_memory danielamado_game_container", f.appendChild(u), T = "memory"; const h = p.App.pointsStore[n] || 0; await l("memory", u, { timeLimit: 120, pairs: 8 }), T = null; const m = (p.App.pointsStore[n] || 0) - h; try { q(n, m, !1, A) } catch (g) { console.warn("sendScoreToEndpoint error (memory):", g) } await s("Parejas", m, "Completa las palabras", "Completa las palabras correctas leyendo la pista antes de que se acabe el tiempo."), I.textContent = "Juego 3: Completa las palabras", f.innerHTML = ""; const v = document.createElement("div"); v.className = "danielamado_game_card_guessword danielamado_game_container", f.appendChild(v), T = "guessword"; const x = p.App.pointsStore[n] || 0; await l("guessword", v, { timeLimit: 120 }); const a = (p.App.pointsStore[n] || 0) - x; try { q(n, a, !0, A) } catch (g) { console.warn("sendScoreToEndpoint error (guessword final):", g) } T = null, k = !1; const i = p.App.pointsStore[n] || 0; try { W(n, { completed: !0, score: i, timestamp: new Date().toISOString() }), L && (L.style.display = "none"), f && (f.innerHTML = ""); const g = document.getElementById("gameStartBanner"); g && g.remove(), M(); try { typeof pe == "function" && pe({ particleCount: 100, spread: 100, origin: { y: .6 } }) } catch (C) { console.warn("confetti error:", C) } } catch (g) { console.warn("Could not save completion state:", g) } } const re = document.getElementById("danielamado_endBannerOverlay"); document.getElementById("danielamado_endScore"); const K = document.getElementById("danielamado_closeBannerBtn"); function ee() { re && re.setAttribute("aria-hidden", "true") } function M() {
            if (!f) return null; const n = document.getElementById("gameStartBanner"); if (n) return n; const l = document.createElement("div"); l.id = "gameStartBanner", l.className = "danielamado_game-start-banner"; const s = E ? Z(E) : null; if (s && s.completed) {
              N.style.display = "none", l.innerHTML = `
        <div class="game-start-card" style="background:#fff;padding:18px;border-radius:8px;max-width:560px;margin:20px auto;text-align:center;">
          <h3>Actividades completadas</h3>
          <p>Ya completaste las actividades</p>
          <div>Puntaje final:</div>
          <div id="startBannerScore">${s.score}</div>
          <div style="margin-top:12px;">
          <p style="font-size: 18px;">recuerda volver al en vivo</p>
          </div>
        </div>
      `, f.appendChild(l); const e = l.querySelector("#goLiveBtn"); return e && e.addEventListener("click", () => { const r = p.App && p.App.liveUrl || "/en-vivo"; try { p.location.href = r } catch { p.dispatchEvent(new CustomEvent("go-live", { detail: { url: r } })) } }), L && (L.style.display = "none"), l
            } l.innerHTML = `
      <div class="game-start-card" style="background:#fff;padding:18px;border-radius:8px;max-width:560px;margin:20px auto;text-align:center;">
        <div>
          <button id="gameStartBtn" class="danielamado_btn danielamado_btn-primary">Empezar</button>
        </div>
      </div>
    `, f.appendChild(l); const t = l.querySelector("#gameStartBtn"); return t && t.addEventListener("click", () => { l.remove(), L && L.click() }), l
          } K && K.addEventListener("click", () => { ee() }), M(), L.addEventListener("click", () => { let n = E; if (!n) { if (n = (V.value || "").trim(), !n || !n.includes("@")) { I.textContent = "Introduce un email válido"; return } E = n } S && (S.textContent = n), y && (y.textContent = p.App.pointsStore[n] || 0); const l = Z(n); if (l && l.completed) { const s = document.getElementById("gameStartBanner"); s && s.remove(), M(); return } ne() }), E && !k && (document.getElementById("gameStartBanner") !== null || setTimeout(() => { k || ne() }, 50))
        })(window)
      }); export default Ee();</script>
  <style rel="stylesheet" crossorigin>
    :root {
      --corp-gray: #747d84;
      --corp-red: #ff0032;
      --white: #ffffff;
      --bg: #747d84;
      --card: var(--white);
      --accent: var(--corp-red);
      --found: #ff0032
    }

    .danielamado_body {
      font-family: Segoe UI, Roboto, Arial, sans-serif;
      background: var(--bg);
      color: #000;
      min-height: 100vh;
      margin: 0;
      line-height: 1.2 !important;
      font-size: 18px;
      padding: 20px 10px
    }

    .danielamado_body a {
      text-decoration: none
    }

    .danielamado_body a:hover {
      color: var(--white) !important
    }

    .danielamado_body * {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    .danielamado_container {
      max-width: 980px;
      margin: 0 auto;
      padding: 18px;
      background: var(--card);
      border-radius: 12px
    }

    .danielamado_player-email {
      font-weight: 700;
      color: var(--white)
    }

    .danielamado_top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 12px;
      border-radius: 10px;
      background: var(--corp-gray)
    }

    .danielamado_top h2 {
      margin: 0;
      color: var(--white);
      font-size: 20px
    }

    .danielamado_meta {
      display: flex;
      gap: 12px;
      align-items: center
    }

    .danielamado_panel_info_header {
      display: flex;
      flex-direction: column;
      padding: 8px 20px;
      font-weight: 700;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      background: var(--card)
    }

    .danielamado_intro {
      max-width: 600px;
      margin: 0 auto;
      padding: 32px 16px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px
    }

    #danielamado_intro>p {
      font-size: 22px;
      font-weight: 600;
      text-align: center;
      flex-wrap: balance
    }

    .danielamado_countdown small {
      display: block;
      font-size: 11px;
      color: var(--corp-gray);
      margin-bottom: 6px
    }

    #danielamado_timeLeft,
    #danielamado_totalPoints,
    .danielamado_mem-moves div,
    .danielamado_mem-matches,
    .danielamado_wordsearch_founds_and_total,
    .danielamado_interstitial-points {
      font-weight: 800;
      color: var(--accent);
      font-size: 32px;
      line-height: 1.2
    }

    .danielamado_email-row {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-top: 8px;
      width: 100%
    }

    #danielamado_emailInput {
      text-align: center;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 18px
    }

    #danielamado_startBtn {
      background: var(--accent);
      color: #fff;
      padding: 10px 14px;
      border-radius: 8px;
      border: 0;
      cursor: pointer;
      font-weight: 700
    }

    .danielamado_game-area {
      margin-top: 16px
    }

    .danielamado_game_container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px
    }

    .danielamado_game_wordsearch {
      display: flex;
      gap: 18px;
      align-items: flex-start;
      justify-content: center;
      width: 100%
    }

    .danielamado_grid {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      grid-auto-rows: 40px;
      gap: 5px;
      width: 100%;
      max-width: 550px;
      padding: 8px;
      background: var(--corp-gray);
      border-radius: 8px
    }

    .danielamado_cell {
      max-width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--card);
      border-radius: 6px;
      cursor: pointer;
      -webkit-user-select: none;
      user-select: none;
      font-weight: 700;
      font-size: 16px
    }

    .danielamado_cell.danielamado_selecting {
      background: var(--corp-red)
    }

    .danielamado_cell.danielamado_found {
      background: var(--found);
      color: #fff;
      cursor: default
    }

    .danielamado_sidebar {
      width: 260px
    }

    .danielamado_word-list {
      list-style: none;
      padding: 0;
      margin: 0 0 12px
    }

    .danielamado_word-list li {
      padding: 6px 8px;
      border-radius: 6px;
      margin: 6px 0;
      background: var(--corp-red);
      color: #fff;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 18px
    }

    .danielamado_word-list li.danielamado_found {
      opacity: .6;
      text-decoration: line-through;
      background: var(--corp-gray)
    }

    .danielamado_status {
      margin-bottom: 12px;
      font-weight: 600;
      font-size: 18px;
      display: flex;
      flex-direction: column;
      align-items: center
    }

    .danielamado_game_card_wordsearch>p {
      font-size: 18px
    }

    .danielamado_memory-board {
      display: grid;
      gap: 8px;
      margin: 12px 0;
      max-width: 600px;
      width: 100%;
      justify-content: center;
      grid-template-columns: repeat(4, 80px)
    }

    .danielamado_memory_status_wrap {
      display: flex;
      flex-direction: column;
      gap: 12px;
      align-items: center;
      justify-content: center
    }

    .danielamado_mem-moves {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center
    }

    .danielamado_mem-card {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      border: 1px solid #ddd;
      background: var(--card);
      cursor: pointer;
      font-weight: 700;
      position: relative;
      overflow: hidden;
      padding: 0
    }

    .danielamado_mem-card.danielamado_flipped {
      background: #e8f7f6
    }

    .danielamado_mem-card.danielamado_found {
      background: #dff0d8;
      opacity: .9
    }

    .danielamado_flip-card-inner {
      width: 100%;
      height: 100%;
      transition: transform .6s;
      transform-style: preserve-3d;
      position: relative
    }

    .danielamado_flip-card-inner.danielamado_is-flipped {
      transform: rotateY(180deg)
    }

    .danielamado_flip-card-front,
    .danielamado_flip-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      backface-visibility: hidden;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center
    }

    .danielamado_flip-card-front {
      background: linear-gradient(135deg, #f6f9f9, #e6f1f0)
    }

    .danielamado_flip-card-back {
      transform: rotateY(180deg);
      background: var(--card)
    }

    .danielamado_flip-card-back img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 8px;
      display: block
    }

    .danielamado_interstitial-banner {
      margin: 20px auto;
      padding: 16px 20px;
      max-width: 500px;
      border-radius: 10px;
      text-align: center;
      font-weight: 700;
      font-size: 19px
    }

    .danielamado_interstitial-points {
      color: var(--accent);
      font-size: 32px
    }

    .danielamado_interstitial-next {
      margin-top: 12px;
      padding: 10px 14px;
      color: #454545;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 700;
      font-size: 16px
    }

    .danielamado_message {
      background: var(--corp-red);
      color: var(--white);
      text-align: center;
      font-weight: 700;
      font-size: 16px;
      margin-top: 14px;
      padding: 10px;
      border-radius: 8px
    }

    .danielamado_end-banner-overlay {
      position: fixed;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      background: #0000007a;
      z-index: 9999
    }

    .danielamado_end-banner-overlay[aria-hidden=false] {
      display: flex
    }

    .danielamado_end-banner {
      background: var(--card);
      padding: 24px 28px;
      border-radius: 12px;
      text-align: center;
      max-width: 420px;
      width: calc(100% - 48px);
      box-shadow: 0 12px 40px #00000047
    }

    .danielamado_end-banner h2 {
      margin: 0 0 8px;
      font-size: 22px;
      color: var(--corp-gray)
    }

    .danielamado_end-score {
      font-size: 19px;
      margin: 8px 0 12px;
      color: var(--accent);
      font-weight: 800
    }

    .danielamado_end-actions {
      display: flex;
      gap: 10px;
      justify-content: center
    }

    .danielamado_end-actions button {
      padding: 8px 12px;
      font-weight: 700;
      border-radius: 8px;
      border: 0;
      cursor: pointer
    }

    .danielamado_end-actions #danielamado_playAgainBtn {
      background: var(--accent);
      color: #fff
    }

    .danielamado_btn_accent {
      background: var(--accent);
      color: #fff;
      font-size: 22px;
      font-weight: 700;
      padding: 10px 14px;
      border-radius: 8px;
      border: 0;
      cursor: pointer
    }

    .danielamado_gw-question {
      font-size: 28px;
      font-weight: 800;
      color: var(--corp-gray);
      text-align: center;
      margin-top: 6px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 8px
    }

    .danielamado_gw-hint {
      font-size: 36px;
      font-weight: 900;
      text-align: center;
      margin-top: 10px;
      letter-spacing: 8px;
      font-family: Courier New, Courier, monospace;
      color: #222
    }

    .danielamado_gw-hint-label {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 8px;
      color: var(--corp-gray)
    }

    .danielamado_gw-code {
      display: flex;
      gap: 10px;
      justify-content: center;
      align-items: center;
      margin-top: 6px
    }

    #danielamado_gameArea>div>h2 {
      font-size: 20px;
      color: var(--corp-gray)
    }

    .danielamado_gw-code-box {
      width: 56px;
      height: 56px;
      border: 2px solid #e6e6e6;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      font-weight: 900;
      text-transform: uppercase;
      background: #fff;
      color: #222
    }

    .danielamado_gw-code-box.danielamado_filled {
      border-color: var(--accent);
      box-shadow: 0 6px 18px #ff003214;
      color: var(--accent)
    }

    .danielamado_gw-code-space {
      width: 18px;
      height: 56px
    }

    .danielamado_gw-remaining {
      margin-top: 8px;
      font-size: 16px;
      color: var(--corp-gray);
      font-weight: 700
    }

    .danielamado_gw-input-row {
      display: flex;
      flex-direction: column;
      gap: 12px;
      justify-content: center;
      align-items: center;
      margin-top: 12px
    }

    .danielamado_gw-controls {
      display: flex;
      gap: 10px;
      align-items: center
    }

    #danielamado_gwAnswer {
      font-size: 20px;
      padding: 10px 12px;
      border-radius: 8px;
      border: 1px solid var(--corp-red);
      width: 460px;
      max-width: 90%;
      text-transform: uppercase;
      text-align: center
    }

    .danielamado_btn {
      padding: 10px 18px;
      border-radius: 10px;
      border: 0;
      cursor: pointer;
      font-weight: 800;
      font-size: 24px;
      transition: transform .08s ease, box-shadow .12s ease, opacity .12s ease
    }

    .danielamado_btn-primary {
      background: var(--accent);
      color: #fff
    }

    .danielamado_btn-secondary {
      background: #f4f4f4;
      color: #333;
      box-shadow: 0 6px 14px #0000000f
    }

    .danielamado_btn:active {
      transform: translateY(1px) scale(.996)
    }

    .danielamado_message {
      font-size: 18px;
      padding: 12px
    }

    .danielamado_gw-progress {
      display: inline-block;
      background: #ff003214;
      color: var(--accent);
      font-weight: 900;
      padding: 4px 10px;
      border-radius: 8px;
      margin: 0 8px;
      font-size: 22px
    }

    #startBannerScore {
      color: var(--accent);
      font-size: 38px;
      font-weight: 800;
      display: block
    }

    @media(max-width:600px) {
      .danielamado_top {
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 10px
      }

      .danielamado_top h2 {
        text-align: center
      }

      .danielamado_meta {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: column
      }

      .danielamado_game_wordsearch {
        flex-direction: column;
        align-items: center
      }

      .danielamado_gw-controls {
        flex-direction: row;
        gap: 8px
      }

      .danielamado_gw-hint {
        font-size: 28px;
        letter-spacing: 4px
      }

      .danielamado_gw-question {
        font-size: 20px
      }

      #danielamado_gwAnswer {
        font-size: 18px
      }

      .danielamado_btn {
        font-size: 16px;
        padding: 8px 12px
      }

      .danielamado_gw-code {
        flex-wrap: wrap
      }

      .danielamado_gw-code-box {
        width: 40px;
        height: 40px;
        font-size: 20px
      }

      .danielamado_gw-code-space {
        height: 40px
      }

      .danielamado_container {
        padding: 8px
      }
    }
  </style>

  <div class="danielamado_body">

    <!-- Start banner will be rendered inside the game area by the JS -->
    <!-- End banner overlay (hidden until game end) -->
    <div id="danielamado_endBannerOverlay" class="danielamado_end-banner-overlay" aria-hidden="true">
      <div class="danielamado_end-banner" role="dialog" aria-modal="true">
        <h2 id="danielamado_endBannerTitle">Actividad terminada!</h2>
        <p class="danielamado_end-score">Tu puntaje: <strong id="danielamado_endScore">-</strong></p>
        <div class="danielamado_end-actions">
          <p style="font-size: 18px;">recuerda volver al en vivo</p>
        </div>
      </div>
    </div>
    <main class="danielamado_container">
      <header class="danielamado_top">
        <h2>Actividades</h2>
        <div class="danielamado_meta">
          <div id="danielamado_playerEmail" class="danielamado_player-email">
            No registrado
          </div>
          <div id="danielamado_scoreBoard" class="danielamado_score-board danielamado_panel_info_header">Puntos:
            <span id="danielamado_totalPoints">-</span>
          </div>
          <div id="danielamado_countdown" class="danielamado_countdown danielamado_panel_info_header">Tiempo:
            <span id="danielamado_timeLeft">--:--</span>
          </div>
        </div>
      </header>

      <section id="danielamado_intro" class="danielamado_intro">
        <p>Suma puntos con las actividades interactivas</p>
        <ul
          style="font-size:18px; text-align: center; max-width: 400px; margin: 0 auto 1em auto; display: flex; flex-direction: column; gap: 0.5em; list-style-type: none;">
          <li>La actividad pasará automáticamente a la siguiente después de
            ganar o agotar el tiempo.</li>
          <li>Ganaras puntos segun completes cada actividad.</li>
          <li>Si completas la actividad antes de que se acabe el tiempo, ganaras puntos extra segun el tiempo restante.
          </li>
        </ul>
        <div class="danielamado_email-row">
          <input id="danielamado_emailInput" type="email" placeholder="tu@correo.com" />
          <button id="danielamado_startBtn">Comenzar</button>
        </div>
      </section>
      <div id="danielamado_globalMessage" class="danielamado_message" aria-live="polite"></div>

      <section id="danielamado_gameArea" class="danielamado_game-area">
        <!-- Cada juego inyectará su interfaz aquí -->
      </section>

    </main>

    <!-- Scripts separados por juego -->

  </div>

</body>

</html>

<?= $this->endSection() ?>
