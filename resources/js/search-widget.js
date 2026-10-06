/**
 * Hero search widget: tabs (Boat / Where To?), custom dropdowns, a calendar
 * date picker, the guests stepper and the from/to swap. Everything is plain
 * DOM so it works on any page that includes `partials.search.widget`.
 */

const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const DAYS = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];

const pad = (n) => String(n).padStart(2, '0');
const toIso = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
const fromIso = (s) => {
    const [y, m, d] = (s || '').split('-').map(Number);
    return y && m && d ? new Date(y, m - 1, d) : null;
};
const pretty = (d) => d.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });

/* ---------------------------------------------------------------- popovers */
const closeAll = (except = null) => {
    document.querySelectorAll('[data-pop].is-open').forEach((el) => {
        if (el !== except) {
            el.classList.remove('is-open');
            el.querySelector('[data-pop-trigger]')?.setAttribute('aria-expanded', 'false');
        }
    });
};

document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-pop-trigger]');
    if (trigger) {
        const pop = trigger.closest('[data-pop]');
        const willOpen = !pop.classList.contains('is-open');
        closeAll(pop);
        pop.classList.toggle('is-open', willOpen);
        trigger.setAttribute('aria-expanded', String(willOpen));
        if (willOpen) {
            pop.querySelector('[data-pop-filter]')?.focus({ preventScroll: true });
            // On small screens make sure the opened panel is not hidden under the fixed tab bar.
            const panel = pop.querySelector('[data-pop-panel]');
            setTimeout(() => {
                const rect = panel?.getBoundingClientRect();
                const limit = window.innerHeight - (window.innerWidth < 1024 ? 100 : 20);
                if (rect && rect.bottom > limit) {
                    window.scrollBy({ top: rect.bottom - limit, behavior: 'smooth' });
                }
            }, 60);
        }
        return;
    }
    if (!e.target.closest('[data-pop-panel]')) {
        closeAll();
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAll();
});

/* --------------------------------------------------------------- dropdowns */
const setDropdown = (root, value, label) => {
    const input = root.querySelector('input[type="hidden"]');
    const display = root.querySelector('[data-dropdown-label]');
    input.value = value;
    display.textContent = label || display.dataset.placeholder;
    display.classList.toggle('is-placeholder', !value);
    root.querySelectorAll('[data-option]').forEach((opt) => {
        opt.classList.toggle('is-selected', opt.dataset.value === value);
    });
    root.dispatchEvent(new CustomEvent('dropdown:change', { bubbles: true, detail: { value } }));
};

document.querySelectorAll('[data-dropdown]').forEach((root) => {
    root.querySelectorAll('[data-option]').forEach((opt) => {
        opt.addEventListener('click', () => {
            setDropdown(root, opt.dataset.value, opt.dataset.label);
            closeAll();
        });
    });

    const filter = root.querySelector('[data-pop-filter]');
    filter?.addEventListener('input', () => {
        const q = filter.value.trim().toLowerCase();
        root.querySelectorAll('[data-option]').forEach((opt) => {
            opt.hidden = q !== '' && !opt.dataset.label.toLowerCase().includes(q) && !(opt.dataset.group || '').toLowerCase().includes(q);
        });
        root.querySelectorAll('[data-option-group]').forEach((group) => {
            group.hidden = !group.querySelector('[data-option]:not([hidden])');
        });
    });
});

/* ------------------------------------------------------------------ swap */
document.querySelectorAll('[data-swap]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const form = btn.closest('form');
        const from = form.querySelector('[data-dropdown="from"]');
        const to = form.querySelector('[data-dropdown="to"]');
        if (!from || !to) return;
        const a = { v: from.querySelector('input').value, l: from.querySelector('[data-dropdown-label]').textContent };
        const b = { v: to.querySelector('input').value, l: to.querySelector('[data-dropdown-label]').textContent };
        setDropdown(from, b.v, b.v ? b.l : '');
        setDropdown(to, a.v, a.v ? a.l : '');
        btn.classList.remove('is-spun');
        void btn.offsetWidth;
        btn.classList.add('is-spun');
    });
});

