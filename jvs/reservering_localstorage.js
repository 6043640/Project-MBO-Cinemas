document.addEventListener('DOMContentLoaded', function() {
    const naam = document.getElementById('naam');
    const email = document.getElementById('email');
    const film = document.getElementById('film');
    const datum = document.getElementById('datum');
    const aantal_kaartjes = document.getElementById('aantal_kaartjes');
    const form = document.querySelector('.reserveren-form');

    const opgeslagenReservering = localStorage.getItem('reservering');
    if (opgeslagenReservering) {
        const reservering = JSON.parse(opgeslagenReservering);
        naam.value = reservering.naam || '';
        email.value = reservering.email || '';
        film.value = reservering.film || '';
        datum.value = reservering.datum || '';
        aantal_kaartjes.value = reservering.aantal_kaartjes || '';
    }

    function slaReserveringOp() {
        const reservering = {
            naam: naam.value,
            email: email.value,
            film: film.value,
            datum: datum.value,
            aantal_kaartjes: aantal_kaartjes.value
        };
        localStorage.setItem('reservering', JSON.stringify(reservering));
    }

    [naam, email, film, datum, aantal_kaartjes].forEach(veld => {
        veld.addEventListener('input', slaReserveringOp);
    });

    form.addEventListener('submit', slaReserveringOp);
    window.addEventListener('beforeunload', slaReserveringOp);
});