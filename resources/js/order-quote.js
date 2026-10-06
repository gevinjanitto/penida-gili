/**
 * Live total on the order pages.
 *
 * The form carries `data-quote` (unit prices, nights, guests-per-room). Party
 * steppers (`adults`, `children`, `rooms`) drive the numbers; everything with
 * `data-quote-total` / `data-quote-line` is rewritten as they change. Hotel
 * stays auto-add rooms when guests exceed the per-room capacity, but the
 * guest may always book more rooms than strictly needed.
 */
const idr = (n) => 'IDR ' + Math.round(n).toLocaleString('id-ID');

document.querySelectorAll('form[data-quote]').forEach((form) => {
    let quote;
    try {
        quote = JSON.parse(form.dataset.quote);
    } catch {
        return;
    }

    const field = (name) => form.querySelector(`input[name="${name}"]`);
    const adults = field('adults');
    const children = field('children');
    const rooms = field('rooms');

    if (!adults) {
        return;
    }

    const num = (input, fallback = 0) => (input ? Math.max(Number(input.min || 0), Number(input.value) || fallback) : fallback);

    /**
     * Write the breakdown rows: `texts` maps a `data-quote-row` name to its copy, and
     * `hide` maps a row kind to whether both of its cells should disappear.
     */
    const rows = (texts, hide = {}) => {
        Object.entries(texts).forEach(([name, text]) => {
            document.querySelectorAll(`[data-quote-row="${name}"]`).forEach((el) => {
                el.textContent = text;
                el.hidden = hide[name.split('-')[0]] === true;
            });
        });
    };

    // Boat orders: Indonesian passports pay domestic fares, everyone else the foreign fare.
    const nationality = form.querySelector('select[name="nationality"]');

    const applyFare = () => {
        if (!quote.fares) return;

        const value = nationality ? nationality.value : '';
        const type = !value || value === quote.domesticNationality ? 'domestic' : 'foreign';

        quote.fareType = type;
        quote.unitAdult = quote.fares[type].adult;
        quote.unitChild = quote.fares[type].child;

        form.querySelectorAll('[data-fare-col]').forEach((col) => col.classList.toggle('is-active', col.dataset.fareCol === type));
        form.querySelectorAll('[data-quote-fare-label]').forEach((el) => { el.textContent = type === 'foreign' ? 'Foreign fare' : 'Domestic fare'; });
        form.querySelectorAll('[data-quote-unit="adults"]').forEach((el) => { el.textContent = `${idr(quote.unitAdult)} / adult`; });
        form.querySelectorAll('[data-quote-unit="children"]').forEach((el) => { el.textContent = `${idr(quote.unitChild)} / child`; });
    };

    const render = () => {
        applyFare();
        const a = num(adults, 1);
        const c = num(children);
        let total;
        let lineLabel = '';
        let lineAmount = '';

        if (quote.perRoom) {
            const needed = Math.max(1, Math.ceil((a + c) / quote.guestsPerRoom));
            let r = rooms ? num(rooms, 1) : 1;

            r = Math.max(r, needed);
            if (rooms) {
                rooms.min = String(needed);
                if (rooms.value !== String(r)) {
                    rooms.value = String(r);
                }
            }

            const roomsTotal = quote.unitAdult * quote.nights * r;
            const extraAdults = Math.max(0, a - (quote.includedAdults || 0) * r);
            const surcharge = extraAdults * (quote.extraAdultPrice || 0);

            total = roomsTotal + surcharge;
            lineLabel = `${idr(quote.unitAdult)} x ${quote.nights} night${quote.nights > 1 ? 's' : ''}${r > 1 ? ` x ${r} rooms` : ''}`;
            lineAmount = idr(roomsTotal);

            document.querySelectorAll('[data-quote-adult-hint]').forEach((el) => {
                el.textContent = extraAdults === 0
                    ? 'Included in room rate'
                    : `+Rp ${Math.round(quote.extraAdultPrice).toLocaleString('id-ID')} / extra adult`;
            });

            document.querySelectorAll('[data-quote-extra]').forEach((el) => {
                if (el.dataset.quoteExtra === 'label') el.textContent = `${extraAdults} Extra Adult${extraAdults > 1 ? 's' : ''} x ${idr(quote.extraAdultPrice)}`;
                else if (el.dataset.quoteExtra === 'amount') el.textContent = idr(surcharge);
                // Wrapper rows and bare grid cells alike disappear when there is no surcharge.
                el.hidden = extraAdults === 0;
            });
        } else {
            total = a * quote.unitAdult + c * quote.unitChild;

            // Per-guest breakdown rows follow the steppers; the child row hides at zero.
            rows({
                'adult-label': `${a} Adult${a > 1 ? 's' : ''}`,
                'adult-amount': idr(a * quote.unitAdult),
                'child-label': `${c} Child${c > 1 ? 'ren' : ''}`,
                'child-amount': idr(c * quote.unitChild),
            }, { child: c === 0 });
        }

        document.querySelectorAll('[data-quote-total]').forEach((el) => {
            el.textContent = el.dataset.quoteTotal === 'button' ? `Book Now – ${idr(total)}` : idr(total);
        });
        document.querySelectorAll('[data-quote-line="label"]').forEach((el) => { if (lineLabel) el.textContent = lineLabel; });
        document.querySelectorAll('[data-quote-line="amount"]').forEach((el) => { if (lineAmount) el.textContent = lineAmount; });
        document.querySelectorAll('[data-quote-people]').forEach((el) => { el.textContent = String(a + c); });
        document.querySelectorAll('[data-quote-adults]').forEach((el) => { el.textContent = `${a} Adult${a > 1 ? 's' : ''}`; });
        document.querySelectorAll('[data-quote-children]').forEach((el) => { el.textContent = c ? `${c} Child${c > 1 ? 'ren' : ''}` : ''; });
    };

    nationality?.addEventListener('change', render);

    [adults, children, rooms].filter(Boolean).forEach((input) => {
        input.addEventListener('change', render);
        input.addEventListener('input', render);
    });

    render();
});
