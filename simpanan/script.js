const gameArea = document.getElementById('game-area');
const scoreDisplay = document.getElementById('score');
const timeDisplay = document.getElementById('time');
const startBtn = document.getElementById('start-btn');

let score = 0;
let timeLeft = 30;
let gameInterval, timerInterval;

function startGame() {
    score = 0;
    timeLeft = 30;
    scoreDisplay.textContent = score;
    timeDisplay.textContent = timeLeft;
    startBtn.disabled = true;
    gameArea.innerHTML = '';

    timerInterval = setInterval(() => {
        timeLeft--;
        timeDisplay.textContent = timeLeft;
        if (timeLeft <= 0) endGame();
    }, 1000);

    spawnCircle();
    gameInterval = setInterval(spawnCircle, 800);
}

function spawnCircle() {
    const circle = document.createElement('div');
    circle.classList.add('circle');

    const x = Math.random() * (gameArea.clientWidth - 40);
    const y = Math.random() * (gameArea.clientHeight - 40);

    circle.style.left = `${x}px`;
    circle.style.top = `${y}px`;

    circle.addEventListener('click', () => {
        score++;
        scoreDisplay.textContent = score;
        circle.remove();
    });

    gameArea.appendChild(circle);

    // Hilangkan circle setelah 1 detik kalau gak diklik
    setTimeout(() => {
        circle.remove();
    }, 1000);
}

function endGame() {
    clearInterval(gameInterval);
    clearInterval(timerInterval);
    startBtn.disabled = false;
    gameArea.innerHTML = '';
    alert(`Waktu habis! Skor akhir kamu: ${score}`);
}

startBtn.addEventListener('click', startGame);