{{--
    Brand intro / loading screen (modelled on crm-maiharta.vercel.app/login):
    deep-sea backdrop with slowly breathing orbit rings and drifting satellites,
    the boat mark fading in, the name sliding up out of a mask, the tagline,
    a thin progress bar and a footer line. Shown once per browser session; skipped
    for prefers-reduced-motion. CSS + JS are inline so it paints before the bundle.
--}}
<script>
    try {
        if (sessionStorage.getItem('pg-intro-seen') || matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('pg-intro-skip');
        } else {
            document.documentElement.classList.add('pg-intro-lock');
        }
    } catch (e) {}
</script>
<style>
    .pg-intro-skip #pg-intro { display: none !important; }
    .pg-intro-lock, .pg-intro-lock body { overflow: hidden !important; }

    #pg-intro {
        position: fixed; inset: 0; z-index: 10000; isolation: isolate; overflow: hidden;
        display: grid; place-items: center; color: #fff; cursor: progress;
        background: radial-gradient(ellipse at 50% 80%, #1d63a0 0, #134a7c 54%, #0e3a63 100%);
        font-family: 'Manrope', ui-sans-serif, system-ui, sans-serif;
        transition: opacity .65s cubic-bezier(.22,1,.36,1), visibility .65s;
    }
    #pg-intro.is-leaving { opacity: 0; visibility: hidden; }
    #pg-intro.is-leaving .pg-intro-content { transform: scale(1.04); opacity: 0; }

    /* Orbit system */
    .pg-orbit { position: absolute; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; }
    .pg-orbit-system { position: absolute; left: 50%; top: 50%; width: min(680px, 110vw); aspect-ratio: 1; transform: translate(-50%, -50%); }
    .pg-orbit-ring { position: absolute; inset: 0; border-radius: 50%; border: 1px solid rgba(189, 218, 255, .09); animation: pg-orbit-wave 20s ease-in-out infinite; }
    .pg-orbit-ring.r2 { inset: 10%; animation-delay: -5s; border-color: rgba(189, 218, 255, .12); }
    .pg-orbit-ring.r3 { inset: 21%; animation-delay: -10s; border-color: rgba(189, 218, 255, .1); background: rgba(140, 191, 255, .03); }
    .pg-orbit-ring.r4 { inset: 32%; animation-delay: -15s; border-color: rgba(189, 218, 255, .09); }
    .pg-orbit-path { --orbit-start: 0deg; position: absolute; inset: -1px; border-radius: 50%; animation: pg-orbit-rev 48s linear infinite; }
    .r2 .pg-orbit-path { animation-duration: 68s; animation-direction: reverse; }
    .r3 .pg-orbit-path { animation-duration: 84s; }
    .r4 .pg-orbit-path { animation-duration: 104s; animation-direction: reverse; }
    .pg-sat { position: absolute; left: 50%; top: 0; width: 9px; height: 9px; border-radius: 50%; transform: translate(-50%, -50%);
              background: #b5d6f6; box-shadow: 0 0 0 6px rgba(181, 214, 246, .07); opacity: .4; }
    .pg-sat.alt { width: 7px; height: 7px; background: #7cd8da; }
    @keyframes pg-orbit-wave { 0%, 100% { opacity: .6; transform: scale(.94); } 50% { opacity: 1; transform: scale(1.06); } }
    @keyframes pg-orbit-rev { from { transform: rotate(var(--orbit-start)); } to { transform: rotate(calc(var(--orbit-start) + 1turn)); } }

    /* Content */
    .pg-intro-content { display: flex; flex-direction: column; align-items: center; padding: 32px; text-align: center;
                        transition: transform .65s cubic-bezier(.22,1,.36,1), opacity .5s; }
    .pg-intro-mark { width: 112px; height: 56px; margin-bottom: 26px; opacity: 0; transform: translateY(10px) scale(.86);
                     animation: pg-intro-in .8s cubic-bezier(.22,1,.36,1) .15s forwards; }
    .pg-intro-mark img { width: 100%; height: 100%; object-fit: contain; animation: pg-intro-bob 3.2s ease-in-out 1s infinite; }
    .pg-intro-mask { overflow: hidden; }
    .pg-intro-name { margin: 0; font-size: clamp(26px, 4vw, 36px); font-weight: 400; letter-spacing: .14em; line-height: 1.35;
                     transform: translateY(105%); animation: pg-intro-rise .9s cubic-bezier(.22,1,.36,1) .4s forwards; }
    .pg-intro-name b { font-weight: 800; }
    .pg-intro-tag { margin: 12px 0 0; font-size: 10px; letter-spacing: .4em; color: #b2d3f0; opacity: 0;
                    animation: pg-intro-tag .9s cubic-bezier(.22,1,.36,1) .85s forwards; }
    .pg-intro-progress { width: 150px; height: 2px; margin-top: 30px; overflow: hidden; border-radius: 2px; background: rgba(255,255,255,.12); }
    .pg-intro-progress span { display: block; width: 100%; height: 100%; background: #89d5df; transform: scaleX(0); transform-origin: left;
                              animation: pg-intro-bar 2s cubic-bezier(.65,0,.35,1) .3s forwards; }
    #pg-intro.is-ready .pg-intro-progress span { animation: none; transform: scaleX(1); transition: transform .35s ease-out; }
    .pg-intro-footer { position: absolute; bottom: 36px; left: 0; right: 0; text-align: center; font-size: 11px; letter-spacing: .06em;
                       color: #9ebbdc; opacity: 0; animation: pg-intro-tag .9s ease 1.1s forwards; }

    @keyframes pg-intro-in   { to { opacity: 1; transform: none; } }
    @keyframes pg-intro-rise { to { transform: translateY(0); } }
    @keyframes pg-intro-tag  { to { opacity: 1; letter-spacing: .24em; } }
    @keyframes pg-intro-bar  { 0% { transform: scaleX(0); } 60% { transform: scaleX(.72); } 100% { transform: scaleX(.92); } }
    @keyframes pg-intro-bob  { 0%, 100% { transform: translateY(0) rotate(0); } 50% { transform: translateY(-4px) rotate(-2deg); } }

    @media (max-width: 640px) {
        .pg-intro-mark { width: 96px; height: 48px; }
        .pg-orbit-system { width: 130vw; }
    }
</style>

<div id="pg-intro" role="status" aria-live="polite" data-testid="brand-intro">
    <div class="pg-orbit" aria-hidden="true">
        <div class="pg-orbit-system">
            @foreach ([['r1', [-55, 65, 185]], ['r2', [15, 135, 255]], ['r3', [-25, 155]], ['r4', [65, 245]]] as [$ring, $starts])
                <div class="pg-orbit-ring {{ $ring }}">
                    @foreach ($starts as $i => $deg)
                        <div class="pg-orbit-path" style="--orbit-start: {{ $deg }}deg"><span @class(['pg-sat', 'alt' => $i % 2 === 1])></span></div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <div class="pg-intro-content">
        <div class="pg-intro-mark"><img src="{{ asset('images/logo/logo-mark-light.svg') }}" alt="Penida Gili"></div>
        <div class="pg-intro-mask"><h1 class="pg-intro-name" data-testid="brand-intro-name">PENIDA <b>GILI</b></h1></div>
        <p class="pg-intro-tag">THE ISLAND FAST CRUISE</p>
        <div class="pg-intro-progress" aria-hidden="true"><span></span></div>
        <span class="sr-only">Loading Penida Gili…</span>
    </div>

    <span class="pg-intro-footer">Explore tropical island beauty without limits.</span>
</div>

<script>
    (function () {
        var root = document.documentElement, el = document.getElementById('pg-intro');
        if (!el) return;
        if (root.classList.contains('pg-intro-skip')) { el.remove(); return; }

        var started = Date.now(), MIN = 2300, MAX = 5000, done = false;

        function finish() {
            if (done) return;
            done = true;
            try { sessionStorage.setItem('pg-intro-seen', '1'); } catch (e) {}
            el.classList.add('is-ready');
            setTimeout(function () {
                el.classList.add('is-leaving');
                root.classList.remove('pg-intro-lock');
                setTimeout(function () { el.remove(); }, 700);
            }, 320);
        }

        function onLoad() { setTimeout(finish, Math.max(0, MIN - (Date.now() - started))); }

        if (document.readyState === 'complete') onLoad(); else window.addEventListener('load', onLoad);
        setTimeout(finish, MAX);          // never hold the page hostage on a slow asset
        el.addEventListener('click', finish); // tap to skip
    })();
</script>
