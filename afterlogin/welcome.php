<?php

	$servername="127.0.0.1";
	$username="root";
	$password="";
	$dbname="passwordmanager";

	$connect = new mysqli("$servername",$username,$password,$dbname); 
	
	session_start();
	$usernameforsession = $_SESSION['username'];
	$emailforsession = $_SESSION['email'];
	
	if(!(isset($_SESSION['username']) && isset($_SESSION['email'])))
	{
		header("location:../index.php");
	}
	
	$passcount = mysqli_query($connect,"SELECT count(password) FROM pass_store WHERE email_user = '$emailforsession'");
	$noofpass = mysqli_fetch_array($passcount);
	$nopass = $noofpass[0];	
	
	
	$passstr_vweak = mysqli_query($connect,"SELECT count(pass_strength) FROM pass_store WHERE email_user = '$emailforsession' AND pass_strength='Very Weak'");
	$noofvweakpass = mysqli_fetch_array($passstr_vweak);
	$novwpass = $noofvweakpass[0];	
	
	
	$passstr_weak = mysqli_query($connect,"SELECT count(pass_strength) FROM pass_store WHERE email_user = '$emailforsession' AND pass_strength='Weak'");
	$noofweakpass = mysqli_fetch_array($passstr_weak);
	$nowpass = $noofweakpass[0];
	
	
	$passstr_better = mysqli_query($connect,"SELECT count(pass_strength) FROM pass_store WHERE email_user = '$emailforsession' AND pass_strength='Better'");
	$noofbetterpass = mysqli_fetch_array($passstr_better);
	$nobetterpass = $noofbetterpass[0];
	
	
	$passstr_good = mysqli_query($connect,"SELECT count(pass_strength) FROM pass_store WHERE email_user = '$emailforsession' AND pass_strength='Good'");
	$noofgoodpass = mysqli_fetch_array($passstr_good);
	$nogoodpass = $noofgoodpass[0];
	   
      
    $passstr_strong = mysqli_query($connect,"SELECT count(pass_strength) FROM pass_store WHERE email_user = '$emailforsession' AND pass_strength='Strong'");
	$noofstrongpass = mysqli_fetch_array($passstr_strong);
	$nostrongpass = $noofstrongpass[0];
	
?>


<html onload="loadpage()">

<head>

<title>SafeKeep | Password Manager</title>
<link rel="icon" href="pass.jpg"/>
<meta name="author" content="Saket Jajoo">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<link rel="stylesheet" href="welcome_style.css">

<script>

$('#body').css('opacity', 0);
$(window).load(function() {
  $('#body').css('opacity', 1);
});

function logout()
{
	window.location.href = 'logout.php';
}

function cancelusermoves()
{
	document.getElementById('new_pass_form').style.display='none';
	document.getElementById('del_pass_form').style.display='none';
	document.getElementById('mod_pass_form').style.display='none';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}

function showmodpassform()
{
	document.getElementById('mod_pass_form').style.display='block';
	document.getElementById('del_pass_form').style.display='none';
	document.getElementById('new_pass_form').style.display='none';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}


function shownewpassform()
{
	document.getElementById('new_pass_form').style.display='block';
	document.getElementById('del_pass_form').style.display='none';
	document.getElementById('mod_pass_form').style.display='none';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}

function showdelpassform()
{
	document.getElementById('del_pass_form').style.display='block';
	document.getElementById('new_pass_form').style.display='none';
	document.getElementById('mod_pass_form').style.display='none';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}

function passwordStrength(password)
{
		var score   = 0;	
		var desc = new Array();	
        desc[0] = "Very Weak";
        desc[1] = "Weak";
        desc[2] = "Better";
        desc[3] = "Good";
        desc[4] = "Strong";
        
        //if password bigger than 10 give 1 point

        if (password.length > 10) score++;

        //if password has both lower and uppercase characters give 1 point

        if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

        //if password has at least one number give 1 point

        if (password.match(/d+/)) score++;

        //if password has at least one special caracther give 1 point

        if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

         document.getElementById("passwordDescription").innerHTML = desc[score];
         document.getElementById("passwordStrength").className = "strength" + score;
}

function setstrengthvalue()
{
	var temp = document.getElementById('passwordDescription').innerHTML;
	document.getElementById('passstrengthh').value = temp;	
}