/* ------------------------------------------------------------ datepicker */
document.querySelectorAll('[data-datepicker]').forEach((root) => {
    const input = root.querySelector('input[type="hidden"]');
    const display = root.querySelector('[data-date-label]');
    const grid = root.querySelector('[data-cal-grid]');
    const title = root.querySelector('[data-cal-title]');
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    let selected = fromIso(input.value);
    let view = new Date((selected || today).getFullYear(), (selected || today).getMonth(), 1);

    const render = () => {
        title.textContent = `${MONTHS[view.getMonth()]} ${view.getFullYear()}`;
        const first = (view.getDay() + 6) % 7; // Monday first
        const days = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();
        let html = DAYS.map((d) => `<span class="pg-cal-dow">${d}</span>`).join('');
        for (let i = 0; i < first; i++) html += '<span></span>';
        for (let d = 1; d <= days; d++) {
            const date = new Date(view.getFullYear(), view.getMonth(), d);
            const iso = toIso(date);
            const cls = ['pg-cal-day'];
            if (date < today) cls.push('is-past');
            if (+date === +today) cls.push('is-today');
            if (selected && +date === +selected) cls.push('is-selected');
            html += `<button type="button" class="${cls.join(' ')}" data-day="${iso}" ${date < today ? 'disabled' : ''}>${d}</button>`;
        }
        grid.innerHTML = html;
        const prev = root.querySelector('[data-cal-prev]');
        prev.disabled = view.getFullYear() === today.getFullYear() && view.getMonth() === today.getMonth();
    };

    const choose = (date) => {
        selected = date;
        input.value = date ? toIso(date) : '';
        display.textContent = date ? pretty(date) : display.dataset.placeholder;
        display.classList.toggle('is-placeholder', !date);
        render();
    };

    root.querySelector('[data-cal-prev]').addEventListener('click', () => { view.setMonth(view.getMonth() - 1); render(); });
    root.querySelector('[data-cal-next]').addEventListener('click', () => { view.setMonth(view.getMonth() + 1); render(); });
    grid.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-day]');
        if (!btn) return;
        choose(fromIso(btn.dataset.day));
        setTimeout(closeAll, 140);
    });
    root.querySelectorAll('[data-cal-quick]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const d = new Date(today);
            d.setDate(d.getDate() + Number(btn.dataset.calQuick));
            view = new Date(d.getFullYear(), d.getMonth(), 1);
            choose(d);
            setTimeout(closeAll, 140);
        });
    });

    if (selected) display.textContent = pretty(selected);
    render();
});

/* ---------------------------------------------------------------- guests */
document.querySelectorAll('[data-guests]').forEach((root) => {
    const input = root.querySelector('input');
    const min = Number(input.min || 1);
    const max = Number(input.max || 20);
    const clamp = (v) => Math.min(max, Math.max(min, Number.isFinite(v) ? v : min));
    const sync = () => {
        root.querySelector('[data-guests-minus]').disabled = Number(input.value) <= min;
        root.querySelector('[data-guests-plus]').disabled = Number(input.value) >= max;
    };
    const bump = () => {
        input.classList.remove('is-bumped');
        void input.offsetWidth;
        input.classList.add('is-bumped');
    };
    root.querySelector('[data-guests-minus]').addEventListener('click', () => { input.value = clamp(Number(input.value) - 1); bump(); sync(); });
    root.querySelector('[data-guests-plus]').addEventListener('click', () => { input.value = clamp(Number(input.value) + 1); bump(); sync(); });
    input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 2);
        sync();
    });
    input.addEventListener('blur', () => { input.value = clamp(parseInt(input.value, 10)); sync(); });
    sync();
});

/* ------------------------------------------------------------------ tabs */
document.querySelectorAll('[data-search-tabs]').forEach((root) => {
    const tabs = root.querySelectorAll('[data-tab]');
    const panels = root.querySelectorAll('[data-tab-panel]');
    const indicator = root.querySelector('[data-tab-indicator]');

    const move = (tab) => {
        if (!indicator) return;
        indicator.style.width = `${tab.offsetWidth}px`;
        indicator.style.transform = `translateX(${tab.offsetLeft}px)`;
    };

    const activate = (name) => {
        tabs.forEach((t) => {
            const on = t.dataset.tab === name;
            t.classList.toggle('is-active', on);
            t.setAttribute('aria-selected', String(on));
            if (on) move(t);
        });
        panels.forEach((p) => {
            const on = p.dataset.tabPanel === name;
            p.hidden = !on;
            if (on) {
                p.classList.remove('pg-panel-in');
                void p.offsetWidth;
                p.classList.add('pg-panel-in');
            }
        });
        closeAll();
    };

    tabs.forEach((t) => t.addEventListener('click', () => activate(t.dataset.tab)));
    const initial = root.querySelector('[data-tab].is-active') || tabs[0];
    requestAnimationFrame(() => move(initial));
    window.addEventListener('resize', () => move(root.querySelector('[data-tab].is-active') || tabs[0]));
});

/* Destination search: require a location before leaving the page. */
document.querySelectorAll('[data-where-form]').forEach((form) => {
    form.addEventListener('submit', (e) => {
        const value = form.querySelector('input[name="location"]').value;
        if (!value) {
            e.preventDefault();
            const field = form.querySelector('[data-dropdown="location"]');
            field.classList.remove('is-shaking');
            void field.offsetWidth;
            field.classList.add('is-shaking');
            field.querySelector('[data-pop-trigger]').click();
        }
    });
});
