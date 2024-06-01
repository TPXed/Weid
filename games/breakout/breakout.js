let board;
let bWidth = 500;
let bHeight = 500;
let context;

let pWidth = 80;
let pHeight = 10;
let pX = 10;

let player = {
    x : 210,
    y : 480,
    width: pWidth,
    height: pHeight,
    vX: pX
}

let ballWidth = 10;
let ballHeight = 10;
let ballVX = 3;
let ballVY = 2;

let ball = {
    x : 250,
    y : 250,
    width: ballWidth,
    height: ballHeight,
    vX : ballVX,
    vY : ballVY
}

let blockArray = [];
let blockWidth = 50;
let blockHeight = 10;
let blockColumns = 8;
let blockRows = 3;
let blockMaxRows = 10;
let blockCount = 0;
let blockX = 15;
let blockY = 45;

let score = 0;
let gameOver = false;

window.onload = function() {
    board = document.getElementById("board");
    board.height = bHeight;
    board.width = bWidth;
    context = board.getContext("2d");
    context.fillStyle="black";
    context.fillRect(0,0, board.width, board.height);
    context.fillStyle="orange";
    context.fillRect(player.x, player.y, player.width, player.height);
    requestAnimationFrame(update);
    document.addEventListener("keydown", movePlayer);
    createBlocks();
}
function createBlocks() {
    blockArray = [];
    for (let c = 0; c < blockColumns; c++) {
        for (let r = 0; r < blockRows; r++) {
            let block = {
                x : blockX + c*blockWidth + c*10,
                y : blockY + r*blockHeight + r*10,
                width : blockWidth,
                height : blockHeight,
                break : false
            }
            blockArray.push(block);
        }
    }
    blockCount = blockArray.length;
}
function outBoard(xPos) {
    return (xPos < 0 || xPos + pWidth  > bWidth);
}
function movePlayer(e) {
    if (gameOver) {
    if (e.code == "Space"){
        resetGame();
    }
}
    if (e.code == "KeyA") {
        let nextX = player.x - player.vX;
        if (!outBoard(nextX)) {
        player.x = nextX;
        }
    } 
    else if (e.code == "KeyD") {
        let nextX = player.x + player.vX;
        if (!outBoard(nextX)) {
        player.x = nextX;
        }
    }
}
function update() {
    requestAnimationFrame(update);
if (gameOver) {
    return;
    }
    context.clearRect(0, 0, board.width, board.height);
    context.fillStyle = "black";
    context.fillRect(0, 0, board.width, board.height);
    context.fillStyle = "orange";
    context.fillRect(player.x, player.y, player.width, player.height);
    context.fillStyle = "red";
    ball.x += ball.vX;
    ball.y += ball.vY;
    context.fillRect(ball.x, ball.y, ball.width, ball.height);
    if (tCollision(ball, player) || bCollision(ball, player)) {
        ball.vY *= -1;
    }
    else if (lCollision(ball, player) || rCollision(ball, player)) {
        ball.vX *= -1;
    }
    else if (ball.y + ball.height >= bHeight) {
        sendScoreToServer(score);
    context.font = "20px sans-serif";
    context.fillText("Game Over: Press 'Space' to Restart", 80, 400);
    gameOver = true;
}    

context.fillStyle = "lightgreen";
 for (let i = 0; i < blockArray.length; i++) {
    let block = blockArray[i];
if (!block.break) {
    if (tCollision(ball, block) || bCollision(ball, block)) {
       block.break = true;
      ball.vY *= -1;
     blockCount -= 1;
     score += 1;
}
    else if (lCollision(ball, block) || rCollision(ball, block)) {
    block.break = true;
    ball.vX *= -1;
    blockCount -= 1;
    score += 1;
}
context.fillRect(block.x, block.y, block.width, block.height);
    }
}
function resetGame() {
    gameOver = false;
    player = {
    x : 210,
    y : 480,
    width: pWidth,
    height: pHeight,
    vX: pX
}
ball = {
    x : 250,
    y : 250,
    width: ballWidth,
    height: ballHeight,
    vX : ballVX,
    vY : ballVY
}
blockArray = [];
blockRows = 3;
score = 0;
createBlocks();
}
if (blockCount == 0) {
   blockRows = Math.min(blockRows + 1, blockMaxRows);
   createBlocks();
   }
context.fillStyle = "skyblue";
context.font = "20px sans-serif";
context.fillText(score, 10, 25);
    if (ball.y <= 0) {
        ball.vY *= -1;
    }
    else if (ball.x <= 0 || (ball.x + ball.width >= bWidth)) {
        ball.vX *= -1;
    }
    else if (ball.y + ball.height >= bHeight) {
    }
}
function Collision (a, b) {
    return a.x < b.x + b.width &&
           a.x + a.width > b.x &&
           a.y < b.y + b.height &&
           a.y + a.height > b.y;
}

function tCollision(ball, block) {
    return Collision(ball, block) && (ball.y + ball.height) >= ball.y;
}

function bCollision(ball, block) {
    return Collision(ball, block) && (block.y + block.height) >= ball.y;
}

function lCollision(ball, block) {
    return Collision(ball, block) && (ball.x + ball.width) >= ball.x;
}

function rCollision(ball, block) {
    return Collision(ball, block) && (block.y + block.height) >= ball.x;
}

function resetGame() {
    gameOver = false;
    player = {
        x : 210,
        y : 480,
        width: pWidth,
        height: pHeight,
        vX: pX
    }
    ball = {
        x : 250,
        y : 250,
        width: ballWidth,
        height: ballHeight,
        vX : ballVX,
        vY : ballVY
}
blockArray = [];
blockRows = 3;
score = 0;
createBlocks();
}

if (blockCount == 0) {
   blockRows = Math.min(blockRows + 1, blockMaxRows);
   createBlocks();
   }
   function sendScoreToServer(score) {
    let formData = new FormData();
    formData.append('score', score);

    fetch('save_score.php', {
      method: 'POST',
      body: formData  
    })
    .then(Response => {
        if (!Response.ok) {
            throw new error('Сервер выдает ошибку');
        }
        return Response.text();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Выполнить запрос не удалось', error);
    });
   }
