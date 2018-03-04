<!DOCTYPE html>
<html>
<head>
<style>
/*
body {display: block; width: 3508px; height: 2480px; margin: 0 auto; padding: 0; color: black; background-size: 100%; font-family: "arial";}
.a4 {position: relative; display: block; width: 3508px; height: 2480px; background: url('img/bg.png') center center no-repeat;}
.jmeno {position: absolute; font-weight: bold; font-size: 120px; left: 1303px; top: 1442px; width: 1741px; text-align: center; color: #3a3a3d;}
.kdy {position: absolute; font-size: 51px; left: 1303px; top: 1661px; width: 1741px; text-align: center; color: #88898b;}
.kde {position: absolute; font-size: 51px; left: 1303px; top: 1970px; width: 720px; text-align: left; color: #121212;}
.garant {position: absolute; font-size: 51px; right: 465px; top: 1970px; width: 720px; text-align: right; color: #121212;}
.garant span {color: #96989b;}
*/
body { margin: 0 auto; 	padding: 0; color: black; font-family: sans-serif; background-image: url(img/bg.png); background-image-resize: 3; position: relative;}
.jmeno {position: absolute; font-weight: bold; font-size: 36px; left: 420px; top: 460px; text-align: center; color: #3a3a3d; width: 550px;}
.kdy {position: absolute; font-size: 18px; left: 420px; top: 520px; width: 550px; text-align: center; color: #88898b;}
.kde {position: absolute; font-size: 18px; left: 420px; top: 640px; width: 250px; text-align: left; color: #121212;}
.garant {position: absolute; font-size: 18px; right: 120px; top: 640px; width: 250px; text-align: right; color: #121212;}
.garant span {color: #96989b;}
</style>
</head>
<body style="background-image: url(img/bg.png);">
	<div class="jmeno">{{$firstname}} {{$lastname}}</div>
	<div class="kdy">@if($gender == "female")Absolvovala @else Absolvoval @endif dne {{ date('j. m. Y', strtotime($group->action->start)) }} <br>
			akci s názvem "{{$group->action->name}}"</div>
	<div class="kde">V Liberci {{ date('j. m. Y', strtotime($printdate)) }}</div>
	<div class="garant">
		Bc. Karel Engelmann <br>
		<span>koordinátor akce</span>
	</div>  
</body>
</html>