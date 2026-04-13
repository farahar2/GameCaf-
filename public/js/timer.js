document.addEventListener('DOMContentLoaded', function () {
    const timerEl = document.querySelector('.session-timer');
    if (!timerEl) {
        return;
    }

    let seconds = 0;
    setInterval(() => {
        seconds += 1;
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        timerEl.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }, 1000);
});
