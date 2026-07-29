<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Locked</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --accent: red;
            --warn: yellow;
        }
        * { box-sizing: border-box; }
        html, body {
            margin: 0; padding: 0;
            background: #000;
            color: var(--accent);
            font-family: "Courier New", monospace;
            height: 100%;
            overflow: hidden;
            user-select: none;
        }
        .screen {
            height: 100vh; width: 100vw;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; gap: 16px;
            animation: flicker 1s infinite alternate;
            padding: 20px;
        }
        h1 {
            font-size: clamp(38px, 6vw, 72px);
            text-transform: uppercase;
            text-shadow: 0 0 18px var(--accent), 0 0 4px #700;
            margin: 0 0 6px;
        }
        .subtitle {
            color: #fff; font-size: clamp(16px, 2.2vw, 24px);
        }
        .warning {
            color: var(--warn);
            font-weight: 700;
            text-transform: uppercase;
            font-size: clamp(16px, 2.4vw, 26px);
            letter-spacing: 1px;
            animation: blink 0.7s infinite;
            margin-top: 8px;
        }
        .countdown-wrap {
            margin-top: 14px;
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            border: 2px solid #400;
            background: #110000;
            box-shadow: 0 0 20px #b00;
            border-radius: 8px;
        }
        .label {
            color: #fff; font-weight: bold; text-transform: uppercase;
            font-size: clamp(14px, 1.8vw, 18px);
        }
        .timer {
            font-size: clamp(34px, 8vw, 84px);
            font-weight: 900;
            letter-spacing: 2px;
            color: var(--warn);
            text-shadow: 0 0 18px var(--warn), 0 0 4px #aa0;
            animation: throb 1.25s infinite ease-in-out;
            min-width: 8ch;
        }
        .terminal {
            width: min(900px, 90vw);
            height: 220px;
            background: #0b0b0b;
            color: #0f0;
            border: 2px solid #333;
            text-align: left;
            padding: 12px;
            margin-top: 18px;
            font-size: clamp(12px, 1.7vw, 16px);
            overflow: auto;
            box-shadow: 0 0 20px #900;
            line-height: 1.35;
        }
        .footer-note {
            color: #bbb; font-size: 12px; opacity: .4; margin-top: 6px;
        }

        @keyframes blink { 50% { opacity: 0; } }
        @keyframes flicker { 0% { opacity: 1; } 100% { opacity: .92; } }
        @keyframes throb {
            0%,100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }
        @keyframes shake {
            0% { transform: translateX(-4px); }
            100% { transform: translateX(4px); }
        }
        .panic { animation: shake .12s infinite alternate; }
        .hidden { display: none !important; }
        a { color: var(--warn); text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="screen" id="screen">
    <h1>⚠️ SYSTEM LOCKED ⚠️</h1>
    <div class="subtitle">Your files are encrypted. Access has been <b>terminated</b>.</div>
    <div class="warning">DO NOT CLOSE THIS WINDOW</div>

    {{-- <div class="countdown-wrap">
        <div class="label">TIME REMAINING</div>
        <div class="timer" id="timer">10:00</div>
    </div> --}}

    <div class="subtitle">To restore access, contact the system administrator immediately.</div>
    <div class="terminal" id="terminal"></div>

    <!-- Optional “contact” line to sell the effect (keep generic / safe) -->
    <div class="footer-note">Ref: LOCK-<span id="ref"></span></div>

    <audio autoplay loop id="alarm">
        <source src="https://www.soundjay.com/button/beep-07.wav" type="audio/wav">
    </audio>
</div>

<script>
    // ======== CONFIG ========
    // Change starting minutes if you want (e.g., 15)
    const START_MINUTES = 10;

    // ======== Fake terminal feed ========
    const terminal = document.getElementById("terminal");
    const lines = [
        "[*] Initializing AES-256 encryption module...",
        "[*] Scanning filesystem: /var/www/html ...",
        "[*] Encrypting database records (users, orders, sessions)...",
        "[*] Revoking authentication tokens...",
        "[*] Blocking inbound routes...",
        "[!] Public key exchange complete.",
        "[!] Private key stored securely.",
        "[*] System lockdown engaged.",
        "[#] Awaiting operator input..."
    ];
    let li = 0;
    function feed() {
        if (li < lines.length) {
            const el = document.createElement("div");
            el.textContent = lines[li];
            terminal.appendChild(el);
            terminal.scrollTop = terminal.scrollHeight;
            li++;
            setTimeout(feed, 1200);
        }
    }
    feed();

    // ======== Countdown logic ========
    const timerEl = document.getElementById("timer");
    const screen = document.getElementById("screen");
    const alarm = document.getElementById("alarm");

    let totalSeconds = START_MINUTES * 60;
    function renderTime(sec) {
        const m = Math.floor(sec / 60).toString().padStart(2, "0");
        const s = (sec % 60).toString().padStart(2, "0");
        timerEl.textContent = `${m}:${s}`;
    }
    renderTime(totalSeconds);

    const tick = setInterval(() => {
        totalSeconds--;
        if (totalSeconds <= 0) {
            clearInterval(tick);
            timerEl.textContent = "00:00";
            // Go into "panic" mode: faster flicker, stronger shake, louder beeps attempt
            screen.classList.add("panic");
            try { alarm.playbackRate = 1.6; } catch(e){}
            // Dramatic terminal lines
            const finale = [
                "[!] Deadline reached.",
                "[!] Session keys invalidated.",
                "[#] SYSTEM LOCKED. NO FURTHER ACTION PERMITTED."
            ];
            finale.forEach((t, idx) => setTimeout(() => {
                const el = document.createElement("div");
                el.textContent = t;
                terminal.appendChild(el);
                terminal.scrollTop = terminal.scrollHeight;
            }, 500 * (idx+1)));
        } else {
            renderTime(totalSeconds);
        }
    }, 1000);

    // ======== Fullscreen request (best-effort) ========
    document.addEventListener("DOMContentLoaded", () => {
        const docEl = document.documentElement;
        if (docEl.requestFullscreen) docEl.requestFullscreen().catch(()=>{});
        else if (docEl.webkitRequestFullscreen) docEl.webkitRequestFullscreen();
    });

    // ======== Disable right-click & common exits ========
    document.addEventListener("contextmenu", e => e.preventDefault());
    document.addEventListener("keydown", (e) => {
        // Block some keys (Esc, F11, F12, Ctrl+W, Ctrl+R, Ctrl+Shift+I, etc.)
        const k = e.key.toLowerCase();
        if (
            k === "f11" || k === "f12" || k === "escape" ||
            (e.ctrlKey && (k === "w" || k === "r")) ||
            (e.ctrlKey && e.shiftKey && (k === "i" || k === "j"))
        ) { e.preventDefault(); e.stopPropagation(); }
    });

    // ======== Trap back/forward navigation ========
    history.pushState(null, "", location.href);
    window.onpopstate = function () { history.go(1); };

    // ======== Random ref code for realism ========
    document.getElementById("ref").textContent =
        Math.random().toString(36).substring(2, 8).toUpperCase();
</script>
</body>
</html>
