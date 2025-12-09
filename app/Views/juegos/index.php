<?= $this->extend('layouts/dashboardLayout') ?>

<?= $this->section('content') ?>
<script type="module"
  crossorigin>
  var Ce = (u, d) => () => (d || u((d = {
    exports: {}
  }).exports, d), d.exports);
  var Ee = Ce((be, ce) => {
    (function() {
      const d = document.createElement("link").relList;
      if (d && d.supports && d.supports("modulepreload")) return;
      for (const _ of document.querySelectorAll('link[rel="modulepreload"]')) V(_);
      new MutationObserver(_ => {
        for (const E of _)
          if (E.type === "childList")
            for (const k of E.addedNodes) k.tagName === "LINK" && k.rel === "modulepreload" && V(k)
      }).observe(document, {
        childList: !0,
        subtree: !0
      });

      function w(_) {
        const E = {};
        return _.integrity && (E.integrity = _.integrity), _.referrerPolicy && (E.referrerPolicy = _.referrerPolicy), _.crossOrigin === "use-credentials" ? E.credentials = "include" : _.crossOrigin === "anonymous" ? E.credentials = "omit" : E.credentials = "same-origin", E
      }

      function V(_) {
        if (_.ep) return;
        _.ep = !0;
        const E = w(_);
        fetch(_.href, E)
      }
    })();
    (function(u) {
      u.Games = u.Games || {}, u.Games.wordsearch = {
        start: function(d, w = {}) {
          return new Promise(V => {
            const _ = ["INTESTINAL", "SEGURIDAD", "EFICACIA", "BAJOVOLUMEN", "PREPARACION", "COLONOSCOPIA", "LIMALIMON", "CEREZA"],
              E = w.size || 12,
              k = w.timeLimit || 120;
            let I = [],
              P = [],
              A = !1,
              S = [],
              F = null,
              H = !1,
              J = null,
              G = k;
            d.innerHTML = "";
            const z = document.createElement("h2");
            z.textContent = "Sopa de letras";
            const g = document.createElement("p");
            g.textContent = "Encuentra las palabras clave, relacionadas con la eficaz limpieza intestinal y la preparación de Bajo Volumen para la Colonoscopia. Selecciona con click o touch y arrastre.";
            const N = document.createElement("div");
            N.className = "danielamado_grid";
            const j = document.createElement("aside");
            j.className = "danielamado_sidebar";
            const L = document.createElement("ul");
            L.className = "danielamado_word-list";
            const Q = document.createElement("div");
            Q.className = "danielamado_status";
            const B = document.createElement("span");
            B.id = "danielamado_wsFound";
            const X = document.createElement("span");
            X.id = "danielamado_wsTotal";
            const $ = document.createElement("span");
            $.className = "danielamado_ws-label", $.textContent = "Palabras encontradas:", Q.appendChild($);
            const ne = document.createElement("div");
            ne.className = "danielamado_wordsearch_founds_and_total", ne.appendChild(B), ne.appendChild(document.createTextNode("/")), ne.appendChild(X), Q.appendChild(ne), j.appendChild(document.createElement("h3")).textContent = "Palabras", j.appendChild(L), j.appendChild(Q), d.appendChild(z), d.appendChild(g);
            const R = document.createElement("section");
            R.className = "danielamado_game_wordsearch", R.appendChild(N), R.appendChild(j), d.appendChild(R);
            const o = [
              [0, 1],
              [1, 0],
              [-1, 0],
              [0, -1],
              [1, 1],
              [1, -1],
              [-1, 1],
              [-1, -1]
            ];

            function h() {
              I = [];
              for (let a = 0; a < E; a++) {
                const n = [];
                for (let s = 0; s < E; s++) n.push("");
                I.push(n)
              }
            }

            function T() {
              P = [];
              const a = _.slice().sort((n, s) => s.length - n.length);
              for (const n of a) {
                const s = n.toUpperCase();
                let b = !1;
                for (let v = 0; v < 500 && !b; v++) {
                  const x = o[Math.floor(Math.random() * o.length)],
                    K = Math.floor(Math.random() * E),
                    Y = Math.floor(Math.random() * E),
                    Z = [];
                  let te = !0;
                  for (let O = 0; O < s.length; O++) {
                    const se = K + x[0] * O,
                      re = Y + x[1] * O;
                    if (se < 0 || se >= E || re < 0 || re >= E) {
                      te = !1;
                      break
                    }
                    const ae = I[se][re];
                    if (ae !== "" && ae !== s[O]) {
                      te = !1;
                      break
                    }
                    Z.push({
                      r: se,
                      c: re
                    })
                  }
                  if (te) {
                    for (let O = 0; O < s.length; O++) I[Z[O].r][Z[O].c] = s[O];
                    P.push({
                      word: s,
                      coords: Z,
                      found: !1
                    }), b = !0
                  }
                }
                if (!b) return !1
              }
              return !0
            }

            function W() {
              const a = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
              for (let n = 0; n < E; n++)
                for (let s = 0; s < E; s++) I[n][s] || (I[n][s] = a[Math.floor(Math.random() * a.length)])
            }

            function D() {
              N.innerHTML = "";
              for (let a = 0; a < E; a++)
                for (let n = 0; n < E; n++) {
                  const s = document.createElement("div");
                  s.className = "danielamado_cell", s.dataset.r = a, s.dataset.c = n, s.textContent = I[a][n], N.appendChild(s)
                }
            }

            function q() {
              L.innerHTML = "";
              for (const a of P) {
                const n = document.createElement("li");
                n.textContent = a.word, a.found && n.classList.add("found"), n.dataset.word = a.word, L.appendChild(n)
              }
              X.textContent = P.length, M()
            }

            function M() {
              const a = P.filter(n => n.found).length;
              if (B.textContent = a, a === P.length) {
                let n = 0;
                if (G > 0) {
                  n = Math.max(0, Math.floor(G));
                  const s = new CustomEvent("game-score", {
                    detail: {
                      game: "wordsearch",
                      delta: n
                    }
                  });
                  u.dispatchEvent(s)
                }
                l(), V(a * 10 + n)
              }
            }

            function U(a, n) {
              return N.querySelector(`.danielamado_cell[data-r='${a}'][data-c='${n}']`)
            }

            function ee() {
              N.querySelectorAll(".danielamado_cell.danielamado_selecting").forEach(a => a.classList.remove("danielamado_selecting"))
            }

            function y(a) {
              for (const {
                  r: n,
                  c: s
                }
                of a) {
                const b = U(n, s);
                b && b.classList.add("danielamado_found")
              }
            }

            function t() {
              if (S.length === 0) return;
              const a = S.map(s => I[s.r][s.c]).join(""),
                n = a.split("").reverse().join("");
              for (const s of P)
                if (!s.found && (s.word === a || s.word === n)) {
                  s.found = !0, y(s.coords);
                  const b = L.querySelector(`li[data-word='${s.word}']`);
                  b && b.classList.add("danielamado_found");
                  const v = new CustomEvent("game-score", {
                    detail: {
                      game: "wordsearch",
                      delta: 10
                    }
                  });
                  u.dispatchEvent(v), M();
                  break
                }
            }

            function e(a, n) {
              if (S.length && S[S.length - 1].r === a && S[S.length - 1].c === n || S.find(x => x.r === a && x.c === n)) return;
              if (S.length === 0) {
                S.push({
                  r: a,
                  c: n
                });
                const x = U(a, n);
                x && x.classList.add("danielamado_selecting"), F = null, H = !1;
                return
              }
              if (S.length === 1) {
                const x = S[0].r,
                  K = S[0].c,
                  Y = a - x,
                  Z = n - K,
                  te = Math.sign(Y),
                  O = Math.sign(Z);
                te === 0 || O === 0 || Math.abs(Y) === Math.abs(Z) || (H = !0), F = {
                  dr: te,
                  dc: O
                };
                const re = Math.max(Math.abs(Y), Math.abs(Z));
                for (let ae = 1; ae <= re; ae++) {
                  const ie = x + F.dr * ae,
                    le = K + F.dc * ae;
                  if (!S.find(oe => oe.r === ie && oe.c === le)) {
                    S.push({
                      r: ie,
                      c: le
                    });
                    const oe = U(ie, le);
                    oe && oe.classList.add("danielamado_selecting")
                  }
                }
                return
              }
              if (H || !F) return;
              const s = S[S.length - 1],
                b = s.r + F.dr,
                v = s.c + F.dc;
              if (a === b && n === v) {
                S.push({
                  r: a,
                  c: n
                });
                const x = U(a, n);
                x && x.classList.add("danielamado_selecting")
              }
            }

            function i(a) {
              a.preventDefault(), A = !0, S = [], F = null, H = !1, ee();
              const n = a.touches ? document.elementFromPoint(a.touches[0].clientX, a.touches[0].clientY) : a.target,
                s = n && n.closest ? n.closest(".danielamado_cell") : null;
              s && e(+s.dataset.r, +s.dataset.c)
            }

            function c(a) {
              if (!A) return;
              const n = a.touches ? a.touches[0] : null,
                s = n ? document.elementFromPoint(n.clientX, n.clientY) : a.target,
                b = s && s.closest ? s.closest(".danielamado_cell") : null;
              b && e(+b.dataset.r, +b.dataset.c)
            }

            function m(a) {
              A && (A = !1, t(), S = [], F = null, H = !1, ee())
            }

            function p() {
              N.addEventListener("mousedown", i), N.addEventListener("mousemove", c), u.addEventListener("mouseup", m), N.addEventListener("touchstart", i, {
                passive: !1
              }), N.addEventListener("touchmove", c, {
                passive: !1
              }), u.addEventListener("touchend", m)
            }

            function r() {
              l(), G = k, f(), J = setInterval(() => {
                G--, f(), G <= 0 && (l(), V(0))
              }, 1e3)
            }

            function l() {
              J && (clearInterval(J), J = null)
            }

            function f() {
              const a = new CustomEvent("game-timer", {
                detail: {
                  game: "wordsearch",
                  timeLeft: G
                }
              });
              u.dispatchEvent(a)
            }

            function C() {
              h();
              let a = !1,
                n = 0;
              for (; !a && n < 8;) h(), a = T(), n++;
              if (!a) {
                V(0);
                return
              }
              W(), D(), q(), p(), r()
            }
            C()
          })
        }
      }
    })(window);
    (function(u) {
      u.Games = u.Games || {}, u.Games.memory = {
        start: function(d, w = {}) {
          return new Promise(V => {
            const _ = w.timeLimit || 90,
              E = w.pairs || 8;
            let k = null,
              I = _,
              P = 0,
              A = 0;
            d.innerHTML = "";
            const S = document.createElement("h2");
            S.textContent = "Encuentra las Parejas";
            const F = document.createElement("p");
            F.textContent = "Asocia correctamente cada par de imágenes asociadas a Síndrome de Intestino Irritable.";
            const H = document.createElement("div");
            H.className = "danielamado_memory-board";
            const J = document.createElement("div");
            J.className = "danielamado_status";
            const G = document.createElement("span");
            G.className = "danielamado_mem-label", G.textContent = "Parejas encontradas:";
            const z = document.createElement("div");
            z.className = "danielamado_memory_status_wrap";
            const g = document.createElement("span");
            g.id = "danielamado_memMatches", g.className = "danielamado_mem-matches", g.textContent = `0/${E}`;
            const N = document.createTextNode(" "),
              j = document.createElement("span");
            j.id = "danielamado_memMoves", j.className = "danielamado_mem-moves", j.textContent = "Movimientos: 0", z.appendChild(g), z.appendChild(N), z.appendChild(j), J.appendChild(G), J.appendChild(z);
            const L = document.createElement("div");
            L.className = "danielamado_message", d.appendChild(S), d.appendChild(F), d.appendChild(H), d.appendChild(J), d.appendChild(L);
            const Q = ["https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1516-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1515-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1514-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1513-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1512-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1511-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1510-png1762551288.png", "https://vepimg.b8cdn.com/uploads/vjfnew/22331/content/files/1762551288g1509-png1762551288.png"],
              B = w.images && w.images.length ? w.images.slice() : Q.slice();
            for (; B.length < E;) B.push(...B.slice(0, E - B.length));
            B.sort(() => .5 - Math.random());
            const X = B.slice(0, E),
              $ = [];
            for (const y of X) $.push({
              img: y
            }), $.push({
              img: y
            });
            for (let y = $.length - 1; y > 0; y--) {
              const t = Math.floor(Math.random() * (y + 1));
              [$[y], $[t]] = [$[t], $[y]]
            }

            function ne() {
              H.innerHTML = "", H.style.gridTemplateColumns = "repeat(4, 80px)";
              for (let y = 0; y < $.length; y++) {
                const t = $[y],
                  e = document.createElement("button");
                e.className = "danielamado_mem-card", e.dataset.index = y;
                const i = document.createElement("div");
                i.className = "danielamado_flip-card-inner";
                const c = document.createElement("div");
                c.className = "danielamado_flip-card-front";
                const m = document.createElement("div");
                m.className = "danielamado_flip-card-back";
                const p = document.createElement("img");
                p.src = t.img, p.alt = "card", p.style.width = "100%", p.style.height = "100%", p.style.objectFit = "cover", m.appendChild(p), i.appendChild(c), i.appendChild(m), e.appendChild(i), H.appendChild(e)
              }
            }
            let R = null,
              o = null;

            function h(y, t) {
              if (y.classList.contains("danielamado_found")) return;
              const e = y.querySelector(".danielamado_flip-card-inner");
              e && (e.classList.contains("danielamado_is-flipped") || e.classList.add("danielamado_is-flipped"))
            }

            function T(y) {
              const t = y.querySelector(".danielamado_flip-card-inner");
              t && t.classList.remove("danielamado_is-flipped")
            }

            function W(y) {
              const t = y.target.closest(".danielamado_mem-card");
              if (!t) return;
              const e = +t.dataset.index;
              if (!t.classList.contains("danielamado_flipped") && !(R && o)) {
                if (h(t), !R) {
                  R = {
                    el: t,
                    idx: e
                  };
                  return
                }
                if (o = {
                    el: t,
                    idx: e
                  }, P++, D(), $[R.idx].img === $[o.idx].img) {
                  R.el.classList.add("danielamado_found"), o.el.classList.add("danielamado_found"), A++;
                  const i = new CustomEvent("game-score", {
                    detail: {
                      game: "memory",
                      delta: 10
                    }
                  });
                  if (u.dispatchEvent(i), R = null, o = null, A === E) {
                    let c = 0;
                    if (I > 0) {
                      c = Math.max(0, Math.floor(I));
                      const m = new CustomEvent("game-score", {
                        detail: {
                          game: "memory",
                          delta: c
                        }
                      });
                      u.dispatchEvent(m)
                    }
                    U(), L.textContent = "¡Completaste la actividad!", V(A * 10 + c)
                  }
                } else setTimeout(() => {
                  T(R.el), T(o.el), R = null, o = null
                }, 1e3)
              }
            }

            function D() {
              const y = document.getElementById("danielamado_memMatches"),
                t = document.getElementById("danielamado_memMoves");
              y && (y.textContent = `${A}/${E}`), t && (t.innerHTML = `Movimientos: <div>${P}</div>`)
            }

            function q() {
              U(), I = _, M(), k = setInterval(() => {
                I--, M(), I <= 0 && (U(), L.textContent = "Tiempo agotado", V(A * 10))
              }, 1e3)
            }

            function M() {
              const y = new CustomEvent("game-timer", {
                detail: {
                  game: "memory",
                  timeLeft: I
                }
              });
              u.dispatchEvent(y)
            }

            function U() {
              k && (clearInterval(k), k = null)
            }
            H.addEventListener("click", W);

            function ee() {
              R = null, o = null, A = 0, P = 0, L.textContent = "", ne(), D(), q()
            }
            ee()
          })
        }
      }
    })(window);
    (function(u) {
      u.Games = u.Games || {}, u.Games.guessword = {
        start: function(d, w = {}) {
          return new Promise(V => {
            const _ = w.timeLimit || 120,
              k = (w.questions && w.questions.length ? w.questions.slice() : [{
                q: " ",
                a: "ACIDEZ GASTRICA"
              }, {
                q: " ",
                a: "PANTOPRAZOL"
              }, {
                q: " ",
                a: "SELECTIVIDAD"
              }, {
                q: " ",
                a: "IBP INNOVADOR"
              }, {
                q: " ",
                a: "DEXLANSOPRAZOL"
              }]).map(M => ({
                q: M.q,
                a: String(M.a).toUpperCase()
              }));
            let I = null,
              P = _,
              A = 0,
              S = 0,
              F = 0;
            d.innerHTML = "";
            const H = document.createElement("h2");
            H.textContent = "Completa las palabras";
            const J = document.createElement("p");
            J.textContent = "Incluye las letras que faltan, para completar las palabras asociadas a Inhibidores de Bomba de Protones";
            const G = document.createElement("div");
            G.className = "danielamado_gw-question";
            const z = document.createElement("div");
            z.className = "danielamado_gw-hint";
            const g = document.createElement("div");
            g.className = "danielamado_gw-input-row";
            const N = document.createElement("input");
            N.type = "text", N.placeholder = "Escribe tu respuesta aquí", N.id = "danielamado_gwAnswer";
            const j = document.createElement("button");
            j.textContent = "Responder", j.className = "danielamado_btn danielamado_btn-primary", j.setAttribute("aria-label", "Responder");
            const L = document.createElement("button");
            L.textContent = "Saltar", L.className = "danielamado_btn danielamado_btn-secondary", L.setAttribute("aria-label", "Saltar");
            const Q = document.createElement("div");
            Q.className = "danielamado_gw-controls", Q.appendChild(j), Q.appendChild(L), g.appendChild(N), g.appendChild(Q);
            const B = document.createElement("div");
            B.className = "danielamado_message", d.appendChild(H), d.appendChild(J), d.appendChild(G), d.appendChild(z), d.appendChild(g), d.appendChild(B);

            function X(M) {
              return String(M || "").toUpperCase().replace(/\s+/g, "")
            }

            function $() {
              return X(k[A].a)
            }

            function ne() {
              return k[A].q
            }

            function R() {
              G.innerHTML = "";
              const M = document.createElement("div");
              M.className = "danielamado_gw-progress", M.textContent = `Palabra ${A + 1}/${k.length}`;
              const U = document.createTextNode(`${ne()}`);
              G.appendChild(M), G.appendChild(U);
              const ee = k[A].a,
                y = ee.split(""),
                t = [];
              for (let r = 0; r < y.length; r++) y[r] !== " " && t.push(r);
              const e = Math.min(3, t.length);
              for (let r = t.length - 1; r > 0; r--) {
                const l = Math.floor(Math.random() * (r + 1)),
                  f = t[r];
                t[r] = t[l], t[l] = f
              }
              const i = new Set(t.slice(0, e));
              for (let r = 0; r < y.length; r++) y[r] === " " || i.has(r), r < y.length - 1;
              z.innerHTML = "";
              const c = document.createElement("div");
              c.className = "danielamado_gw-hint-label", c.textContent = "Pista:", z.appendChild(c);
              const m = document.createElement("div");
              m.className = "danielamado_gw-code";
              for (let r = 0; r < y.length; r++) {
                const l = y[r];
                if (l === " ") {
                  const C = document.createElement("div");
                  C.className = "danielamado_gw-code-space", m.appendChild(C);
                  continue
                }
                const f = document.createElement("div");
                f.className = "danielamado_gw-code-box", i.has(r) ? (f.classList.add("danielamado_filled"), f.textContent = l) : f.textContent = "", m.appendChild(f)
              }
              z.appendChild(m);
              const p = document.createElement("div");
              p.className = "danielamado_gw-remaining", p.textContent = `Letras faltantes: ${X(ee).length - i.size}`, z.appendChild(p), N.value = "", N.focus()
            }

            function o(M) {
              const U = new CustomEvent("game-score", {
                detail: {
                  game: "guessword",
                  delta: M
                }
              });
              u.dispatchEvent(U), S += M
            }

            function h() {
              const M = X(N.value),
                U = $();
              if (!M) {
                B.textContent = "Escribe una respuesta.";
                return
              }
              if (M === U) {
                if (B.textContent = "Correcto! +10 puntos.", o(10), F++, A++, A >= k.length) {
                  if (F > 0 && P > 0) {
                    const ee = Math.max(0, Math.floor(P));
                    o(ee), B.textContent += ` Bonus +${ee} por terminar antes del tiempo.`
                  } else P > 0 && (B.textContent += " No se otorga bonus por terminar antes porque no respondiste correctamente ninguna pregunta.");
                  D(), setTimeout(() => {
                    V(S)
                  }, 700);
                  return
                }
                setTimeout(() => {
                  B.textContent = "", R()
                }, 700)
              } else B.textContent = "Incorrecto. Intenta de nuevo."
            }

            function T() {
              if (A++, A >= k.length) {
                if (F > 0 && P > 0) {
                  const M = Math.max(0, Math.floor(P));
                  o(M), B.textContent = `Terminaste (con saltos). Bonus +${M} por terminar antes del tiempo.`
                } else P > 0 && (B.textContent = "Terminaste (con saltos). No se otorga bonus por terminar antes porque no respondiste correctamente ninguna pregunta.");
                D(), setTimeout(() => {
                  V(S)
                }, 700);
                return
              }
              R()
            }
            j.addEventListener("click", h), N.addEventListener("keydown", M => {
              M.key === "Enter" && h()
            }), L.addEventListener("click", T);

            function W() {
              D(), P = _, q(), I = setInterval(() => {
                P--, q(), P <= 0 && (D(), B.textContent = "Tiempo agotado", V(S))
              }, 1e3)
            }

            function D() {
              I && (clearInterval(I), I = null)
            }

            function q() {
              const M = new CustomEvent("game-timer", {
                detail: {
                  game: "guessword",
                  timeLeft: P
                }
              });
              u.dispatchEvent(M)
            }
            R(), W()
          })
        }
      }
    })(window);
    var ce = {};
    (function u(d, w, V, _) {
        var E = !!(d.Worker && d.Blob && d.Promise && d.OffscreenCanvas && d.OffscreenCanvasRenderingContext2D && d.HTMLCanvasElement && d.HTMLCanvasElement.prototype.transferControlToOffscreen && d.URL && d.URL.createObjectURL),
          k = typeof Path2D == "function" && typeof DOMMatrix == "function",
          I = (function() {
            if (!d.OffscreenCanvas) return !1;
            try {
              var t = new OffscreenCanvas(1, 1),
                e = t.getContext("2d");
              e.fillRect(0, 0, 1, 1);
              var i = t.transferToImageBitmap();
              e.createPattern(i, "no-repeat")
            } catch {
              return !1
            }
            return !0
          })();

        function P() {}

        function A(t) {
          var e = w.exports.Promise,
            i = e !== void 0 ? e : d.Promise;
          return typeof i == "function" ? new i(t) : (t(P, P), null)
        }
        var S = (function(t, e) {
            return {
              transform: function(i) {
                if (t) return i;
                if (e.has(i)) return e.get(i);
                var c = new OffscreenCanvas(i.width, i.height),
                  m = c.getContext("2d");
                return m.drawImage(i, 0, 0), e.set(i, c), c
              },
              clear: function() {
                e.clear()
              }
            }
          })(I, new Map),
          F = (function() {
            var t = Math.floor(16.666666666666668),
              e, i, c = {},
              m = 0;
            return typeof requestAnimationFrame == "function" && typeof cancelAnimationFrame == "function" ? (e = function(p) {
              var r = Math.random();
              return c[r] = requestAnimationFrame(function l(f) {
                m === f || m + t - 1 < f ? (m = f, delete c[r], p()) : c[r] = requestAnimationFrame(l)
              }), r
            }, i = function(p) {
              c[p] && cancelAnimationFrame(c[p])
            }) : (e = function(p) {
              return setTimeout(p, t)
            }, i = function(p) {
              return clearTimeout(p)
            }), {
              frame: e,
              cancel: i
            }
          })(),
          H = (function() {
            var t, e, i = {};

            function c(m) {
              function p(r, l) {
                m.postMessage({
                  options: r || {},
                  callback: l
                })
              }
              m.init = function(l) {
                var f = l.transferControlToOffscreen();
                m.postMessage({
                  canvas: f
                }, [f])
              }, m.fire = function(l, f, C) {
                if (e) return p(l, null), e;
                var a = Math.random().toString(36).slice(2);
                return e = A(function(n) {
                  function s(b) {
                    b.data.callback === a && (delete i[a], m.removeEventListener("message", s), e = null, S.clear(), C(), n())
                  }
                  m.addEventListener("message", s), p(l, a), i[a] = s.bind(null, {
                    data: {
                      callback: a
                    }
                  })
                }), e
              }, m.reset = function() {
                m.postMessage({
                  reset: !0
                });
                for (var l in i) i[l](), delete i[l]
              }
            }
            return function() {
              if (t) return t;
              if (!V && E) {
                var m = ["var CONFETTI, SIZE = {}, module = {};", "(" + u.toString() + ")(this, module, true, SIZE);", "onmessage = function(msg) {", "  if (msg.data.options) {", "    CONFETTI(msg.data.options).then(function () {", "      if (msg.data.callback) {", "        postMessage({ callback: msg.data.callback });", "      }", "    });", "  } else if (msg.data.reset) {", "    CONFETTI && CONFETTI.reset();", "  } else if (msg.data.resize) {", "    SIZE.width = msg.data.resize.width;", "    SIZE.height = msg.data.resize.height;", "  } else if (msg.data.canvas) {", "    SIZE.width = msg.data.canvas.width;", "    SIZE.height = msg.data.canvas.height;", "    CONFETTI = module.exports.create(msg.data.canvas);", "  }", "}"].join(`
`);
                try {
                  t = new Worker(URL.createObjectURL(new Blob([m])))
                } catch (p) {
                  return typeof console < "u" && typeof console.warn == "function" && console.warn("???? Could not load worker", p), null
                }
                c(t)
              }
              return t
            }
          })(),
          J = {
            particleCount: 50,
            angle: 90,
            spread: 45,
            startVelocity: 45,
            decay: .9,
            gravity: 1,
            drift: 0,
            ticks: 200,
            x: .5,
            y: .5,
            shapes: ["square", "circle"],
            zIndex: 100,
            colors: ["#26ccff", "#a25afd", "#ff5e7e", "#88ff5a", "#fcff42", "#ffa62d", "#ff36ff"],
            disableForReducedMotion: !1,
            scalar: 1
          };

        function G(t, e) {
          return e ? e(t) : t
        }

        function z(t) {
          return t != null
        }

        function g(t, e, i) {
          return G(t && z(t[e]) ? t[e] : J[e], i)
        }

        function N(t) {
          return t < 0 ? 0 : Math.floor(t)
        }

        function j(t, e) {
          return Math.floor(Math.random() * (e - t)) + t
        }

        function L(t) {
          return parseInt(t, 16)
        }

        function Q(t) {
          return t.map(B)
        }

        function B(t) {
          var e = String(t).replace(/[^0-9a-f]/gi, "");
          return e.length < 6 && (e = e[0] + e[0] + e[1] + e[1] + e[2] + e[2]), {
            r: L(e.substring(0, 2)),
            g: L(e.substring(2, 4)),
            b: L(e.substring(4, 6))
          }
        }

        function X(t) {
          var e = g(t, "origin", Object);
          return e.x = g(e, "x", Number), e.y = g(e, "y", Number), e
        }

        function $(t) {
          t.width = document.documentElement.clientWidth, t.height = document.documentElement.clientHeight
        }

        function ne(t) {
          var e = t.getBoundingClientRect();
          t.width = e.width, t.height = e.height
        }

        function R(t) {
          var e = document.createElement("canvas");
          return e.style.position = "fixed", e.style.top = "0px", e.style.left = "0px", e.style.pointerEvents = "none", e.style.zIndex = t, e
        }

        function o(t, e, i, c, m, p, r, l, f) {
          t.save(), t.translate(e, i), t.rotate(p), t.scale(c, m), t.arc(0, 0, 1, r, l, f), t.restore()
        }

        function h(t) {
          var e = t.angle * (Math.PI / 180),
            i = t.spread * (Math.PI / 180);
          return {
            x: t.x,
            y: t.y,
            wobble: Math.random() * 10,
            wobbleSpeed: Math.min(.11, Math.random() * .1 + .05),
            velocity: t.startVelocity * .5 + Math.random() * t.startVelocity,
            angle2D: -e + (.5 * i - Math.random() * i),
            tiltAngle: (Math.random() * (.75 - .25) + .25) * Math.PI,
            color: t.color,
            shape: t.shape,
            tick: 0,
            totalTicks: t.ticks,
            decay: t.decay,
            drift: t.drift,
            random: Math.random() + 2,
            tiltSin: 0,
            tiltCos: 0,
            wobbleX: 0,
            wobbleY: 0,
            gravity: t.gravity * 3,
            ovalScalar: .6,
            scalar: t.scalar,
            flat: t.flat
          }
        }

        function T(t, e) {
          e.x += Math.cos(e.angle2D) * e.velocity + e.drift, e.y += Math.sin(e.angle2D) * e.velocity + e.gravity, e.velocity *= e.decay, e.flat ? (e.wobble = 0, e.wobbleX = e.x + 10 * e.scalar, e.wobbleY = e.y + 10 * e.scalar, e.tiltSin = 0, e.tiltCos = 0, e.random = 1) : (e.wobble += e.wobbleSpeed, e.wobbleX = e.x + 10 * e.scalar * Math.cos(e.wobble), e.wobbleY = e.y + 10 * e.scalar * Math.sin(e.wobble), e.tiltAngle += .1, e.tiltSin = Math.sin(e.tiltAngle), e.tiltCos = Math.cos(e.tiltAngle), e.random = Math.random() + 2);
          var i = e.tick++/ e.totalTicks, c = e.x + e.random * e.tiltCos, m = e.y + e.random * e.tiltSin, p = e.wobbleX + e.random * e.tiltCos, r = e.wobbleY + e.random * e.tiltSin; if (t.fillStyle = "rgba(" + e.color.r + ", " + e.color.g + ", " + e.color.b + ", " + (1 - i) + ")", t.beginPath(), k && e.shape.type === "path" && typeof e.shape.path == "string" && Array.isArray(e.shape.matrix)) t.fill(U(e.shape.path, e.shape.matrix, e.x, e.y, Math.abs(p - c) * .1, Math.abs(r - m) * .1, Math.PI /
          10 * e.wobble));
      else if (e.shape.type === "bitmap") {
        var l = Math.PI / 10 * e.wobble,
          f = Math.abs(p - c) * .1,
          C = Math.abs(r - m) * .1,
          a = e.shape.bitmap.width * e.scalar,
          n = e.shape.bitmap.height * e.scalar,
          s = new DOMMatrix([Math.cos(l) * f, Math.sin(l) * f, -Math.sin(l) * C, Math.cos(l) * C, e.x, e.y]);
        s.multiplySelf(new DOMMatrix(e.shape.matrix));
        var b = t.createPattern(S.transform(e.shape.bitmap), "no-repeat");
        b.setTransform(s), t.globalAlpha = 1 - i, t.fillStyle = b, t.fillRect(e.x - a / 2, e.y - n / 2, a, n), t.globalAlpha = 1
      } else if (e.shape === "circle") t.ellipse ? t.ellipse(e.x, e.y, Math.abs(p - c) * e.ovalScalar, Math.abs(r - m) * e.ovalScalar, Math.PI / 10 * e.wobble, 0, 2 * Math.PI) : o(t, e.x, e.y, Math.abs(p - c) * e.ovalScalar, Math.abs(r - m) * e.ovalScalar, Math.PI / 10 * e.wobble, 0, 2 * Math.PI);
      else if (e.shape === "star")
        for (var v = Math.PI / 2 * 3, x = 4 * e.scalar, K = 8 * e.scalar, Y = e.x, Z = e.y, te = 5, O = Math.PI / te; te--;) Y = e.x + Math.cos(v) * K, Z = e.y + Math.sin(v) * K, t.lineTo(Y, Z), v += O, Y = e.x + Math.cos(v) * x, Z = e.y + Math.sin(v) * x, t.lineTo(Y, Z), v += O;
      else t.moveTo(Math.floor(e.x), Math.floor(e.y)), t.lineTo(Math.floor(e.wobbleX), Math.floor(m)), t.lineTo(Math.floor(p), Math.floor(r)), t.lineTo(Math.floor(c), Math.floor(e.wobbleY));
      return t.closePath(), t.fill(), e.tick < e.totalTicks
    }

    function W(t, e, i, c, m) {
      var p = e.slice(),
        r = t.getContext("2d"),
        l, f, C = A(function(a) {
          function n() {
            l = f = null, r.clearRect(0, 0, c.width, c.height), S.clear(), m(), a()
          }

          function s() {
            V && !(c.width === _.width && c.height === _.height) && (c.width = t.width = _.width, c.height = t.height = _.height), !c.width && !c.height && (i(t), c.width = t.width, c.height = t.height), r.clearRect(0, 0, c.width, c.height), p = p.filter(function(b) {
              return T(r, b)
            }), p.length ? l = F.frame(s) : n()
          }
          l = F.frame(s), f = n
        });
      return {
        addFettis: function(a) {
          return p = p.concat(a), C
        },
        canvas: t,
        promise: C,
        reset: function() {
          l && F.cancel(l), f && f()
        }
      }
    }

    function D(t, e) {
      var i = !t,
        c = !!g(e || {}, "resize"),
        m = !1,
        p = g(e, "disableForReducedMotion", Boolean),
        r = E && !!g(e || {}, "useWorker"),
        l = r ? H() : null,
        f = i ? $ : ne,
        C = t && l ? !!t.__confetti_initialized : !1,
        a = typeof matchMedia == "function" && matchMedia("(prefers-reduced-motion)").matches,
        n;

      function s(v, x, K) {
        for (var Y = g(v, "particleCount", N), Z = g(v, "angle", Number), te = g(v, "spread", Number), O = g(v, "startVelocity", Number), se = g(v, "decay", Number), re = g(v, "gravity", Number), ae = g(v, "drift", Number), ie = g(v, "colors", Q), le = g(v, "ticks", Number), oe = g(v, "shapes"), fe = g(v, "scalar"), he = !!g(v, "flat"), me = X(v), ue = Y, de = [], ge = t.width * me.x, ve = t.height * me.y; ue--;) de.push(h({
          x: ge,
          y: ve,
          angle: Z,
          spread: te,
          startVelocity: O,
          color: ie[ue % ie.length],
          shape: oe[j(0, oe.length)],
          ticks: le,
          decay: se,
          gravity: re,
          drift: ae,
          scalar: fe,
          flat: he
        }));
        return n ? n.addFettis(de) : (n = W(t, de, f, x, K), n.promise)
      }

      function b(v) {
        var x = p || g(v, "disableForReducedMotion", Boolean),
          K = g(v, "zIndex", Number);
        if (x && a) return A(function(O) {
          O()
        });
        i && n ? t = n.canvas : i && !t && (t = R(K), document.body.appendChild(t)), c && !C && f(t);
        var Y = {
          width: t.width,
          height: t.height
        };
        l && !C && l.init(t), C = !0, l && (t.__confetti_initialized = !0);

        function Z() {
          if (l) {
            var O = {
              getBoundingClientRect: function() {
                if (!i) return t.getBoundingClientRect()
              }
            };
            f(O), l.postMessage({
              resize: {
                width: O.width,
                height: O.height
              }
            });
            return
          }
          Y.width = Y.height = null
        }

        function te() {
          n = null, c && (m = !1, d.removeEventListener("resize", Z)), i && t && (document.body.contains(t) && document.body.removeChild(t), t = null, C = !1)
        }
        return c && !m && (m = !0, d.addEventListener("resize", Z, !1)), l ? l.fire(v, Y, te) : s(v, Y, te)
      }
      return b.reset = function() {
        l && l.reset(), n && n.reset()
      }, b
    }
    var q;

    function M() {
      return q || (q = D(null, {
        useWorker: !0,
        resize: !0
      })), q
    }

    function U(t, e, i, c, m, p, r) {
      var l = new Path2D(t),
        f = new Path2D;
      f.addPath(l, new DOMMatrix(e));
      var C = new Path2D;
      return C.addPath(f, new DOMMatrix([Math.cos(r) * m, Math.sin(r) * m, -Math.sin(r) * p, Math.cos(r) * p, i, c])), C
    }

    function ee(t) {
      if (!k) throw new Error("path confetti are not supported in this browser");
      var e, i;
      typeof t == "string" ? e = t : (e = t.path, i = t.matrix);
      var c = new Path2D(e),
        m = document.createElement("canvas"),
        p = m.getContext("2d");
      if (!i) {
        for (var r = 1e3, l = r, f = r, C = 0, a = 0, n, s, b = 0; b < r; b += 2)
          for (var v = 0; v < r; v += 2) p.isPointInPath(c, b, v, "nonzero") && (l = Math.min(l, b), f = Math.min(f, v), C = Math.max(C, b), a = Math.max(a, v));
        n = C - l, s = a - f;
        var x = 10,
          K = Math.min(x / n, x / s);
        i = [K, 0, 0, K, -Math.round(n / 2 + l) * K, -Math.round(s / 2 + f) * K]
      }
      return {
        type: "path",
        path: e,
        matrix: i
      }
    }

    function y(t) {
      var e, i = 1,
        c = "#000000",
        m = '"Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji", "EmojiOne Color", "Android Emoji", "Twemoji Mozilla", "system emoji", sans-serif';
      typeof t == "string" ? e = t : (e = t.text, i = "scalar" in t ? t.scalar : i, m = "fontFamily" in t ? t.fontFamily : m, c = "color" in t ? t.color : c);
      var p = 10 * i,
        r = "" + p + "px " + m,
        l = new OffscreenCanvas(p, p),
        f = l.getContext("2d");
      f.font = r;
      var C = f.measureText(e),
        a = Math.ceil(C.actualBoundingBoxRight + C.actualBoundingBoxLeft),
        n = Math.ceil(C.actualBoundingBoxAscent + C.actualBoundingBoxDescent),
        s = 2,
        b = C.actualBoundingBoxLeft + s,
        v = C.actualBoundingBoxAscent + s;
      a += s + s, n += s + s, l = new OffscreenCanvas(a, n), f = l.getContext("2d"), f.font = r, f.fillStyle = c, f.fillText(e, b, v);
      var x = 1 / i;
      return {
        type: "bitmap",
        bitmap: l.transferToImageBitmap(),
        matrix: [x, 0, 0, x, -a * x / 2, -n * x / 2]
      }
    }
    w.exports = function() {
      return M().apply(this, arguments)
    }, w.exports.reset = function() {
      M().reset()
    }, w.exports.create = D, w.exports.shapeFromPath = ee, w.exports.shapeFromText = y
  })((function() {
    return typeof window < "u" ? window : typeof self < "u" ? self : this || {}
  })(), ce, !1);
  const pe = ce.exports;
  ce.exports.create;
  (function(u) {
    const d = document.getElementById("danielamado_gameArea"),
      w = document.getElementById("danielamado_startBtn"),
      V = document.getElementById("danielamado_emailInput"),
      _ = document.getElementById("danielamado_playerEmail"),
      E = document.getElementById("danielamado_totalPoints"),
      k = document.getElementById("danielamado_timeLeft"),
      I = document.getElementById("danielamado_globalMessage"),
      P = document.getElementById("danielamado_intro"),
      A = document.querySelector(".danielamado_email-row");
    u.App = u.App || {}, u.App.pointsStore = u.App.pointsStore || {};
    const S = "games_progress";

    function F() {
      try {
        const o = localStorage.getItem(S);
        return o ? JSON.parse(o) || {} : {}
      } catch (o) {
        return console.warn("Could not read progress from localStorage:", o), {}
      }
    }

    function H(o) {
      try {
        localStorage.setItem(S, JSON.stringify(o || {}))
      } catch (h) {
        console.warn("Could not write progress to localStorage:", h)
      }
    }

    function J(o) {
      return o && F()[o] || null
    }
    async function G(o, h, T, W) {
      if (!o) return;
      const D = "https://market-support.com/api/apps/adium/foro2025/receive_score.php",
        q = {
          email: String(o),
          puntaje: Number(h) || 0,
          ultimo: !!T,
          user_id: W || null
        };
      try {
        await fetch(D, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          keepalive: !0,
          body: JSON.stringify(q)
        }), console.info("Score sent", q)
      } catch (M) {
        console.warn("Could not send score to endpoint:", M, q), setTimeout(() => {
          try {
            fetch(D, {
              method: "POST",
              headers: {
                "Content-Type": "application/json"
              },
              body: JSON.stringify(q)
            }).then(() => console.info("Retry score sent", q)).catch(() => {})
          } catch {}
        }, 1200)
      }
    }

    function z(o, h) {
      if (!o) return;
      const T = F();
      T[o] = h || null, H(T)
    }
    let g = null,
      N = null,
      j = !1,
      L = null;
    try {
      const o = localStorage.getItem("login_user_email");
      o && typeof o == "string" && o.includes("@") && (g = o.trim(), _ && (_.textContent = g), E && (E.textContent = u.App.pointsStore[g] || 0), A && (A.style.display = "none"))
    } catch (o) {
      console.warn("localStorage unavailable:", o)
    }
    try {
      const o = localStorage.getItem("user_info");
      if (o) {
        const h = JSON.parse(o);
        h && h.uuid && (N = String(h.uuid))
      }
    } catch {}

    function Q(o) {
      const h = Math.floor(o / 60).toString().padStart(2, "0"),
        T = (o % 60).toString().padStart(2, "0");
      return `${h}:${T}`
    }
    u.addEventListener("game-timer", o => {
      const h = o.detail || {};
      if (!h.game || h.game !== L) return;
      const T = h.timeLeft;
      k.textContent = Q(T)
    }), u.addEventListener("game-score", o => {
      const h = o.detail || {},
        T = Number(h.delta) || 0,
        W = g;
      if (!W) return;
      const q = (u.App.pointsStore[W] || 0) + T;
      u.App.pointsStore[W] = q, E.textContent = q
    });
    async function B() {
      j = !0, P.style.display = "none", I.textContent = "";
      const o = g;
      u.App.pointsStore[o];
      async function h(r, l, f) {
        if (!u.Games || !u.Games[r] || typeof u.Games[r].start != "function") return I.textContent = `Modulo de juego "${r}" no disponible.`, await new Promise(C => setTimeout(C, 700)), 0;
        try {
          return await u.Games[r].start(l, f || {}) || 0
        } catch (C) {
          return console.error(`Error ejecutando juego ${r}:`, C), I.textContent = `Error en el juego ${r}: ${C.message || C}`, 0
        }
      }

      function T(r, l, f, C) {
        return new Promise(a => {
          d.innerHTML = "";
          const n = document.createElement("div");
          n.className = "danielamado_interstitial-banner";
          const s = document.createElement("h3");
          s.textContent = `Fin de ${r}`, n.appendChild(s);
          const b = document.createElement("p");
          b.className = "danielamado_interstitial-points", b.textContent = `Puntos obtenidos: ${l >= 0 ? "+" + l : l}`, n.appendChild(b);
          const v = document.createElement("p");
          v.className = "danielamado_interstitial-next", v.textContent = `Siguiente: ${f} — ${C}`, n.appendChild(v);
          const x = document.createElement("button");
          x.className = "danielamado_interstitial-start-btn danielamado_btn_accent", x.textContent = "Comenzar la siguiente actividad", x.addEventListener("click", () => {
            n.remove(), a()
          }), n.appendChild(x), d.appendChild(n)
        })
      }
      I.textContent = "Actividad 1: Sopa de letras", d.innerHTML = "";
      const W = document.createElement("div");
      W.className = "danielamado_game_card_wordsearch danielamado_game_container", d.appendChild(W), L = "wordsearch";
      const D = u.App.pointsStore[o] || 0;
      await h("wordsearch", W, {
        timeLimit: 300
      }), L = null;
      const M = (u.App.pointsStore[o] || 0) - D;
      try {
        G(o, M, !1, N)
      } catch (r) {
        console.warn("sendScoreToEndpoint error (wordsearch):", r)
      }
      await T("Sopa de letras", M, "actividad de Parejas", "Encuentra las parejas girando las cartas."), I.textContent = "Actividad 2: Encuentra las parejas", d.innerHTML = "";
      const U = document.createElement("div");
      U.className = "danielamado_game_card_memory danielamado_game_container", d.appendChild(U), L = "memory";
      const ee = u.App.pointsStore[o] || 0;
      await h("memory", U, {
        timeLimit: 120,
        pairs: 8
      }), L = null;
      const t = (u.App.pointsStore[o] || 0) - ee;
      try {
        G(o, t, !1, N)
      } catch (r) {
        console.warn("sendScoreToEndpoint error (memory):", r)
      }
      await T("Parejas", t, "Completa las palabras", "Completa las palabras correctas leyendo la pista antes de que se acabe el tiempo."), I.textContent = "Juego 3: Completa las palabras", d.innerHTML = "";
      const e = document.createElement("div");
      e.className = "danielamado_game_card_guessword danielamado_game_container", d.appendChild(e), L = "guessword";
      const i = u.App.pointsStore[o] || 0;
      await h("guessword", e, {
        timeLimit: 120
      });
      const m = (u.App.pointsStore[o] || 0) - i;
      try {
        G(o, m, !0, N)
      } catch (r) {
        console.warn("sendScoreToEndpoint error (guessword final):", r)
      }
      L = null, j = !1;
      const p = u.App.pointsStore[o] || 0;
      try {
        z(o, {
          completed: !0,
          score: p,
          timestamp: new Date().toISOString()
        }), w && (w.style.display = "none"), d && (d.innerHTML = "");
        const r = document.getElementById("gameStartBanner");
        r && r.remove(), R();
        try {
          typeof pe == "function" && pe({
            particleCount: 100,
            spread: 100,
            origin: {
              y: .6
            }
          })
        } catch (l) {
          console.warn("confetti error:", l)
        }
      } catch (r) {
        console.warn("Could not save completion state:", r)
      }
    }
    const X = document.getElementById("danielamado_endBannerOverlay");
    document.getElementById("danielamado_endScore");
    const $ = document.getElementById("danielamado_closeBannerBtn");

    function ne() {
      X && X.setAttribute("aria-hidden", "true")
    }

    function R() {
      if (!d) return null;
      const o = document.getElementById("gameStartBanner");
      if (o) return o;
      const h = document.createElement("div");
      h.id = "gameStartBanner", h.className = "danielamado_game-start-banner";
      const T = g ? J(g) : null;
      if (T && T.completed) {
        P.style.display = "none", h.innerHTML = `
        <div class="game-start-card" style="background:#fff;padding:18px;border-radius:8px;max-width:560px;margin:20px auto;text-align:center;">
          <h3>Actividades completadas</h3>
          <p>Ya completaste las actividades</p>
          <div>Puntaje final:</div>
          <div id="startBannerScore">${T.score}</div>
          <div style="margin-top:12px;">
          <p style="font-size: 18px;">recuerda volver al en vivo</p>
          </div>
        </div>
      `, d.appendChild(h);
        const D = h.querySelector("#goLiveBtn");
        return D && D.addEventListener("click", () => {
          const q = u.App && u.App.liveUrl || "/en-vivo";
          try {
            u.location.href = q
          } catch {
            u.dispatchEvent(new CustomEvent("go-live", {
              detail: {
                url: q
              }
            }))
          }
        }), w && (w.style.display = "none"), h
      }
      h.innerHTML = `
      <div class="game-start-card" style="background:#fff;padding:18px;border-radius:8px;max-width:560px;margin:20px auto;text-align:center;">
        <div>
          <button id="gameStartBtn" class="danielamado_btn danielamado_btn-primary">Empezar</button>
        </div>
      </div>
    `, d.appendChild(h);
      const W = h.querySelector("#gameStartBtn");
      return W && W.addEventListener("click", () => {
        h.remove(), w && w.click()
      }), h
    }
    $ && $.addEventListener("click", () => {
      ne()
    }), R(), w.addEventListener("click", () => {
      let o = g;
      if (!o) {
        if (o = (V.value || "").trim(), !o || !o.includes("@")) {
          I.textContent = "Introduce un email válido";
          return
        }
        g = o
      }
      _ && (_.textContent = o), E && (E.textContent = u.App.pointsStore[o] || 0);
      const h = J(o);
      if (h && h.completed) {
        const T = document.getElementById("gameStartBanner");
        T && T.remove(), R();
        return
      }
      B()
    }), g && !j && (document.getElementById("gameStartBanner") !== null || setTimeout(() => {
      j || B()
    }, 50))
  })(window)
  });
  export default Ee();
</script>
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
<?= $this->endSection() ?>