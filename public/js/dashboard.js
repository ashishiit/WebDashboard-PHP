// document.getElementById('schools-total').textContent = '372';
// document.getElementById('missions-total').textContent = '1,215';
// document.getElementById('players-total').textContent = '41,200';
// document.getElementById('time-stamp').textContent = '240952 : 44 : 51';
// document.getElementById('hours-total').textContent = '240,952';
// document.getElementById('games-total').textContent = '14';




async function fetchTotals() {
    const response = await fetch('/api/v1/totals');
    const totals = await response.json(); //extract JSON from the http response
    
    if (totals.schools_total)
        document.getElementById('schools-total').textContent = totals.schools_total.toLocaleString("en");
    if (totals.missions_total)
        document.getElementById('missions-total').textContent = totals.missions_total.toLocaleString("en");
    if (totals.players_total)
        document.getElementById('players-total').textContent = totals.players_total.toLocaleString("en");
    if (totals.games_total)
        document.getElementById('time-stamp').textContent = totals.time_stamp;
    if (totals.hours_total)
        document.getElementById('hours-total').textContent = totals.hours_total.toLocaleString("en");
    if (totals.games_total)
        document.getElementById('games-total').textContent = totals.games_total.toLocaleString("en");
}

let images = [
    '0b9e708660eacbcbe9a2626a22886ff1_f794.png',
    '15d62fab309541bbcd534c9ed531ce60_f753.png',
    '835fe3b950203b54dd0bf149b684c72f_f534.png',
    'fda915b6db95b78350c4c209e39e7dd9_f530.png',
    'fca8767d267a80fe8c67f6253edde189_f544.png',
    'f489cdb9a741d9fa6b29232555211432_f780.png',
    'ca3b82210e9f592b62dd7b1e76f08124_f532.png',
    '2ac867bfad6dd0f74995dd450b6cb58e_f797.png',
    '189265bd2d9241c4957038b3b814531a_f692.png',
    '07c4da8502d56b8753ca5a196122b232_f536.png',
    '8a33fd0f491e51f726ee8ca2fe7efd4f_f793.png',    
    '1248e81638b6e0e1897a74a7058c8ea2_f838.png',    
    'baa10273c4497dad457ef6c0476a185c_f540.png',    
    'dda994091a929a668cc73c873d25bf8c_f542.png',
    'f52dbc9eb4fdcb06bd39ca53e7bf74b0_f538.png',
];
async function fetchGames() {
    const response = await fetch('/api/v1/games');
    const games = await response.json();
    console.log("Displaying Games")
    console.log(games)
    let gamesContainer = document.getElementById('games-container');
    console.log("Games Container")
    console.log(gamesContainer)
    for (let i = 0; i < games.length; i++) {

        let newBlock = `
            <div class="game-img">
                <img src="/img/`+ images[i] + `">
            </div>
            <div class="game-description">
                <h3>`+ games[i].name + `</h3>
                <p>`+ games[i].topic + `</p>
            </div>
            <div class="game-stat">
                <div class="game-stat-container">
                    <div class="stat-item game-total-players y-border">
                        <span>`+ games[i].total_players.toLocaleString("en") + `</span>
                        <p>total players</p>
                    </div>

                    <div class="stat-item game-hours-played y-border">
                        <span>`+ games[i].hours_played.toLocaleString("en") + `</span>
                        <p>total hours played</p>
                    </div>
                    <div class="stat-item game-mission-completed">
                        <span>`+ games[i].mission_completed.toLocaleString("en") + `</span>
                        <p>missions completed</p>
                    </div>
                </div>
            </div>
       `;
        var div = document.createElement('div');
        div.setAttribute('class', 'game-row');
        div.innerHTML = newBlock;

        gamesContainer.appendChild(div);

    }
}
fetchTotals();
fetchGames();