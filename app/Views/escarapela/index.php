<?= $this->extend('layouts/dashboardLayout') ?>

<?= $this->section('content') ?>
<script type="module"
  crossorigin>
  // badge-3d.js
  // Reads localStorage.user_info and applies 3D mouse interactions to the #badge element
  (function() {
    function safeParse(str) {
      try {
        return JSON.parse(str);
      } catch (e) {
        return null;
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      // default user (email intentionally omitted — we don't display email in the badge)
      const defaultUser = {
        name: "attendee test",
        uuid: "1238784424",
        logo: ""
      };
      const stored = safeParse(localStorage.getItem('user_info'));
      const user = stored && stored.name ? stored : defaultUser;

      const nameEl = document.getElementById('badgeID_badge-name');
      const badge = document.getElementById('badgeID_badge');
      const image = badge ? badge.querySelector('.badgeID_badge-image') : null;
      const overlay = badge ? badge.querySelector('.badgeID_badge-overlay') : null;

      if (nameEl) nameEl.textContent = user.name || '';

      if (!badge) return;

      // 3D interaction
      const maxRot = 10; // degrees
      badge.style.transformStyle = 'preserve-3d';
      // base transition used during user interaction (restored after auto animation)
      const baseTransition = 'transform 220ms ease, box-shadow 220ms ease';
      badge.style.transition = baseTransition;

      // Auto-animation (before first mouse entry): gentle 3D tilt every 5s
      let mouseEntered = false;
      let autoInterval = null;
      let autoStartTimer = null;
      const AUTO_DELAY = 5000; // milliseconds

      function stopAutoAnimation() {
        mouseEntered = true;
        if (autoStartTimer) {
          clearTimeout(autoStartTimer);
          autoStartTimer = null;
        }
        if (autoInterval) {
          clearInterval(autoInterval);
          autoInterval = null;
        }
        // ensure any temporary transition used for auto animation is reset
        badge.style.transition = baseTransition;
      }

      function animateAutoOnce() {
        if (mouseEntered) return;
        // softer, slower transition for a gentler auto move
        const enterDur = 1200; // ms
        const enterTransition = `transform ${enterDur}ms cubic-bezier(0.22,0.8,0.2,1), box-shadow ${enterDur}ms ease`;
        badge.style.transition = enterTransition;
        if (image) image.style.transition = `transform ${enterDur}ms ease`;
        if (overlay) overlay.style.transition = `transform ${enterDur}ms ease`;

        // reduce tilt values for a subtler effect
        const tiltX = 3; // degrees
        const tiltY = -3; // degrees

        // apply transforms on the next paint to ensure the transition is active (avoids initial 'jump')
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            badge.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg)`;
            // matching very subtle parallax on inner elements
            if (image) image.style.transform = `translateZ(30px) translate(${3}px, ${-3}px) scale(1.02)`;
            if (overlay) overlay.style.transform = `translateZ(60px) translate(${2}px, ${-2}px)`;
          });
        });

        // return to neutral after a longer, gentle pause
        setTimeout(() => {
          if (mouseEntered) return;
          // set a dedicated, smooth return transition so the reset doesn't feel abrupt
          const returnDur = 900; // ms
          const returnTransition = `transform ${returnDur}ms cubic-bezier(0.22,0.8,0.2,1), box-shadow ${returnDur}ms ease`;
          badge.style.transition = returnTransition;
          if (image) image.style.transition = `transform ${returnDur}ms ease`;
          if (overlay) overlay.style.transition = `transform ${returnDur}ms ease`;

          // clear transforms to smoothly return to neutral
          badge.style.transform = '';
          if (image) image.style.transform = '';
          if (overlay) overlay.style.transform = '';

          // after the return completes, restore the baseTransition and clear temporary inner transitions
          setTimeout(() => {
            if (!mouseEntered) {
              badge.style.transition = baseTransition;
              if (image) image.style.transition = '';
              if (overlay) overlay.style.transition = '';
            }
          }, returnDur);
        }, 2200);
      }

      // schedule first auto animation after AUTO_DELAY, then every AUTO_DELAY
      autoStartTimer = setTimeout(() => {
        if (mouseEntered) return;
        animateAutoOnce();
        autoInterval = setInterval(animateAutoOnce, AUTO_DELAY);
      }, AUTO_DELAY);

      badge.addEventListener('mousemove', function(e) {
        // First mouse movement should stop the auto animation
        if (!mouseEntered) {
          stopAutoAnimation();
        }

        const rect = badge.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const cx = rect.width / 2;
        const cy = rect.height / 2;
        const dx = (x - cx) / cx; // -1 .. 1
        const dy = (y - cy) / cy; // -1 .. 1
        const rotateX = dy * maxRot;
        const rotateY = dx * -maxRot;
        badge.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;

        // parallax
        const imgZ = 30;
        const overlayZ = 60;
        if (image) image.style.transform = `translateZ(${imgZ}px) translate(${dx*10}px, ${dy*10}px) scale(1.02)`;
        if (overlay) overlay.style.transform = `translateZ(${overlayZ}px) translate(${dx*6}px, ${dy*6}px)`;
      });

      badge.addEventListener('mouseleave', function() {
        badge.style.transform = '';
        if (image) image.style.transform = '';
        if (overlay) overlay.style.transform = '';
      });

      // make overlay clickable (optional UX): allow selecting/copying other info
      const userInfo = badge.querySelector('.user-info');
      if (userInfo) userInfo.style.pointerEvents = 'auto';

      // --- Fetch additional user details by token and parse extracted_cv ---
      // Read token saved in localStorage under key `_token` and call vFairs API
      const token = localStorage.getItem('_token');
      if (token) {
        (async function() {
          try {
            const url = `https://api.vfairs.com/v3/user/get-user-by-token?token=${encodeURIComponent(token)}&secret=secret_user`;
            const res = await fetch(url, {
              method: 'GET',
              credentials: 'omit'
            });
            if (!res.ok) throw new Error('Network response was not ok: ' + res.status);
            const body = await res.json();

            const extracted = body && body.data && body.data.user_info && body.data.user_info.extracted_cv;
            if (!extracted) return;

            // Normalize into lines, remove empty lines and email lines
            const lines = extracted.split(/\r?\n/).map(s => s.trim()).filter(Boolean);

            const isEmail = s => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(s);
            const isDate = s => /\d{1,2}\/\d{1,2}\/\d{2,4}/.test(s) || /\d{4}-\d{2}-\d{2}/.test(s);
            const isGender = s => /^(masculino|femenino|male|female)$/i.test(s);
            const isNoiseToken = s => /^(attendee|test|attest)$/i.test(s) || /^\d+$/.test(s);

            const cleaned = lines.filter(l => !isEmail(l) && !isDate(l) && !isGender(l) && !isNoiseToken(l));

            // Heuristic: after removing emails/dates/genders/noise, use first two remaining lines as ciudad and farmacia
            const ciudad = cleaned[0] || '';
            const farmacia = cleaned[1] || '';

            // Prefer direct id lookup; fall back to querying inside the badge.
            const ciudadEl = document.getElementById('badgeID_badge-city') || (overlay && overlay.querySelector('#badgeID_badge-city')) || badge.querySelector('#badgeID_badge-city');
            const farmaciaEl = document.getElementById('badgeID_badge-pharmacy') || (overlay && overlay.querySelector('#badgeID_badge-pharmacy')) || badge.querySelector('#badgeID_badge-pharmacy');

            if (ciudadEl) ciudadEl.textContent = ciudad ? `${ciudad}` : '';
            if (farmaciaEl) farmaciaEl.textContent = farmacia ? `${farmacia}` : '';

          } catch (err) {
            // don't break the rest of the badge script on API errors
            console.error('Error fetching/parsing vFairs token info', err);
          }
        })();
      }
    });
  })();
</script>
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
        src="<?= base_url('images/176254824807-11-2025-escarapelas-foro-gastroenterologi-a-png1762548248.png') ?>"
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