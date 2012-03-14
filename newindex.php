
<?php
session_start();

if ($_SESSION['loggedIn'] != true)
  header('location:forms/login.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"[]>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
   
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>NexISgen.com - BIT561</title>
    <meta name="description" content="Class project for BIT 286 - BIT561- Professional Tools. Mission

Construct a database driven website which supports the development of professional knowledge in a variety of languages; supports the documentation and integration of the work of software project team members; and increases the long-term productivity of IT professionals.
" />
    <meta name="keywords" content="the,next,generation,information,technology,club,cascadia,community,college,bothell,bit286,bit561,professional tools" />


    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="script.js"></script>
   <style type="text/css">
.art-post .layout-item-0 { color: #0A2D47; background:repeat #F5F5F5; }
.art-post .layout-item-1 { margin-bottom: 20px; }
.art-post .layout-item-2 { padding: 20px; }
.art-post .layout-item-3 { color: #0A2D47; background:repeat #F5F5F5; padding: 20px; }
   .ie7 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
   .ie6 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
   </style>

</head>
<body>
<div id="art-page-background-glare-wrapper">
    <div id="art-page-background-glare"></div>
</div>
<div id="art-main">
    <div class="cleared reset-box"></div>
    <div class="art-header">
        <div class="art-header-position">
            <div class="art-header-wrapper">
                <div class="cleared reset-box"></div>
                <div class="art-header-inner">
                <div class="art-headerobject"></div>
                <div class="art-logo">
                                 <h1 class="art-logo-name"><a href="../newindex.php">BIT 285 Class Project</a></h1>
                                                 <h2 class="art-logo-text">NexISgen.Com - BIT561 - Professional Software Development Tools</h2>
                                </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="cleared reset-box"></div>
<div class="art-bar art-nav">
<div class="art-nav-outer">
<div class="art-nav-wrapper">
<div class="art-nav-inner">
	<ul class="art-hmenu">
		<li>   
                 <a href="index.php" class="active">Home</a>
		</li>
<li><a href="#">Forms</a>
<ul>	
		<li>
                        <a href="../bit561/forms/projectfiles.php" class "active">Project Files</a>
                </li>
<li>
<a href="../bit561/forms/users.php">Users</a>
</li>
</ul>
			
<li>
<a href="../bit561/forms/login.php#">Login</a>

		<ul>
                
                  
                
                  <li>
                    <a href="https://github.com/tfinnell/bit561">GitHub Project</a>
                  </li>
                 

	</ul>
		</li>	
	</ul>
</div>
</div>
</div>
</div>
<div class="cleared reset-box"></div>
<div class="art-box art-sheet">
        <div class="art-box-body art-sheet-body">
            <div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
                                <div class="art-postcontent">
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell layout-item-0" style="width: 33%;">
        <h3 style="text-align: center;">Features</h3>
<p>List of project featuers goes here</p>
    </div><div class="art-layout-cell layout-item-0" style="width: 34%;">
        <h3 style="text-align: center;">Mission</h3>
<p>Construct a database driven website which supports the development of professional knowledge in a variety of languages; supports the documentation and integration of the work of software project team members; and increases the long-term productivity of IT professionals. </p>
    </div><div class="art-layout-cell layout-item-0" style="width: 33%;">
        <h3 style="text-align: center;">Benefits</h3>
<p>Project benefits info goes here</p>
    </div>
    </div>
</div>
<div class="art-content-layout-wrapper layout-item-1">
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell" style="width: 33%;">
        <p><img width="195" height="195" alt="" src="./images/contentimage7.png" style="margin:0;" /></p>
        
        <p style="text-align: center;"><a href="http://www.freedigitalphotos.net/images/view_photog.php?photogid=721">Image: renjith krishnan / FreeDigitalPhotos.net</a></p>
    </div><div class="art-layout-cell" style="width: 34%;">
        <p style="text-align: center;"><img width="195" height="195" alt="" src="./images/contentimage6.png" style="margin:0;" /></p>
        
        <p style="text-align: center;"><a href="http://www.freedigitalphotos.net/images/view_photog.php?photogid=721">Image: renjith krishnan / FreeDigitalPhotos.net</a></p>
    </div><div class="art-layout-cell" style="width: 33%;">
        <p style="text-align: center;"><img width="195" height="195" alt="" src="./images/contentimage4.png" style="margin:0;" /></p>
        
        <p style="text-align: center;"><a href="http://www.freedigitalphotos.net">Image: FreeDigitalPhotos.net</a></p>
    </div>
    </div>
</div>
</div>
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell layout-item-2" style="width: 33%;">
        <h3 style="text-align: center;">Latest Updates</h3>
        
        <ul>
            <li>Student hosting BETA site launched 1/22/2012.</li>
        
            <li>Game design group moves forward with B.I.T. Spring Technology Fair 2012.</li>
        
            <li>Web hosting managment internships in the works.</li>
        
            <li>Robotics group builds bluetooth controled robot.</li>
        
            <li>Android applications coming soon.</li>
        </ul>
        
        <p><a href="https://cascadia.collegiatelink.net/organization/The_Next_Generation_I_T_Club" class="art-button">Learn more</a></p>
    </div><div class="art-layout-cell layout-item-3" style="width: 67%;">
        <h3 style="text-align: center;">Project Vision</h3>
        <p>The path to profound knowledge and wisdom in a field can be elusive. In a book entitled “Talent is Overrated” Geoff Colvin sums up the research on the development of expertise as a two part proposition: (1) you have to put your 10,000 hours in, and (2) you have to engage in deliberate practice. Research in a number of fields has shown that simply putting in your time is not enough.  As Colvin puts it, “…many people not only failed to become outstandingly good at what they do, no matter how many years they spend doing it, they frequently don’t even get any better than they were when they started.”  Nonetheless, you have to put the time in.  Colvin cites considerable research which casts doubt on the idea of innate talent being much of a predictor of superior performance.</p>  
<p>Along with the time on task (10,000 hours minimum) comes the idea of deliberate practice.  You must focus on what you don’t know. Again in Colvin’s words, “…deliberate practice requires that one identify certain sharply defined elements of performance that need to be improved, and then work intensely on them…. The great performers isolate remarkably specific aspect of what they do and focus on just those things until they are improved; then it’s on to the next aspect.” Deliberate practice, focusing on what you do not know, is fairly intense.  It takes working up to and even in high level performers four hours a day of deliberate practice is about all they can handle.</p>

<p>In a cognitive field like information technology your ability to learn quickly is an essential skill.  It is a skill that improves as your knowledge base gets larger.  Our capacity to remember well is fairly specific to our field of expertise.  “Indeed, top performers’ deep understanding of their field becomes the structure on which they can hang the huge quantities of information they learn about it…. It’s clear that the superior memory of great performers doesn’t just happen.  Since it is built on deep understanding of the field, it can be achieved only through years of intensive study.” [Geoffrey Colvin]</p>

<p>Professional expertise, then, comes with a price tag, the learning curve must be scaled with effort and with carefully structured practice. The IT field is no exception, but what is particularly odd about IT is that there is so little discussion of the tool set that could be created on a computer to help with the process. What would a tool that assists in the development of a professional skill set look like?</p>

<p>Some suggestions for inclusion in ProTools</p>

        <ol>
            <li>A professional toolkit would presumably include tested and debugged code that could be reused.  For example, validation is a necessity for data in any application.  The code used to provide validation could be structured to make it easy to include in both the front end and the middle tier.  The code could also coordinate validation in the two places through the database.  Other examples would include code to handle data passage between the browser and the database.  Code that we create for ourselves needs to be located (where are we storing it) and documented.</li>
            <li>    Tested and debugged code might not be stored in separate files.  Smaller pieces of reusable code (snippets) might be kept in a database.  The code might be directly drawn from the database for inclusion in applications dynamically.  HTML particularly lends itself to this use.  The snippets also might be simply stored for cut and paste inclusion into an application.</li>
            <li>    Code and discussion might also be created simply for the purpose of studying a language.  An example might be using callbacks in PHP function parameter lists.  Some sample code on what it looks like and some discussion might be included just to help prevent forgetting how it works.</li>
            <li>    Non code discussion of data processing information that you want to remember could also be included.  Discussions and recording of ideas from agile methodology might be an example.</li>
            <li>    Information tracking coding standards that will be followed in one’s professional programming efforts might also be of interest.</li>
            <li>    URL storage of web sites that have useful programming information would be valuable.  The problem with favorite lists on browsers is that they don’t follow us as we move about the web.  There are some good web sites for sharing URLs with other people on the Web, however, they are standalone applications that do not necessarily integrate well with other stored professional knowledge.</li>
            <li>    Evaluations of available software tools could also prove useful.  The proliferation of high quality frameworks helping solve various application problems is hard to keep up with available solutions.</li>
            <li>    Since documentation is a professional necessity, the site should support and encourage good documentation habits.  The tools should support the creation of automatically generated documentation in web site form.  In so far as possible documentation should be driven by information contained within the source code documents creating a software application.</li>
            <li>    Integration of work is a major concern for IT professionals, and so the site should provide support for the integration of project work.  In particular the small tasks derived from the overall project vision and used to create product (overall) and sprint (short interval) backlogs should be published in the database.  Who has committed to work on small projects, time estimates, and actual completion information is valuable and needs to be tracked for each project a team or individual undertakes.  The tracking allows improvement and agile is focused on continuous improvement.</li>
        </ol>
            <p>Expecting every programmer to build a site for their own professional use is unrealistic.  It’s a problem that takes considerable effort to resolve well.  Individuals cannot and do not undertake it lightly.  It’s a common problem for IT people and consequently it’s a problem that should have one or a few generic tools available for long term professional development.  A group of IT knowledgeable folks should have better success at solving the problem than an individual would have.</p>

            <p>A site supporting professional development would need to provide that support over an extended time period—careers last for 40 years and beyond.  </p>

            <p>The site would be driven by open source licensed code. Any professional using it could have access to the code driving the site so as to permit modification and extension.  Presumably, many groups might want to create a clone of the site for their specific purposes and to gain control over the long term viability of their particular site.</p>
        
        </p>
        <p style="text-align: center;"><img width="300" height="200" alt="" src="./images/clublogo.png" /></p>
        
        <p style="text-align: center;font-weight: bold;"> <span style="color: rgb(35, 141, 222);"><a href="https://www.facebook.com/pages/The-Next-Generation-IT-Club-tngitccom/240155819383182?skip_nax_wizard=true">CLUB FACEBOOK PAGE</a></br>Meetings: Wednesday 11 am - 1 pm Room: CC3-234</br>Cascadia Community College, Bothell, WA</br>
            
            
            </span></p>
    </div>
    </div>
</div>

                </div>
                <div class="cleared"></div>
                </div>

		<div class="cleared"></div>
    </div>
</div>

                          <div class="cleared"></div>
                        </div>
                        <div class="art-layout-cell art-sidebar1">
<div class="art-box art-block">
    <div class="art-box-body art-block-body">
                <div class="art-bar art-blockheader">
                    <h3 class="t">Free Hosting Benefits</h3>
                </div>
                <div class="art-box art-blockcontent">
                    <div class="art-box-body art-blockcontent-body">
                <p><img width="53" height="53" alt="" src="./images/1.png" style="float: left; margin:10px;" /></p>

<p><span style="font-weight: bold;">Free CPANEL LINUX Cloud Hosting</span></p>

<p>100 MB of space for your project portfolio.</p><br />

<p><img width="53" height="53" alt="" src="./images/2.png" style="float: left; margin:10px;" /></p>

<p><span style="font-weight: bold;">1 Click Installs</span></p>

<p>50+ 1 click install applications for you to use and experiment with.</p><br />

<p><img width="53" height="53" alt="" src="./images/3.png" style="float: left; margin:10px;" /></p>

<p><span style="font-weight: bold;">Expandable accounts</span></p>

<p><span style="font-weight: bold;"></span>Keep your class projects available to the public from class to class and after you graduate while you are looking for paying clients or jobs.</p><p> Until we get our local servers setup we have found a cool free solution for you to try. Some of our members have used this system and found it to be a nice solution for a small site to test out projects on.</p>                
                                		<div class="cleared"></div>
                    </div>
                </div>
		<div class="cleared"></div>
    </div>
</div>
<div class="art-box art-block">
    <div class="art-box-body art-block-body">
                <div class="art-bar art-blockheader">
                    <h3 class="t">Need a Free Website?</h3>
                </div>
                <div class="art-box art-blockcontent">
                    <div class="art-box-body art-blockcontent-body">
                <p style="text-align: center;"><img width="209" height="208" alt="" src="./images/blockimage2.png" /></p>

<p><a href="https://hostzil.la/user/aff.php?aff=345" class="art-button">Start here</a></p>                
                                		<div class="cleared"></div>
                    </div>
                </div>
		<div class="cleared"></div>
    </div>
</div>

                          <div class="cleared"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cleared"></div>
            <div class="art-footer">
                <div class="art-footer-body">
                    
                            <div class="art-footer-text">
                                <br />
Copyleft © 2012 The Next Generation I.T. Club All Rights Public Domain<br />
<br />
                                <div class="cleared"></div>
                                <p class="art-page-footer"></p>
                            </div>
                    <div class="cleared"></div>
                </div>
            </div>
    		<div class="cleared"></div>
        </div>
    </div>
    <div class="cleared"></div>
</div>

</body>
</html>