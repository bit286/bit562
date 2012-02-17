<?php>
	$menuitem = $_REQUEST['menuitem'];
	$htmlNames = array(
					"fees" => "FeeSchedule.html",
					"growthring" => "GrowthRings.html",
					"benefits" => "Benefits.html",
					"feedback" => "SiteFeedback.html",
					"philosophy" => "Philosophy.html",
					"bio" => "bio1.html",
					"findACoach" => "findACoach.html",
					"contact" => "contact.html",
					"confidentiality" => "confidentiality.html",
					"summary" => "summary.html"
				);
?>

<html>
<head>
<title>Growth-Ring-Coaching</title>

<link rel="stylesheet" type="text/css" href="/tools/javascript.css" />
<link rel="stylesheet" type="text/css" href="/css/home.css" />

<!-- Put some Javascript tags and Javascript right after this comment. -->
<script type="text/javascript" src="/tools/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="/tools/TestSuite.js"></script>
<script type="text/javascript" src="/tools/utilities.js"></script>
<script type="text/javascript" src="/tools/request.js"></script>
<script type="text/javascript" src="/javascript/tools/getElements/getElements.js"></script>
<script type="text/javascript" src="/base/structure.js"></script>
<script type="text/javascript" src="/base/view.js"></script>
<script type="text/javascript" src="/base/formhandler.js"></script>
<script type="text/javascript" src="/base/carousel.js"></script>
<script type="text/javascript" src="/elaboration/elaboration.js"></script>

</head>
<body>

<div id="resultsOfTests">
	<h4 align="left">Assert Test Results</h4>
	<ul id="resultsList"></ul>
</div>

<!-- Your html goes here. -->
<div id="bigdeal">
	<img src="../images/logo2.jpg" width="148" height="51"></img>
</div> 
  
<div id="HomeTitle">
	<img src="../images/title.jpg" width="807" height="51"></img>
</div>

<div id="elaborationFrame">
	<img src="../images/elaborationMenu.jpg" usemap="#elaborationMap" border="0"></img>
</div>

<div id="grayImage">
	<img src="../images/graypoint.gif" width="250" height="606" border="0"></img>
</div>

<div id="elaborationTextImage">
	<img src="../images/elaborationText.jpg" width="765"></img>
</div>	

<div id="elaborationMenu">
	<span id="benefits" class="menuItem">&nbsp;&nbsp;Benefits&nbsp;&nbsp</span><br />
	<span id="philosophy" class="menuItem">&nbsp;&nbsp;Philosophy&nbsp;&nbsp;</span><br />
	<span id="account" class="menuItem">&nbsp;&nbsp;Account Mgmt</span><br />
	<span id="essays" class="menuItem">&nbsp;&nbsp;Essays&nbsp;&nbsp;</span><br />
	<span id="tools" class="menuItem">&nbsp;&nbsp;Tools&nbsp;&nbsp;</span><br />
	<span id="growthring" class="menuItem">&nbsp;&nbsp;GrowthRings</span><br />
	<span id="fees" class="menuItem">&nbsp;&nbsp;Fee Schedule&nbsp;&nbsp;</span><br />
	<span id="confidentiality" class="menuItem">&nbsp;&nbsp;Confidentiality&nbsp;&nbsp</span><br />
	<span id="findACoach" class="menuItem">&nbsp;&nbsp;Find a Coach&nbsp;&nbsp</span><br />
	<span id="bio" class="menuItem">&nbsp;&nbsp;Bio&nbsp;&nbsp;</span><br />
	<span id="contact" class="menuItem">&nbsp;&nbsp;Contact Me&nbsp;&nbsp;</span><br />
	<span id="feedback" class="menuItem">&nbsp;&nbsp;Feedback&nbsp;&nbsp</span><br />
	<span id="summary" class="menuItem">&nbsp;&nbsp;Summary&nbsp;&nbsp;</span><br />
</div>

<div id="elaborationText">
</div>

<map name="elaborationMap">
	<area shape="rect" coords="20,14,187,66" id="home" />
</map>

<script>

	var seeker = { "tableName" : "marker" };
	marker(seeker);

	loadNewPage("<?php echo $htmlNames[$menuitem] ?>");
	
</script>

</body>
</html>
