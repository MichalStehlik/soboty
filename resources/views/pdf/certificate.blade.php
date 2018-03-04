<!DOCTYPE html>
<html>
<head>
<style>
body { margin: 0 auto; 	padding: 0; color: black; font-family: sans-serif; background-color: azure; background-image: url('https://www.pslib.cz/michal.stehlik/sobota/public/img/bg.png'); background-image-resize: 3; position: relative;}
.jmeno {position: absolute; font-weight: bold; font-size: 36px; left: 420px; top: 460px; text-align: center; color: #3a3a3d; width: 550px;}
.kdy {position: absolute; font-size: 18px; left: 420px; top: 520px; width: 550px; text-align: center; color: #88898b;}
.kde {position: absolute; font-size: 18px; left: 420px; top: 640px; width: 250px; text-align: left; color: #121212;}
.garant {position: absolute; font-size: 18px; right: 120px; top: 640px; width: 250px; text-align: right; color: #121212;}
.garant span {color: #96989b;}
</style>
</head>
<body style="background-image: url(img/bg.png);">
@foreach ($applications as $app)
	<div class="jmeno">{{$app->user->firstname}} {{$app->user->lastname}}</div>
	<div class="kdy">@if($app->user->gender == "female")Absolvovala @else Absolvoval @endif dne {{ date('j. m. Y', strtotime($group->action->start)) }} <br>
			akci s názvem "{{$group->action->name}}"</div>
	<div class="kde">V Liberci {{ date('j. m. Y', strtotime($today)) }}</div>
	<div class="garant">
		Bc. Karel Engelmann <br>
		<span>koordinátor akce</span>
	</div>
    @if (!$loop->last)<pagebreak> @endif
@endforeach    
</body>
</html>