let boxes = document.querySelectorAll('.box');
let resetBtn = document.querySelector('#reset');
let newGameBtn = document.querySelector('#new-btn');
let msgContainer = document.querySelector('#win-container');
let msg = document.querySelector('#msg');
let turnContainer = document.querySelector('#turn-container');
let turnMsg = document.querySelector('#turn-msg');
let p1Score = document.querySelector('#p1-score');
let p2Score = document.querySelector('#p2-score');
let p1Display = document.querySelector('#p1-display-name');
let p2Display = document.querySelector('#p2-display-name');
let scoreBoard = document.querySelector('#score-board');

let p1Input = document.querySelector('#p1-name');
let p2Input = document.querySelector('#p2-name');
let startBtn = document.querySelector('#start-btn');

let turnO = true;
let player1Wins = 0;
let player2Wins = 0;
let player1 = "Player 1";
let player2 = "Player 2";

const winPatterns = [
    [0,1,2],[3,4,5],[6,7,8],
    [0,3,6],[1,4,7],[2,5,8],
    [0,4,8],[2,4,6]
];

startBtn.addEventListener('click', () => {
    player1 = p1Input.value || "Player 1";
    player2 = p2Input.value || "Player 2";

    p1Display.innerText = player1;
    p2Display.innerText = player2;

    document.querySelector('.name-inputs').classList.add('hide');
    scoreBoard.classList.remove('hide');

    updateTurnPopup(turnO ? player2 : player1);
});

const updateTurnPopup = (name) => {
    turnMsg.innerText = `${name}'s Turn`;
    turnContainer.classList.remove('hide');
    setTimeout(() => turnContainer.classList.add('hide'), 1000);
};

boxes.forEach((box) => {
    box.addEventListener('click', function () {
        if (turnO) {
            box.innerText = 'O';
            box.style.color = 'green';
            updateTurnPopup(player1);
        } else {
            box.innerText = 'X';
            box.style.color = 'black';
            updateTurnPopup(player2);
        }
        box.disabled = true;
        checkWinner();
        turnO = !turnO;
    });
});

const enableBoxes = () => {
    boxes.forEach(box => {
        box.disabled = false;
        box.innerText = "";
    });
};

const disableBoxes = () => {
    boxes.forEach(box => box.disabled = true);
};

const showWinner = (winner) => {
    if (winner === 'X') {
        player1Wins++;
        p1Score.innerText = player1Wins;
        msg.innerText = `🎉 ${player1} (X) Wins!`;
    } else {
        player2Wins++;
        p2Score.innerText = player2Wins;
        msg.innerText = `🎉 ${player2} (O) Wins!`;
    }
    msgContainer.classList.remove('hide');
    disableBoxes();
};

const checkWinner = () => {
    for (let pattern of winPatterns) {
        let [a, b, c] = pattern;
        if (
            boxes[a].innerText !== "" &&
            boxes[a].innerText === boxes[b].innerText &&
            boxes[b].innerText === boxes[c].innerText
        ) {
            showWinner(boxes[a].innerText);
            return;
        }
    }

    const isDraw = [...boxes].every((box) => box.innerText !== "");
    if (isDraw) {
        msg.innerText = '😐 Match Drawn!';
        msgContainer.classList.remove('hide');
    }
};

const resetGame = () => {
    turnO = true;
    enableBoxes();
    msgContainer.classList.add('hide');
};

newGameBtn.addEventListener('click', resetGame);
resetBtn.addEventListener('click', resetGame);
