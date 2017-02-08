<!-- Snail project -->
<html>
<script language="javascript">
var canvas;
var backgroundImg = new Image();
var snail1Img = new Image();
var snail2Img = new Image();
var snail3Img = new Image();
var winning1Img = new Image();
var winning2Img = new Image();
var winning3Img = new Image();
var winningImg; //which img to show
//var titleImg = new Image();
var bannerImg = new Image();
	
var PLAYING = 0;
var GAME_OVER = 1;
var gameState = GAME_OVER;
var RACE_WON = 2;

var SLOW = 5;
var MEDIUM = 8;
var FAST = 10;
var speed =
<?php
if ($_GET["speed"] != "")
{
	echo($_GET["speed"] . ";");
}
else
{
	echo("SLOW;");
}
?>
    
var SINGLE = 0;
var MULTI = 1;
var gameType = 
<?php
if ($_GET["gameType"] != "")
{
	echo($_GET["gameType"] . ";");
}
else
{
	echo("SINGLE;");
}
?>

var snail1;
var snail2;
var snail3;

var finish_x = 750;
var audio = new Audio("vroom.wav");


//defines a snail
class Snail
{
	//build a snail
	constructor(x, y, img)
	{
		this.x = x;
		this.y = y;
		this.img = img;
		
		this.Draw = function (context) {
			context.drawImage(img, x - img.width/2, y - img.height/2);
		}
		//functions
		this.Move = function () {
			x += Math.random() * 3 + speed;
		}
		
		this.reset = function ()
		{
			x = 50;
		}
		
		this.GetX = function () { return x; }
	}
	
	
	
}

//top level functions
//use this to "construct" the program

function reset()
{
 
}

function OnLoad()
{
	//load images
	backgroundImg.src = "image_track.png";
	snail1Img.src = "moose 1.png";
	snail2Img.src = "moose2.png";
	snail3Img.src = "moose3.png";
	
	
	//setup title screen and/or banner
	//titleImg.src = "TitleScreen.png"; 
	bannerImg.src = "Banner.png";
	
	//load winning images
	winning1Img.src = "winning1.png";
	winning2Img.src = "winning2.png";
	winning3Img.src = "winning3.png";
	
	//create snails
	snail1 = new Snail(50,192,snail1Img);
	snail2 = new Snail(50,292,snail2Img);
	snail3 = new Snail(50,392,snail3Img);
	
	//setup key press functions
	
	window.onkeyup = function(e) {
	
		//if (gameState != GAME_OVER)
		{
			var key = e.keyCode ? e.keyCode : e.which;

			if (key == 68) { //'d'
			} else if (key == 90 || key == 122) { //'z'
				snail1.Move();
				checkFinish();
			} else if (key == 88) { //'x'
				snail2.Move();
				checkFinish();
			} else if (key == 71) { //'g'
				snail3.Move();
				checkFinish();
			}
			else if (key == 49) {
				ResetGame();
			}
		}
		//else { ResetGame();
		//}
	}//end keyup

	DrawGame();
	setInterval(Timer, 750);
}

function Timer()
{
	UpdateGame();
	DrawGame();
}

function DrawGame()
{
	//clear canvas
	canvas = document.getElementById("canvas");

	ctx = canvas.getContext("2d");
	
	//clobber the whole canvas
	ctx.fillRect(0,0, canvas.width, canvas.height);
	
	//ctx.drawImage(titleImg, 0, 0);
	ctx.drawImage(bannerImg, 0, 0);
	ctx.drawImage(backgroundImg, 0, 143);
	
	snail1.Draw(ctx);
	snail2.Draw(ctx);
	snail3.Draw(ctx);
	
	if (gameState == RACE_WON)
	{
		if (winningImg!= null)
		{
			ctx.drawImage(winningImg, canvas.width/2 - winningImg.width/2, canvas.height/2 - winningImg.height/2);
			
		}
	}
	
}

function UpdateGame()
{
   if (gameState != RACE_WON)
   { 
	if (gameType == SINGLE) 
   	{	
		snail1.Move();
	   	snail2.Move();
		DrawGame();
		checkFinish();
  	}
   	else if (gameType == MULTI)
  	{
		snail1.Move();
		DrawGame();
		CheckFinish();
   	}
   }
		
}

function MovePlayer()
{

}

function ResetGame()
{
	location.replace("TitleScreen.html");
	//gameState = PLAYING;
	//snail1.reset();
	//snail2.reset();
	//snail3.reset();
	
	//audio.play();
}

function checkFinish()
{
	if (snail1.GetX() > finish_x || snail2.GetX() > finish_x || snail3.GetX() > finish_x)
	{
		//alert("Race won!");
		
		if (snail1.GetX() > snail2.GetX() && snail1.GetX() > snail3.GetX())
		{
		  winningImg = winning1Img;
		}
		else if (snail2.GetX() > snail1.GetX() && snail2.GetX() > snail3.GetX())
		{
		  winningImg = winning2Img;
		}
		else  
		{
		 winningImg = winning3Img; 
		}
		gameState = RACE_WON;
	}
}

</script>
<body onLoad="javascript:OnLoad();">
<center>
<canvas id="canvas" width="799" height="442" style="background:#000000">
</canvas>
<button onClick = "ResetGame();">
reset 
</button>
</center>


</div>
</body>
</html>
