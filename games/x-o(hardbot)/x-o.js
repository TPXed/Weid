let currentPlayer = "X";
let gameEnded = false;
let board = ["","","","","","","","","",];
const winPatterns = [
    [0,1,2], [3,4,5], [6,7,8], 
    [0,3,6], [1,4,7], [2,5,8], 
    [0,4,8], [2,4,6], 
];

function checkWinner(player) {
    for (const pattern of winPatterns) {
        const [a,b,c] = pattern;
        if (board[a] === player && board[b] === player && board[c] === player) {
            return true;
        }
    }
    return false;
}
function isBoardFull() {
    return board.every(cell => cell !== "");
}

function cellClicked(cellIndex) {
    if (!gameEnded && board[cellIndex] === "") {
        const cell = document.getElementById(`cell${cellIndex}`);
        cell.textContent = currentPlayer;
        cell.setAttribute('data-value', currentPlayer);
        board[cellIndex] = currentPlayer;
        if (checkWinner(currentPlayer)) {
            document.getElementById("message").textContent = `Игрок ${currentPlayer} победил!`;
            gameEnded = true;
        } else if (isBoardFull()) {
            document.getElementById("message").textContent = "Ничья!";
            gameEnded = true;
        } else {
            currentPlayer = currentPlayer === "X" ? "O" : "X";
            if (currentPlayer === "O") {
                setTimeout(botMove, 3);
            }
        }
    }
}

function botMove() {
   let bestScore = -Infinity;
   let bestMove;
   for (let i =0; i < board.length; i++) {
    if (board[i] === "") {
        board[i] = "O";
        let score = minimax(board, 0 ,false);
        board[i] = "";
        if (score > bestScore) {
            bestScore = score;
            bestMove = i;
        }
    }
   }
const cell = document.getElementById(`cell${bestMove}`);
cell.textContent = currentPlayer;
cell.setAttribute('data-value', currentPlayer);
board[bestMove] = currentPlayer;
if (checkWinner(currentPlayer)) {
    document.getElementById("message").textContent = `Игрок ${currentPlayer} победил!`;
    gameEnded = true;
} else if (isBoardFull()) {
    document.getElementById("message").textContent = "Ничья!";
    gameEnded = true;
} else {
    currentPlayer = currentPlayer === "X" ? "O" : "X";
    }
}
function minimax(board, depth, isMaximizing) {
if (checkWinner("X")) {
    return -10;
} else if (checkWinner("O")){
    return 10;
} else if (isBoardFull()){
    return 0;
}
if (isMaximizing) {
    let bestScore = -Infinity;
    for (let i = 0; i < board.length; i++) {
        if (board[i] === "") {
            board[i] = "O";
            let score = minimax(board, depth + 1, false);
            board[i] = "";
            bestScore = Math.max(score, bestScore);
            }
        }
       return bestScore;
} else {
    let bestScore = Infinity;
    for (let i = 0; i < board.length; i++) {
        if (board[i] === "") {
            board[i] = "X";
            let score = minimax(board, depth + 1, true);
            board[i] = "";
            bestScore = Math.min(score, bestScore);
            }
        }
       return bestScore;
    }
}

