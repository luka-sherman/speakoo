<?php session_start(); ?>
<?php require_once 'db_connect.php'?>

<?php
if( !isset($_SESSION["name"]) ) { // not logged in, not permitted to view the page
	//echo "who are you?"; //redirect to login later
	header('Location: index.php');
	die();
}
?>
<html>
    <head>
        <title>Speakoo | Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/newstyle.css" />
        <link href="css/common.css" rel="stylesheet" type="text/css" />
        

        <!-- include JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
        <script src="js/bootstrap-rating-input.min.js" type="text/javascript"></script>
    </head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="profile.php">Speakoo</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<!--<li class="active dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="profile.php">Videos</a></li>
					<li><a href="view_information.php">Account Information</a></li>


				  </ul>
				</li>
				<li><a href="newsfeed.php">Newsfeed</a></li>
				<li><a href="recordvideo.php">Record a new video</a></li>-->
				<li><a href="play_game_car.php">Play Game</a></li>
			  </ul>
			  
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="logout.php">Logout</a></li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="container-fluid">
			<table hidden id="controls">
			   
			    <tr><td id="fps" colspan="2" align="right"></td></tr>
			    <tr>
			      <th><label for="resolution">Resolution :</label></th>
			      <td>
			        <select id="resolution" style="width:100%">
			          <option value='fine'>Fine (1280x960)</option>
			          <option selected value='high'>High (1024x768)</option>
			          <option value='medium'>Medium (640x480)</option>
			          <option value='low'>Low (480x360)</option>
			        </select>
			      </td>
			    </tr>
			    <tr>
			      <th><label for="lanes">Lanes :</label></th>
			      <td>
			        <select id="lanes">
			          <option>1</option>
			          <option>2</option>
			          <option selected>3</option>
			          <option>4</option>
			        </select>
			      </td>
			    </tr>
			    <tr>
			      <th><label for="roadWidth">Road Width (<span id="currentRoadWidth"></span>) :</label></th>
			      <td><input id="roadWidth" type='range' min='500' max='3000' title="integer (500-3000)"></td>
			    </tr>
			    <tr>
			      <th><label for="cameraHeight">CameraHeight (<span id="currentCameraHeight"></span>) :</label></th>
			      <td><input id="cameraHeight" type='range' min='500' max='5000' title="integer (500-5000)"></td>
			    </tr>
			    <tr>
			      <th><label for="drawDistance">Draw Distance (<span id="currentDrawDistance"></span>) :</label></th>
			      <td><input id="drawDistance" type='range' min='100' max='500' title="integer (100-500)"></td>
			    </tr>
			    <tr>
			      <th><label for="fieldOfView">Field of View (<span id="currentFieldOfView"></span>) :</label></th>
			      <td><input id="fieldOfView" type='range' min='80' max='140' title="integer (80-140)"></td>
			    </tr>
			    <tr>
			      <th><label for="fogDensity">Fog Density (<span id="currentFogDensity"></span>) :</label></th>
			      <td><input id="fogDensity" type='range' min='0' max='50' title="integer (0-50)"></td>
			    </tr>
			</table>
			  <div hidden id='instructions'>
			    <p>Use the <b>arrow keys</b> to drive the car.</p>
			  </div>

			  <div id="racer">
			    <div id="hud">
			      <span id="speed"            class="hud"><span id="speed_value" class="value">0</span> mph</span>
			      <span id="current_lap_time" class="hud">Time: <span id="current_lap_time_value" class="value">0.0</span></span> 
			      <span id="last_lap_time"    class="hud">Last Lap: <span id="last_lap_time_value" class="value">0.0</span></span>
			      <span id="fast_lap_time"    class="hud">Fastest Lap: <span id="fast_lap_time_value" class="value">0.0</span></span>
			    </div>
			    <canvas id="canvas">
			      Sorry, this example cannot be run because your browser does not support the &lt;canvas&gt; element
			    </canvas>
			    Loading...
			  </div>

			  <!--<audio id='music'>
			    <source src="music/racer.ogg">
			    <source src="music/racer.mp3">
			  </audio>
			  <span id="mute"></span>
				#nltk.help.upenn_tagset()
			  -->

			  <script src="js/stats.js"></script>
			  <script src="js/common.js"></script>
			  <script>

			    var fps            = 60;                      // how many 'update' frames per second
			    var step           = 1/fps;                   // how long is each frame (in seconds)
			    var width          = 1024;                    // logical canvas width
			    var height         = 768;                     // logical canvas height
			    var centrifugal    = 0.3;                     // centrifugal force multiplier when going around curves
			    var offRoadDecel   = 0.99;                    // speed multiplier when off road (e.g. you lose 2% speed each update frame)
			    var skySpeed       = 0.001;                   // background sky layer scroll speed when going around curve (or up hill)
			    var hillSpeed      = 0.002;                   // background hill layer scroll speed when going around curve (or up hill)
			    var treeSpeed      = 0.003;                   // background tree layer scroll speed when going around curve (or up hill)
			    var skyOffset      = 0;                       // current sky scroll offset
			    var hillOffset     = 0;                       // current hill scroll offset
			    var treeOffset     = 0;                       // current tree scroll offset
			    var segments       = [];                      // array of road segments
			    var cars           = [];                      // array of cars on the road
			    var stats          = Game.stats('fps');       // mr.doobs FPS counter
			    var canvas         = Dom.get('canvas');       // our canvas...
			    var ctx            = canvas.getContext('2d'); // ...and its drawing context
			    var background     = null;                    // our background image (loaded below)
			    var sprites        = null;                    // our spritesheet (loaded below)
			    var resolution     = null;                    // scaling factor to provide resolution independence (computed)
			    var roadWidth      = 2000;                    // actually half the roads width, easier math if the road spans from -roadWidth to +roadWidth
			    var segmentLength  = 200;                     // length of a single segment
			    var rumbleLength   = 3;                       // number of segments per red/white rumble strip
			    var trackLength    = null;                    // z length of entire track (computed)
			    var lanes          = 9;                       // number of lanes
			    var fieldOfView    = 100;                     // angle (degrees) for field of view
			    var cameraHeight   = 1000;                    // z height of camera
			    var cameraDepth    = null;                    // z distance camera is from screen (computed)
			    var drawDistance   = 300;                     // number of segments to draw
			    var playerX        = 0;                       // player x offset from center of road (-1 to 1 to stay independent of roadWidth)
			    var playerZ        = null;                    // player relative z distance from camera (computed)
			    var fogDensity     = 5;                       // exponential fog density
			    var position       = 0;                       // current camera Z position (add playerZ to get player's absolute Z position)
			    var speed          = 0;                       // current speed
			    var maxSpeed       = segmentLength/step;      // top speed (ensure we can't move more than 1 segment in a single frame to make collision detection easier)
			    var accel          =  maxSpeed/5;             // acceleration rate - tuned until it 'felt' right
			    var breaking       = -maxSpeed;               // deceleration rate when braking
			    var decel          = -maxSpeed/5;             // 'natural' deceleration rate when neither accelerating, nor braking
			    var offRoadDecel   = -maxSpeed/2;             // off road deceleration is somewhere in between
			    var offRoadLimit   =  maxSpeed/4;             // limit when off road deceleration no longer applies (e.g. you can always go at least this speed even when off road)
			    var totalCars      = 200;                     // total number of cars on the road
			    var currentLapTime = 0;                       // current lap time
			    var lastLapTime    = null;                    // last lap time

			    var keyLeft        = false;
			    var keyRight       = false;
			    var keyFaster      = false;
			    var keySlower      = false;

			    var hud = {
			      speed:            { value: null, dom: Dom.get('speed_value')            },
			      current_lap_time: { value: null, dom: Dom.get('current_lap_time_value') },
			      last_lap_time:    { value: null, dom: Dom.get('last_lap_time_value')    },
			      fast_lap_time:    { value: null, dom: Dom.get('fast_lap_time_value')    }
			    }

			    //=========================================================================
			    // UPDATE THE GAME WORLD
			    //=========================================================================

			    function update(dt) {

			      var n, car, carW, sprite, spriteW;
			      var playerSegment = findSegment(position+playerZ);
			      var playerW       = SPRITES.PLAYER_STRAIGHT.w * SPRITES.SCALE;
			      var speedPercent  = speed/maxSpeed;
			      var dx            = dt * 2 * speedPercent; // at top speed, should be able to cross from left to right (-1 to 1) in 1 second
			      var startPosition = position;

			      updateCars(dt, playerSegment, playerW);

			      position = Util.increase(position, dt * speed, trackLength);

			      if (keyLeft)
			        playerX = playerX - dx;
			      else if (keyRight)
			        playerX = playerX + dx;

			      playerX = playerX - (dx * speedPercent * playerSegment.curve * centrifugal);

			      if (keyFaster)
			        speed = Util.accelerate(speed, accel, dt);
			      else if (keySlower)
			        speed = Util.accelerate(speed, breaking, dt);
			      else
			        speed = Util.accelerate(speed, decel, dt);


			      if ((playerX < -1) || (playerX > 1)) {

			        if (speed > offRoadLimit)
			          speed = Util.accelerate(speed, offRoadDecel, dt);

			        for(n = 0 ; n < playerSegment.sprites.length ; n++) {
			          sprite  = playerSegment.sprites[n];
			          spriteW = sprite.source.w * SPRITES.SCALE;
			          if (Util.overlap(playerX, playerW, sprite.offset + spriteW/2 * (sprite.offset > 0 ? 1 : -1), spriteW)) {
			            speed = maxSpeed/5;
			            position = Util.increase(playerSegment.p1.world.z, -playerZ, trackLength); // stop in front of sprite (at front of segment)
			            break;
			          }
			        }
			      }

			      for(n = 0 ; n < playerSegment.cars.length ; n++) {
			        car  = playerSegment.cars[n];
			        carW = car.sprite.w * SPRITES.SCALE;
			        if (speed > car.speed) {
			          if (Util.overlap(playerX, playerW, car.offset, carW, 0.8)) {
			            speed    = car.speed * (car.speed/speed);
			            position = Util.increase(car.z, -playerZ, trackLength);
			            break;
			          }
			        }
			      }

			      playerX = Util.limit(playerX, -3, 3);     // dont ever let it go too far out of bounds
			      speed   = Util.limit(speed, 0, maxSpeed); // or exceed maxSpeed

			      skyOffset  = Util.increase(skyOffset,  skySpeed  * playerSegment.curve * (position-startPosition)/segmentLength, 1);
			      hillOffset = Util.increase(hillOffset, hillSpeed * playerSegment.curve * (position-startPosition)/segmentLength, 1);
			      treeOffset = Util.increase(treeOffset, treeSpeed * playerSegment.curve * (position-startPosition)/segmentLength, 1);

			      if (position > playerZ) {
			        if (currentLapTime && (startPosition < playerZ)) {
			          lastLapTime    = currentLapTime;
			          currentLapTime = 0;
			          if (lastLapTime <= Util.toFloat(Dom.storage.fast_lap_time)) {
			            Dom.storage.fast_lap_time = lastLapTime;
			            updateHud('fast_lap_time', formatTime(lastLapTime));
			            Dom.addClassName('fast_lap_time', 'fastest');
			            Dom.addClassName('last_lap_time', 'fastest');
			          }
			          else {
			            Dom.removeClassName('fast_lap_time', 'fastest');
			            Dom.removeClassName('last_lap_time', 'fastest');
			          }
			          updateHud('last_lap_time', formatTime(lastLapTime));
			          Dom.show('last_lap_time');
			        }
			        else {
			          currentLapTime += dt;
			        }
			      }

			      updateHud('speed',            5 * Math.round(speed/500));
			      updateHud('current_lap_time', formatTime(currentLapTime));
			    }

			    //-------------------------------------------------------------------------

			    function updateCars(dt, playerSegment, playerW) {
			      var n, car, oldSegment, newSegment;
			      for(n = 0 ; n < cars.length ; n++) {
			        car         = cars[n];
			        oldSegment  = findSegment(car.z);
			        car.offset  = car.offset + updateCarOffset(car, oldSegment, playerSegment, playerW);
			        car.z       = Util.increase(car.z, dt * car.speed, trackLength);
			        car.percent = Util.percentRemaining(car.z, segmentLength); // useful for interpolation during rendering phase
			        newSegment  = findSegment(car.z);
			        if (oldSegment != newSegment) {
			          index = oldSegment.cars.indexOf(car);
			          oldSegment.cars.splice(index, 1);
			          newSegment.cars.push(car);
			        }
			      }
			    }

			    function updateCarOffset(car, carSegment, playerSegment, playerW) {

			      var i, j, dir, segment, otherCar, otherCarW, lookahead = 20, carW = car.sprite.w * SPRITES.SCALE;

			      // optimization, dont bother steering around other cars when 'out of sight' of the player
			      if ((carSegment.index - playerSegment.index) > drawDistance)
			        return 0;

			      for(i = 1 ; i < lookahead ; i++) {
			        segment = segments[(carSegment.index+i)%segments.length];

			        if ((segment === playerSegment) && (car.speed > speed) && (Util.overlap(playerX, playerW, car.offset, carW, 1.2))) {
			          if (playerX > 0.5)
			            dir = -1;
			          else if (playerX < -0.5)
			            dir = 1;
			          else
			            dir = (car.offset > playerX) ? 1 : -1;
			          return dir * 1/i * (car.speed-speed)/maxSpeed; // the closer the cars (smaller i) and the greated the speed ratio, the larger the offset
			        }

			        for(j = 0 ; j < segment.cars.length ; j++) {
			          otherCar  = segment.cars[j];
			          otherCarW = otherCar.sprite.w * SPRITES.SCALE;
			          if ((car.speed > otherCar.speed) && Util.overlap(car.offset, carW, otherCar.offset, otherCarW, 1.2)) {
			            if (otherCar.offset > 0.5)
			              dir = -1;
			            else if (otherCar.offset < -0.5)
			              dir = 1;
			            else
			              dir = (car.offset > otherCar.offset) ? 1 : -1;
			            return dir * 1/i * (car.speed-otherCar.speed)/maxSpeed;
			          }
			        }
			      }

			      // if no cars ahead, but I have somehow ended up off road, then steer back on
			      if (car.offset < -0.9)
			        return 0.1;
			      else if (car.offset > 0.9)
			        return -0.1;
			      else
			        return 0;
			    }

			    //-------------------------------------------------------------------------

			    function updateHud(key, value) { // accessing DOM can be slow, so only do it if value has changed
			      if (hud[key].value !== value) {
			        hud[key].value = value;
			        Dom.set(hud[key].dom, value);
			      }
			    }

			    function formatTime(dt) {
			      var minutes = Math.floor(dt/60);
			      var seconds = Math.floor(dt - (minutes * 60));
			      var tenths  = Math.floor(10 * (dt - Math.floor(dt)));
			      if (minutes > 0)
			        return minutes + "." + (seconds < 10 ? "0" : "") + seconds + "." + tenths;
			      else
			        return seconds + "." + tenths;
			    }

			    //=========================================================================
			    // RENDER THE GAME WORLD
			    //=========================================================================

			    function render() {

			      var baseSegment   = findSegment(position);
			      var basePercent   = Util.percentRemaining(position, segmentLength);
			      var playerSegment = findSegment(position+playerZ);
			      var playerPercent = Util.percentRemaining(position+playerZ, segmentLength);
			      var playerY       = Util.interpolate(playerSegment.p1.world.y, playerSegment.p2.world.y, playerPercent);
			      var maxy          = height;

			      var x  = 0;
			      var dx = - (baseSegment.curve * basePercent);

			      ctx.clearRect(0, 0, width, height);

			      Render.background(ctx, background, width, height, BACKGROUND.SKY,   skyOffset,  resolution * skySpeed  * playerY);
			      Render.background(ctx, background, width, height, BACKGROUND.HILLS, hillOffset, resolution * hillSpeed * playerY);
			      Render.background(ctx, background, width, height, BACKGROUND.TREES, treeOffset, resolution * treeSpeed * playerY);

			      var n, i, segment, car, sprite, spriteScale, spriteX, spriteY;

			      for(n = 0 ; n < drawDistance ; n++) {

			        segment        = segments[(baseSegment.index + n) % segments.length];
			        segment.looped = segment.index < baseSegment.index;
			        segment.fog    = Util.exponentialFog(n/drawDistance, fogDensity);
			        segment.clip   = maxy;

			        Util.project(segment.p1, (playerX * roadWidth) - x,      playerY + cameraHeight, position - (segment.looped ? trackLength : 0), cameraDepth, width, height, roadWidth);
			        Util.project(segment.p2, (playerX * roadWidth) - x - dx, playerY + cameraHeight, position - (segment.looped ? trackLength : 0), cameraDepth, width, height, roadWidth);

			        x  = x + dx;
			        dx = dx + segment.curve;

			        if ((segment.p1.camera.z <= cameraDepth)         || // behind us
			            (segment.p2.screen.y >= segment.p1.screen.y) || // back face cull
			            (segment.p2.screen.y >= maxy))                  // clip by (already rendered) hill
			          continue;

			        Render.segment(ctx, width, lanes,
			                       segment.p1.screen.x,
			                       segment.p1.screen.y,
			                       segment.p1.screen.w,
			                       segment.p2.screen.x,
			                       segment.p2.screen.y,
			                       segment.p2.screen.w,
			                       segment.fog,
			                       segment.color);

			        maxy = segment.p1.screen.y;
			      }

			      for(n = (drawDistance-1) ; n > 0 ; n--) {
			        segment = segments[(baseSegment.index + n) % segments.length];

			        for(i = 0 ; i < segment.cars.length ; i++) {
			          car         = segment.cars[i];
			          sprite      = car.sprite;
			          spriteScale = Util.interpolate(segment.p1.screen.scale, segment.p2.screen.scale, car.percent);
			          spriteX     = Util.interpolate(segment.p1.screen.x,     segment.p2.screen.x,     car.percent) + (spriteScale * car.offset * roadWidth * width/2);
			          spriteY     = Util.interpolate(segment.p1.screen.y,     segment.p2.screen.y,     car.percent);
			          Render.sprite(ctx, width, height, resolution, roadWidth, sprites, car.sprite, spriteScale, spriteX, spriteY, -0.5, -1, segment.clip);
			        }

			        for(i = 0 ; i < segment.sprites.length ; i++) {
			          sprite      = segment.sprites[i];
			          spriteScale = segment.p1.screen.scale;
			          spriteX     = segment.p1.screen.x + (spriteScale * sprite.offset * roadWidth * width/2);
			          spriteY     = segment.p1.screen.y;
			          Render.sprite(ctx, width, height, resolution, roadWidth, sprites, sprite.source, spriteScale, spriteX, spriteY, (sprite.offset < 0 ? -1 : 0), -1, segment.clip);
			        }

			        if (segment == playerSegment) {
			          Render.player(ctx, width, height, resolution, roadWidth, sprites, speed/maxSpeed,
			                        cameraDepth/playerZ,
			                        width/2,
			                        (height/2) - (cameraDepth/playerZ * Util.interpolate(playerSegment.p1.camera.y, playerSegment.p2.camera.y, playerPercent) * height/2),
			                        speed * (keyLeft ? -1 : keyRight ? 1 : 0),
			                        playerSegment.p2.world.y - playerSegment.p1.world.y);
			        }
			      }
			    }

			    function findSegment(z) {
			      return segments[Math.floor(z/segmentLength) % segments.length]; 
			    }

			    //=========================================================================
			    // BUILD ROAD GEOMETRY
			    //=========================================================================

			    function lastY() { return (segments.length == 0) ? 0 : segments[segments.length-1].p2.world.y; }

			    function addSegment(curve, y) {
			      var n = segments.length;
			      segments.push({
			          index: n,
			             p1: { world: { y: lastY(), z:  n   *segmentLength }, camera: {}, screen: {} },
			             p2: { world: { y: y,       z: (n+1)*segmentLength }, camera: {}, screen: {} },
			          curve: curve,
			        sprites: [],
			           cars: [],
			          color: Math.floor(n/rumbleLength)%2 ? COLORS.DARK : COLORS.LIGHT
			      });
			    }

			    function addSprite(n, sprite, offset) {
			      segments[n].sprites.push({ source: sprite, offset: offset });
			    }

			    function addRoad(enter, hold, leave, curve, y) {
			      var startY   = lastY();
			      var endY     = startY + (Util.toInt(y, 0) * segmentLength);
			      var n, total = enter + hold + leave;
			      for(n = 0 ; n < enter ; n++)
			        addSegment(Util.easeIn(0, curve, n/enter), Util.easeInOut(startY, endY, n/total));
			      for(n = 0 ; n < hold  ; n++)
			        addSegment(curve, Util.easeInOut(startY, endY, (enter+n)/total));
			      for(n = 0 ; n < leave ; n++)
			        addSegment(Util.easeInOut(curve, 0, n/leave), Util.easeInOut(startY, endY, (enter+hold+n)/total));
			    }

			    var ROAD = {
			      LENGTH: { NONE: 0, SHORT:  25, MEDIUM:   50, LONG:  100 },
			      HILL:   { NONE: 0, LOW:    20, MEDIUM:   40, HIGH:   60 },
			      CURVE:  { NONE: 0, EASY:    2, MEDIUM:    4, HARD:    6 }
			    };

			    function addStraight(num) {
			      num = num || ROAD.LENGTH.MEDIUM;
			      addRoad(num, num, num, 0, 0);
			    }

			    function addHill(num, height) {
			      num    = num    || ROAD.LENGTH.MEDIUM;
			      height = height || ROAD.HILL.MEDIUM;
			      addRoad(num, num, num, 0, height);
			    }

			    function addCurve(num, curve, height) {
			      num    = num    || ROAD.LENGTH.MEDIUM;
			      curve  = curve  || ROAD.CURVE.MEDIUM;
			      height = height || ROAD.HILL.NONE;
			      addRoad(num, num, num, curve, height);
			    }
			        
			    function addLowRollingHills(num, height) {
			      num    = num    || ROAD.LENGTH.SHORT;
			      height = height || ROAD.HILL.LOW;
			      addRoad(num, num, num,  0,                height/2);
			      addRoad(num, num, num,  0,               -height);
			      addRoad(num, num, num,  ROAD.CURVE.EASY,  height);
			      addRoad(num, num, num,  0,                0);
			      addRoad(num, num, num, -ROAD.CURVE.EASY,  height/2);
			      addRoad(num, num, num,  0,                0);
			    }

			    function addSCurves() {
			      addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,  -ROAD.CURVE.EASY,    ROAD.HILL.NONE);
			      addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,   ROAD.CURVE.MEDIUM,  ROAD.HILL.MEDIUM);
			      addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,   ROAD.CURVE.EASY,   -ROAD.HILL.LOW);
			      addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,  -ROAD.CURVE.EASY,    ROAD.HILL.MEDIUM);
			      addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,  -ROAD.CURVE.MEDIUM, -ROAD.HILL.MEDIUM);
			    }

			    function addBumps() {
			      addRoad(10, 10, 10, 0,  5);
			      addRoad(10, 10, 10, 0, -2);
			      addRoad(10, 10, 10, 0, -5);
			      addRoad(10, 10, 10, 0,  8);
			      addRoad(10, 10, 10, 0,  5);
			      addRoad(10, 10, 10, 0, -7);
			      addRoad(10, 10, 10, 0,  5);
			      addRoad(10, 10, 10, 0, -2);
			    }

			    function addDownhillToEnd(num) {
			      num = num || 200;
			      addRoad(num, num, num, -ROAD.CURVE.EASY, -lastY()/segmentLength);
			    }

			    function resetRoad() {
			      segments = [];

			      addStraight(ROAD.LENGTH.SHORT);
			      addLowRollingHills();
			      addSCurves();
			      addCurve(ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM, ROAD.HILL.LOW);
			      addBumps();
			      addLowRollingHills();
			      addCurve(ROAD.LENGTH.LONG*2, ROAD.CURVE.MEDIUM, ROAD.HILL.MEDIUM);
			      addStraight();
			      addHill(ROAD.LENGTH.MEDIUM, ROAD.HILL.HIGH);
			      addSCurves();
			      addCurve(ROAD.LENGTH.LONG, -ROAD.CURVE.MEDIUM, ROAD.HILL.NONE);
			      addHill(ROAD.LENGTH.LONG, ROAD.HILL.HIGH);
			      addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM, -ROAD.HILL.LOW);
			      addBumps();
			      addHill(ROAD.LENGTH.LONG, -ROAD.HILL.MEDIUM);
			      addStraight();
			      addSCurves();
			      addDownhillToEnd();

			      resetSprites();
			      resetCars();

			      segments[findSegment(playerZ).index + 2].color = COLORS.START;
			      segments[findSegment(playerZ).index + 3].color = COLORS.START;
			      for(var n = 0 ; n < rumbleLength ; n++)
			        segments[segments.length-1-n].color = COLORS.FINISH;

			      trackLength = segments.length * segmentLength;
			    }

			    function resetSprites() {
			      var n, i;

			      addSprite(20,  SPRITES.BILLBOARD07, -1);
			      addSprite(40,  SPRITES.BILLBOARD06, -1);
			      addSprite(60,  SPRITES.BILLBOARD08, -1);
			      addSprite(80,  SPRITES.BILLBOARD09, -1);
			      addSprite(100, SPRITES.BILLBOARD01, -1);
			      addSprite(120, SPRITES.BILLBOARD02, -1);
			      addSprite(140, SPRITES.BILLBOARD03, -1);
			      addSprite(160, SPRITES.BILLBOARD04, -1);
			      addSprite(180, SPRITES.BILLBOARD05, -1);

			      addSprite(240,                  SPRITES.BILLBOARD07, -1.2);
			      addSprite(240,                  SPRITES.BILLBOARD06,  1.2);
			      addSprite(segments.length - 25, SPRITES.BILLBOARD07, -1.2);
			      addSprite(segments.length - 25, SPRITES.BILLBOARD06,  1.2);

			      for(n = 10 ; n < 200 ; n += 4 + Math.floor(n/100)) {
			        addSprite(n, SPRITES.PALM_TREE, 0.5 + Math.random()*0.5);
			        addSprite(n, SPRITES.PALM_TREE,   1 + Math.random()*2);
			      }

			      for(n = 250 ; n < 1000 ; n += 5) {
			        addSprite(n,     SPRITES.COLUMN, 1.1);
			        addSprite(n + Util.randomInt(0,5), SPRITES.TREE1, -1 - (Math.random() * 2));
			        addSprite(n + Util.randomInt(0,5), SPRITES.TREE2, -1 - (Math.random() * 2));
			      }

			      for(n = 200 ; n < segments.length ; n += 3) {
			        addSprite(n, Util.randomChoice(SPRITES.PLANTS), Util.randomChoice([1,-1]) * (2 + Math.random() * 5));
			      }

			      var side, sprite, offset;
			      for(n = 1000 ; n < (segments.length-50) ; n += 100) {
			        side      = Util.randomChoice([1, -1]);
			        addSprite(n + Util.randomInt(0, 50), Util.randomChoice(SPRITES.BILLBOARDS), -side);
			        for(i = 0 ; i < 20 ; i++) {
			          sprite = Util.randomChoice(SPRITES.PLANTS);
			          offset = side * (1.5 + Math.random());
			          addSprite(n + Util.randomInt(0, 50), sprite, offset);
			        }
			          
			      }

			    }

			    function resetCars() {
			      cars = [];
			      var n, car, segment, offset, z, sprite, speed;
			      for (var n = 0 ; n < totalCars ; n++) {
			        offset = Math.random() * Util.randomChoice([-0.8, 0.8]);
			        z      = Math.floor(Math.random() * segments.length) * segmentLength;
			        sprite = Util.randomChoice(SPRITES.CARS);
			        speed  = maxSpeed/4 + Math.random() * maxSpeed/(sprite == SPRITES.SEMI ? 4 : 2);
			        car = { offset: offset, z: z, sprite: sprite, speed: speed };
			        segment = findSegment(car.z);
			        segment.cars.push(car);
			        cars.push(car);
			      }
			    }

			    //=========================================================================
			    // THE GAME LOOP
			    //=========================================================================

			    Game.run({
			      canvas: canvas, render: render, update: update, stats: stats, step: step,
			      images: ["background", "sprites"],
			      keys: [
			        { keys: [KEY.LEFT,  KEY.A], mode: 'down', action: function() { keyLeft   = true;  } },
			        { keys: [KEY.RIGHT, KEY.D], mode: 'down', action: function() { keyRight  = true;  } },
			        { keys: [KEY.UP,    KEY.W], mode: 'down', action: function() { keyFaster = true;  } },
			        { keys: [KEY.DOWN,  KEY.S], mode: 'down', action: function() { keySlower = true;  } },
			        { keys: [KEY.LEFT,  KEY.A], mode: 'up',   action: function() { keyLeft   = false; } },
			        { keys: [KEY.RIGHT, KEY.D], mode: 'up',   action: function() { keyRight  = false; } },
			        { keys: [KEY.UP,    KEY.W], mode: 'up',   action: function() { keyFaster = false; } },
			        { keys: [KEY.DOWN,  KEY.S], mode: 'up',   action: function() { keySlower = false; } }
			      ],
			      ready: function(images) {
			        background = images[0];
			        sprites    = images[1];
			        reset();
			        Dom.storage.fast_lap_time = Dom.storage.fast_lap_time || 180;
			        updateHud('fast_lap_time', formatTime(Util.toFloat(Dom.storage.fast_lap_time)));
			      }
			    });

			    function reset(options) {
			      options       = options || {};
			      canvas.width  = width  = Util.toInt(options.width,          width);
			      canvas.height = height = Util.toInt(options.height,         height);
			      lanes                  = Util.toInt(options.lanes,          lanes);
			      roadWidth              = Util.toInt(options.roadWidth,      roadWidth);
			      cameraHeight           = Util.toInt(options.cameraHeight,   cameraHeight);
			      drawDistance           = Util.toInt(options.drawDistance,   drawDistance);
			      fogDensity             = Util.toInt(options.fogDensity,     fogDensity);
			      fieldOfView            = Util.toInt(options.fieldOfView,    fieldOfView);
			      segmentLength          = Util.toInt(options.segmentLength,  segmentLength);
			      rumbleLength           = Util.toInt(options.rumbleLength,   rumbleLength);
			      cameraDepth            = 1 / Math.tan((fieldOfView/2) * Math.PI/180);
			      playerZ                = (cameraHeight * cameraDepth);
			      resolution             = height/480;
			      refreshTweakUI();

			      if ((segments.length==0) || (options.segmentLength) || (options.rumbleLength))
			        resetRoad(); // only rebuild road when necessary
			    }

			    //=========================================================================
			    // TWEAK UI HANDLERS
			    //=========================================================================

			    Dom.on('resolution', 'change', function(ev) {
			      var w, h, ratio;
			      switch(ev.target.options[ev.target.selectedIndex].value) {
			        case 'fine':   w = 1280; h = 960;  ratio=w/width; break;
			        case 'high':   w = 1024; h = 768;  ratio=w/width; break;
			        case 'medium': w = 640;  h = 480;  ratio=w/width; break;
			        case 'low':    w = 480;  h = 360;  ratio=w/width; break;
			      }
			      reset({ width: w, height: h })
			      Dom.blur(ev);
			    });

			    Dom.on('lanes',          'change', function(ev) { Dom.blur(ev); reset({ lanes:         ev.target.options[ev.target.selectedIndex].value }); });
			    Dom.on('roadWidth',      'change', function(ev) { Dom.blur(ev); reset({ roadWidth:     Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) }); });
			    Dom.on('cameraHeight',   'change', function(ev) { Dom.blur(ev); reset({ cameraHeight:  Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) }); });
			    Dom.on('drawDistance',   'change', function(ev) { Dom.blur(ev); reset({ drawDistance:  Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) }); });
			    Dom.on('fieldOfView',    'change', function(ev) { Dom.blur(ev); reset({ fieldOfView:   Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) }); });
			    Dom.on('fogDensity',     'change', function(ev) { Dom.blur(ev); reset({ fogDensity:    Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) }); });

			    function refreshTweakUI() {
			      Dom.get('lanes').selectedIndex = lanes-1;
			      Dom.get('currentRoadWidth').innerHTML      = Dom.get('roadWidth').value      = roadWidth;
			      Dom.get('currentCameraHeight').innerHTML   = Dom.get('cameraHeight').value   = cameraHeight;
			      Dom.get('currentDrawDistance').innerHTML   = Dom.get('drawDistance').value   = drawDistance;
			      Dom.get('currentFieldOfView').innerHTML    = Dom.get('fieldOfView').value    = fieldOfView;
			      Dom.get('currentFogDensity').innerHTML     = Dom.get('fogDensity').value     = fogDensity;
			    }

			    //=========================================================================

			  </script>





		</div> <!-- game div ends-->


















		<div class="container-fluid">
			<!--<h2>Welcome, <?php //echo $_SESSION["name"];?>, to Speakoo!</h2>-->
			<h3>Grammar Correction</h3>
			<?php
			$sql = "SELECT task_id, sentence_id, current_string, current_state, resolved_flag, resolving_user_id, iteration_number FROM task_table";
			
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				// output data of each row
				$flag_row_accessed=0;
				while($row = mysqli_fetch_assoc($result)) {
					
					if(!$row["resolved_flag"] ){ //later on make sure this guy has not touched this sentence before, this is the condition for finding the task to deliver in the games page 
						//echo "task found for this user";
						//echo $row["task_id"];
						
						echo "Is the highlighted sentence below grammatically accurate?<br><br>";

						//echo $row["current_string"];

						$exeDir ="\"import nltk; import json; text = nltk.word_tokenize('".$row["current_string"]."');print json.dumps(nltk.pos_tag(text))\"";
						
						$exeDir2 ="\"import nltk;text = nltk.word_tokenize('".$row["current_string"]."');print nltk.pos_tag(text)\"";
						$test = "/usr/local/bin/python -c $exeDir";
						$array_nltk= shell_exec($test);
						//echo $array_nltk;
						echo "<br><br>";
						?>
						<div id="demo"></div>
						<script>
							var cars = <?php echo $array_nltk; ?>;

							var html='';
							//console.log(cars.length);

							for (i=0; i<cars.length; i++){
								html += '<div><em>'+cars[i][1]+'</div>';
							}
							//console.log(html);
							document.getElementById("demo").innerHTML = html;
							window.alert(html);
						</script>

						<?php

						echo "<br><br>";

						$sql = "SELECT doc_id FROM sentence_table WHERE sentence_id={$row["sentence_id"]}";
						$result = mysqli_query($conn, $sql);
						$row_doc_id = mysqli_fetch_assoc($result);
						$sql = "SELECT sentence_id, sentence_string, sentence_latest_string FROM sentence_table WHERE doc_id={$row_doc_id["doc_id"]}";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row_paste_sentence = mysqli_fetch_assoc($result)) {
								if ($row_paste_sentence["sentence_id"]!=$row["sentence_id"]){
									//echo $row_paste_sentence["sentence_latest_string"].". "; // this one shows recentmost string
									echo $row_paste_sentence["sentence_string"].". ";
								}elseif($row_paste_sentence["sentence_id"]==$row["sentence_id"]) {
									echo "<b><em>".$row["current_string"].".</em></b> ";
								}
							}
						} else {
							echo "0 results";
						}
						
						?>
						<form method="POST" action="handle_user_submission.php">
						  <br><input type="radio" name="correct_or_not_0" id="yes_check" value="yes" checked> Yes<br>
						  <input type="radio" name="correct_or_not_0" id="no_check" value="no"> No<br><br>
						  <!--<span id="cor_sen_0" >Please correct the sentence: <input type="textbox" name="corrected_sentence_0" ><br><br> </span> -->
						  <span id="cor_sen_0" >Please correct the sentence:<br><textarea name="corrected_sentence_0" rows="4" cols="50"><?php echo $row["current_string"];?></textarea><br><br> </span>
						  <input type="hidden" name="pass_task_id" value="<?php echo $row["task_id"]; ?>">
						  <input type="submit" class="btn btn-default" value="Submit"/>
						</form>
						<script>
						$(document).ready(function () {
							$("#cor_sen_0").hide();
							$("#no_check").click(function () {
								$("#cor_sen_0").show();
							});
							$("#yes_check").click(function () {
								$("#cor_sen_0").hide();
							});
						});
						</script>
						<?php
						$flag_row_accessed=1; // if this 'if' condition is met even once, then flag goes to 1, hence there has been some update  
 						return; // we want to stop iterating through the task_table once we find a task that this user is allowed to resolve
					} else {
						//This particular row of task_table doesn't have any task for this user
					}
				}
				if (!$flag_row_accessed){ //task table not empty, while loop has ended, yet flag is still zero, which means none of the rows was resolved, which means we have reached the end 
					echo "Congrts! There is no more sentence to be corrected!";
				}
			} else {
				echo "task table empty";
			}
			?>
			
		</div> <!--container-fluid ends-->	
		
		<script src="wordcloudjs/d3.min.js"></script>
		<script src="wordcloudjs/cloud.min.js"></script>
	</body>
</html>	

<?php
if (isset($conn)){
	mysqli_close($conn);
}
?>