function validate()
{
	var chuname = document.getElementById('chuname').value;
	var chpwd = document.getElementById('chpwd').value;
	if(chuname=='' && chpwd=='')
	{
		alert('Please fill all the fields.');
		return false;
	}
	return true;
}

function changeusername()
{
	document.getElementById('changeusername').style.display='block';
	document.getElementById('changeemail').style.display='none';
	document.getElementById('changepwd').style.display='none';
}

function changepwd()
{
	document.getElementById('changepwd').style.display='block';
	document.getElementById('changeusername').style.display='none';
}

function copytoboard()
{
	id="pass_ans";
	var sel, range;
    var el = document.getElementById(id);
    if (window.getSelection && document.createRange) 
	{
		sel = window.getSelection();
		if(sel.toString() == '')
		{
			window.setTimeout(function(){
			range = document.createRange();
            range.selectNodeContents(el);
            sel.removeAllRanges();
            sel.addRange(range);
        },1);
      }
    }
	else if (document.selection)
	{
		sel = document.selection.createRange();
        if(sel.text == '')
		{
            range = document.body.createTextRange();
            range.moveToElementText(el);
            range.select();
        }
    }
	var range = document.getSelection().getRangeAt(0);
    range.selectNode(document.getElementById("pass_ans"));
    window.getSelection().addRange(range);
    document.execCommand("copy");
//	alert("The password is copied.");
}

var length,caps,small,numbers,spe_char;

function reflectchanges()
{
	length = document.getElementById('myRange').value;
	caps = document.getElementById('capl');
	small = document.getElementById('smalll');
	numbers = document.getElementById('nos');
	spe_char = document.getElementById('special_chars');
	
	if(caps.checked)
		caps=1;
	else
		caps=0;
	
	if(small.checked)
		small=1;
	else
		small=0;
	
	if(numbers.checked)
		numbers=1;
	else
		numbers=0;
	
	if(spe_char.checked)
		spe_char=1;
	else
		spe_char=0;
	
	var items = [
  ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'],
  ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'],
  ['0','1','2','3','4','5','6','7','8','9'],
  ['!','@','#','$','%','^','&','*']
				];
	if(caps==0 && small==0 && numbers==0 && spe_char==0)
	{
		alert('Please select at least 1 of the check boxes.');
	}
	else
	{		
		var i=0,j=0,k=0,l=0,pos1=0,pos2=0;	
		var generated_password='';
		for(i=0;i<length;i++)
		{
			if(caps==0 && small==0 && numbers==0 && spe_char==1)
			{
				j=Math.floor((Math.random() * 7) + 0);
				generated_password+=items[3][j];
			}
			else if(caps==0 && small==0 && numbers==1 && spe_char==0)
			{
				j=Math.floor((Math.random() * 9) + 0);
				generated_password+=items[2][j];
			}
			else if(caps==0 && small==0 && numbers==1 && spe_char==1)
			{
				if(i<=(Math.floor(length/2)))
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
				else
				{
					j=Math.floor((Math.random() * 7) + 0);
					generated_password+=items[3][j];
				}
			}
			else if(caps==0 && small==1 && numbers==0 && spe_char==0)
			{
				j=Math.floor((Math.random() * 25) + 0);
				generated_password+=items[1][j];
			}
			else if(caps==0 && small==1 && numbers==0 && spe_char==1)
			{
				if(i<=(Math.floor(length/2)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[1][j];
				}
				else
				{
					j=Math.floor((Math.random() * 7) + 0);
					generated_password+=items[3][j];
				}
			}
			else if(caps==0 && small==1 && numbers==1 && spe_char==0)
			{
				if(i<=(Math.floor(length/2)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[1][j];
				}
				else
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
			}
			else if(caps==0 && small==1 && numbers==1 && spe_char==1)
			{
				if(i<=(Math.floor(length/3)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[1][j];
				}
				else if((i>(Math.floor(length/3))) && (i<=(Math.floor(2*length/3))))
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
				else
				{
					j=Math.floor((Math.random() * 7) + 0);
					generated_password+=items[3][j];
				}
			}
			else if(caps==1 && small==0 && numbers==0 && spe_char==0)
			{
				j=Math.floor((Math.random() * 25) + 0);
				generated_password+=items[0][j];
			}
			else if(caps==1 && small==0 && numbers==0 && spe_char==1)
			{
				if(i<=(Math.floor(length/2)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[0][j];
				}
				else
				{
					j=Math.floor((Math.random() * 7) + 0);
					generated_password+=items[3][j];
				}
			}
			else if(caps==1 && small==0 && numbers==1 && spe_char==0)
			{
				if(i<=(Math.floor(length/2)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[0][j];
				}
				else
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
			}
			else if(caps==1 && small==0 && numbers==1 && spe_char==1)
			{
				if(i<=(Math.floor(length/3)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[0][j];
				}
				else if((i>(Math.floor(length/3))) && (i<=(Math.floor(2*length/3))))
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
				else
				{
					j=Math.floor((Math.random() * 7) + 0);
					generated_password+=items[3][j];
				}
			}
			else if(caps==1 && small==1 && numbers==0 && spe_char==0)
			{
				if(i<=(Math.floor(length/2)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[0][j];
				}
				else
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[1][j];
				}
			}
			else if(caps==1 && small==1 && numbers==0 && spe_char==1)
			{
				if(i<=(Math.floor(length/3)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[0][j];
				}
				else if((i>(Math.floor(length/3))) && (i<=(Math.floor(2*length/3))))
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
				else
				{
					j=Math.floor((Math.random() * 7) + 0);
					generated_password+=items[3][j];
				}
			}
			else if(caps==1 && small==1 && numbers==1 && spe_char==0)
			{
				if(i<=(Math.floor(length/3)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[0][j];
				}
				else if((i>(Math.floor(length/3))) && (i<=(Math.floor(2*length/3))))
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
				else
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[1][j];
				}
			}
			else if(caps==1 && small==1 && numbers==1 && spe_char==1)
			{
				if(i<=(Math.floor(length/4)))
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[0][j];
				}
				else if((i>(Math.floor(length/3))) && (i<=(Math.floor(2*length/4))))
				{
					j=Math.floor((Math.random() * 9) + 0);
					generated_password+=items[2][j];
				}
				else if((i>(Math.floor(2*length/4))) && (i<=(Math.floor(3*length/4))))
				{
					j=Math.floor((Math.random() * 7) + 0);
					generated_password+=items[3][j];
				}
				else
				{
					j=Math.floor((Math.random() * 25) + 0);
					generated_password+=items[1][j];
				}
			}
		}
		var shuffled = generated_password.split('').sort(function(){return 0.5-Math.random()}).join('');
		document.getElementById('pass_ans').innerHTML=shuffled;
	}
}

function loadpage()
{
	document.getElementById('dashboard').style.display='block';
	document.getElementById('pass_generator').style.display='none';
	document.getElementById('passwords').style.display='none';
	document.getElementById('settings').style.display='none';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}

function dashshow()
{
	document.getElementById('dashboard').style.display='block';
	document.getElementById('pass_generator').style.display='none';
	document.getElementById('passwords').style.display='none';
	document.getElementById('settings').style.display='none';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}
function geneshow()
{
	document.getElementById('dashboard').style.display='none';
	document.getElementById('pass_generator').style.display='block';
	document.getElementById('passwords').style.display='none';
	document.getElementById('settings').style.display='none';
	reflectchanges();
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}
function passshow()
{
	document.getElementById('dashboard').style.display='none';
	document.getElementById('pass_generator').style.display='none';
	document.getElementById('passwords').style.display='block';
	document.getElementById('settings').style.display='none';
	
	document.getElementById('new_pass_form').style.display='none';
	document.getElementById('del_pass_form').style.display='none';
	document.getElementById('mod_pass_form').style.display='none';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}
function settshow()
{
	document.getElementById('dashboard').style.display='none';
	document.getElementById('pass_generator').style.display='none';
	document.getElementById('passwords').style.display='none';
	document.getElementById('settings').style.display='block';
	
	document.getElementById('changeusername').style.display='none';
	document.getElementById('changepwd').style.display='none';
}

var map, infoWindow;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 6
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyrqWpU85uEYIBdWLQXMzhDRAfPbjJRCc&callback=initMap"></script>

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() 
{
  var data_count = google.visualization.arrayToDataTable([
  ['Passwords', 'Count'],
  ['Your Password(s)', <?php echo $nopass; ?>]
]);

  var options_count = {
    title: 'Number Of Passwords',
    backgroundColor: '#333333',
	'width':550, 
	'height':400,
    legendTextStyle: { color: '#FFF' },
    titleTextStyle: { color: '#FFF' },
    hAxis: {
      color: '#FFF',
    }
  };  
  
  var data_strength = google.visualization.arrayToDataTable([
  ['Passwords', 'Strength'],
  ['Very Weak', <?php echo $novwpass; ?>],
  ['Weak', <?php echo $nowpass; ?>],
  ['Better', <?php echo $nobetterpass; ?>],
  ['Good', <?php echo $nogoodpass; ?>],
  ['Very Strong', <?php echo $nostrongpass; ?>]
]);

  var options_strength = {
    title: 'Strength Of Passwords',
    backgroundColor: '#333333',
	'width':550, 
	'height':400,
    legendTextStyle: { color: '#FFF' },
    titleTextStyle: { color: '#FFF' },
    hAxis: {
      color: '#FFF',
    }
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  var chart_strength = new google.visualization.PieChart(document.getElementById('piechartforstrength'));
  chart.draw(data_count,options_count);
  chart_strength.draw(data_strength,options_strength);
}
</script>

</head>

<body oncontextmenu="return false;" onload="loadpage()" id="body">

	<div id="main_head">
		<div id="main_heading">
			<div id="heading_content">
				SafeKeep | Welcome <?php echo $_SESSION['username'];?>
			</div>
		</div>
	</div>

	<div id="left-aside-menu">
		<nav>
			<ul id="mm" class="mm">
				<li><button onclick="dashshow()">Dashboard</button></li></br>
				<li><button onclick="passshow()">Passwords</button></li></br>
				<li><button onclick="geneshow()">Generator</button></li></br>
				<li><button onclick="settshow()">Settings</button></li></br>
				<li><button onclick="logout()">Logout</button></li></br>
			</ul>
		</nav>
	</div>
	
	<center>
	<div id="dashboard">
		<div id="passstats">
			<div id="passstats_head">
				<div id="passstats_head_content" class="right-disp-menu-headers">
					Password Stats
				</div>
			</div>
			<hr>
			<div id="passstats_main">
				<div id="passstats_main_content">
					<center>
					<div id="piechart"></div>
					</center>
				</div>
			</div>
		</div>
		<div id="passstrength">
			<div id="passstrength_head">
				<div id="passstrength_head_content" class="right-disp-menu-headers">
					Password Strengths
				</div>
			</div>
			<hr>
			<div id="passstrength_main">
				<div id="passstrength_main_content">
					<center>
					<div id="piechartforstrength"></div>
					</center>
				</div>
			</div>
		</div>
		<div id="signinmap">
			<div id="signinmap_head">
				<div id="signinmap_head_content" class="right-disp-menu-headers">
					Recent Sign-In Map
				</div>
			</div>
			<hr>
			<div id="signinmap_main">
				<div id="signinmap_main_content">
					<center>
					<div id="map"></div>
					</center>
				</div>
			</div>
		</div>
	</div>
	</center>
	
	
	
	
	
	
	<center>
	<div id="pass_generator">
		<div id="pass_gene">
			<div id="passsgene_head">
				<div id="passgene_head_content" class="right-disp-menu-headers">
					Password Generator
				</div>
			</div>
			<hr>
			<div id="passgene_main">
				<div id="passgene_main_content">
					<center>
						<div id="generate_pass">
							
							<div id="pass_ans">
							</div>
							<div id="copytoclipboard">
								<button id="copytoclipboard_content" class="copybutton" onclick="copytoboard()" title="Double click to copy the password.">Copy</button>
							</div>
							
							<div id="slider">
								<div class="slidecontainer">
									<input type="range" min="4" max="30" value="10" class="slider" id="myRange" onchange="reflectchanges()">
								</div>
							</div>						
							
							<div class="control-group">
								<label class="control control--checkbox">A-Z
								<input type="checkbox" checked="checked" id="capl" onchange="reflectchanges()"/>
								<div class="control__indicator"></div>
								</label>
								
								<label class="control control--checkbox">a-z
								<input type="checkbox" checked="checked" id="smalll" onchange="reflectchanges()"/>
								<div class="control__indicator"></div>
								</label>
	
								<label class="control control--checkbox">0-9
								<input type="checkbox" checked="checked" id="nos" onchange="reflectchanges()"/>
								<div class="control__indicator"></div>
								</label>
								
								<label class="control control--checkbox"> !@#$%*^&
								<input type="checkbox" checked="checked" id="special_chars" onchange="reflectchanges()"/>
								<div class="control__indicator"></div>
								</label>
							</div>
							
						</div>
					</center>
				</div>
			</div>
		</div>
	</div>
	</center>
	
	
	
	
	
	<center>
	<div id="settings">
		<div id="settings_head">
			<div id="settings_head_content" class="right-disp-menu-headers">
				Settings
			</div>
		</div>
		<hr>
		<div id="reg_details">
			<table>
				<tr>
					<td class="table_headers">Registration Date</td>
					<td class="table_ans" colspan="3">
					<?php
						$check_for_user = "SELECT * FROM pass_login WHERE username='$usernameforsession'";
						$tp = $connect->query($check_for_user);
						while($row = $tp->fetch_assoc())
						{
							$date = $row['reg_date'];
							$time = $row['reg_time(GMT)'];
						}
						echo "$date | $time (GMT)";
					?>
					</td>
				</tr>
				<tr>
					<td class="table_headers">User ID</td>
					<td class="table_ans" colspan="2">
					<?php
						$check_for_user = "SELECT * FROM pass_login WHERE username='$usernameforsession'";
						$tp = $connect->query($check_for_user);
						while($row = $tp->fetch_assoc())
						{
							$uname = $row['username'];
						}
						echo "$uname";
					?>
					</td>
					<td>
						<div id="changeuid">
							<button id="changeuserid" class="changebutton" onclick="changeusername()">Change</button>
						</div>
					</td>
				</tr>
				<tr>
					<td class="table_headers">Email</td>
					<td class="table_ans" colspan="3">
					<?php
						$check_for_user = "SELECT * FROM pass_login WHERE username='$usernameforsession'";
						$tp = $connect->query($check_for_user);
						while($row = $tp->fetch_assoc())
						{
							$email = $row['email'];
						}
						echo "$email";
					?>
					</td>
				</tr>
				<tr>
					<td class="table_headers">Password</td>
					<td class="table_ans" colspan="2">
					<?php
						$check_for_user = "SELECT * FROM pass_login WHERE username='$usernameforsession'";
						$tp = $connect->query($check_for_user);
						while($row = $tp->fetch_assoc())
						{
							$password = $row['password'];
						}
						//echo "$password";
						echo "<i>Cannot be showed for security reasons</i>";
					?>
					</td>
					<td>
						<div id="changeuid">
							<button id="changeuserid" class="changebutton" onclick="changepwd()">Change</button>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	</center>
	 
	
	<center>
	<div id="changeusername">
		<div id="changeusername_text">
			<center>
			<form method="post" action="updatedetails.php" onsubmit="return validate()">
				<input type="text" placeholder="User ID" name="chhuname" id="chuname"/>
				</br>
				<button value="submit" name="submituser" id="subuser" class="submitbtn">Submit</button>
			</form>
			</center>
		</div>
	</div>
	<div id="changepwd">
		<div id="changepwd_text">
			<center>
			<form method="post" action="updatedetails.php" onsubmit="return validate()">
				<input type="password" placeholder="Password" name="chhpwd" id="chpwd"/>
				</br>
				<button value="submit" name="submitpwd" id="subpwd" class="submitbtn">Submit</button>
			</form>
			</center>
		</div>
	</div>
	</center>
	
	
	
	
	<center>
	
	<div id="passwords">
		<div id="passwords_head">
			<div id="passwords_head_content" class="right-disp-menu-headers">
				Passwords
			</div>
		</div>
		<hr>
		<div id="passwords_main">
			<center>
			<div id="addanddel_pass">
				<center>
				<div id="addanddel_pass_content">
					<div id="add_pass_conent" class="pass_buttons" id="add_btn">
						<button onclick="shownewpassform()">New Password</button>
					</div>
					<div id="modify_pass_conent" class="pass_buttons" id="modify_btn">
						<button onclick="showmodpassform()">Modify Password</button>
					</div>
					<div id="del_pass_conent" class="pass_buttons" id="del_btn">
						<button onclick="showdelpassform()">Delete Password</button>
					</div>					
				</div>
				<hr id="after_btn">
				</center>
			</div>
			</center>
			
			<center>
			<div id="userpasswords">
			<?php
			
			$show_pass = "SELECT * FROM pass_store WHERE email_user = '$emailforsession'";
			$result = $connect->query($show_pass);
			if($result->num_rows > 0)
			{
				?>
				<table class="pass_table">
					<tr class="pass_table_header">
						<td class="pass_table_header">Name</td>
						<td class="pass_table_header">Website</td>
						<td class="pass_table_header">Password</td>
						<td class="pass_table_header">Email ID</td>
					</tr>
				<?php
					while($row = $result->fetch_assoc())
					{	
						$password = '3sc3RLrpd17';
						$method = 'aes-256-cbc';
						$key = $row['passkey'];
						$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
						$decrypted = openssl_decrypt(base64_decode($row['password']), $method, $key, OPENSSL_RAW_DATA, $iv);
						
						
						
						echo "
							<tr class='pass_table'>
								<td class='pass_table'>".$row['name']."</td>
								<td class='pass_table'>".$row['website']."</td>
								<td class='pass_table'>".$decrypted."</td>
								<td class='pass_table'>".$row['email_website']."</td>
							</tr>
						";
					}					
				?>				
				</table>
			<?php			
			}
			?>
			</div>
			
			<div id="new_pass_form">
				<div id="new_pass_form_content">
					<form action="add_newdet.php" method="post">
						<input id="new_name" placeholder="Name" name="new_name" class="name" type="text" required></input>
						</br>
						<input id="new_website" placeholder="Website" name="new_website" type="text" required></input>
						</br>
						<input id="new_email" placeholder="Email" type="text" name="new_email" required></input>
						</br>
						<input type="password" name="new_pass" id="new_pass" placeholder="Password" onkeyup="passwordStrength(this.value)" />
						<div id="passwordDescription">Password not entered</div>
						<center><div id="passwordStrength" onchange="setstrengthvalue()" class="strength0"></div></center>
						</br>
						<input type="hidden" id="passstrengthh" name="passstrengthh" value=""/>
						<button id="new_submit" name="new_submit" value="submit" class="pass_form_submit-btn" onclick="setstrengthvalue()" type="submit" title="Add to List">Submit</button>
					</form>
					<button id="canceluseracc" name="cancel" value="cancel" class="pass_form_submit-btn" onclick="cancelusermoves()" title="Close">Cancel</button>
				</div>
			</div>
			
			
			<div id="del_pass_form">
				<div id="del_pass_form_content">
					<form action="del_passdet.php" method="post">
						<input id="del_name" placeholder="Name" name="del_name" class="name" type="text" required></input>
						</br>
						<input id="del_website" placeholder="Website" name="del_website" type="text" required></input>
						</br>
						<button id="del_submit" name="del_submit" value="submit" class="pass_form_submit-btn" type="submit" title="Delete Password">Delete</button>
					</form>
					<button id="canceluseracc" name="cancel" value="cancel" class="pass_form_submit-btn" onclick="cancelusermoves()" title="Close">Cancel</button>
				</div>
			</div>
			
			
			<div id="mod_pass_form">
				<div id="mod_pass_form_content">
					<form action="mod_passdetl.php" method="post">
						<input id="mod_prev_name" placeholder="Previous Name" name="mod_prev_name" class="prev_name" type="text" required></input>
						</br>
						<input id="mod_name" placeholder="New Name" name="mod_name" class="name" type="text" required></input>
						</br>
						<input id="mod_website" placeholder="Website" name="mod_website" type="text" required></input>
						</br>
						<input type="password" name="mod_pass" id="mod_pass" placeholder="Password"/>
						</br>
						<button id="mod_submit" name="mod_submit" value="submit" class="pass_form_submit-btn" type="submit" title="Modify Password">Modify</button>
					</form>
					<button id="canceluseracc" name="cancel" value="cancel" class="pass_form_submit-btn" onclick="cancelusermoves()" title="Close">Cancel</button>
				</div>
			</div>
			
			
			</center>
		</div>
	</div>
	
	</center>
</body>

</html>