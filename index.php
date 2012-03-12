<?php
session_start();

if ($_SESSION['loggedIn'] != true)
  header('location:forms/login.php');

?>

<html>
<head>
<title>BIT 285 Class Project: BIT561 Vision Statement and Test Menu</title>
<style type="text/css">ol{margin:0;padding:0}p{margin:0}.c1{padding-left:0pt;direction:ltr;margin-left:18pt}.c6{max-width:468pt;background-color:#ffffff;padding:72pt 72pt 72pt 72pt}.c4{list-style-type:decimal;margin:0;padding:0}.c0{height:11pt;direction:ltr}.c3{font-weight:bold}.c10{text-align:center}.c5{font-size:18pt}.c2{direction:ltr}.c9{text-decoration:underline}.c8{color:#ff0000}.c7{font-size:14pt}.title{padding-top:24pt;line-height:1.15;text-align:left;color:#000000;font-size:36pt;font-family:Verdana;font-weight:bold;padding-bottom:6pt}.subtitle{padding-top:18pt;line-height:1.15;text-align:left;color:#666666;font-style:italic;font-size:24pt;font-family:Georgia;padding-bottom:4pt}body{color:#000000;font-size:11pt;font-family:Verdana}h1{padding-top:12pt;line-height:1.15;text-align:left;color:#000000;font-size:16pt;font-family:Arial;font-weight:bold;padding-bottom:3pt}h2{padding-top:12pt;line-height:1.15;text-align:left;color:#000000;font-style:italic;font-size:14pt;font-family:Arial;font-weight:bold;padding-bottom:3pt}h3{padding-top:12pt;line-height:1.15;text-align:left;color:#000000;font-size:13pt;font-family:Arial;font-weight:bold;padding-bottom:3pt}h4{padding-top:12pt;line-height:1.15;text-align:left;color:#000000;font-size:14pt;font-family:Verdana;font-weight:bold;padding-bottom:3pt}h5{padding-top:12pt;line-height:1.15;text-align:left;color:#000000;font-style:italic;font-size:13pt;font-family:Verdana;font-weight:bold;padding-bottom:3pt}h6{padding-top:12pt;line-height:1.15;text-align:left;color:#000000;font-size:11pt;font-family:Verdana;font-weight:bold;padding-bottom:3pt}</style>

</head>
<body class="c6">
<h1><span style="font-family: wp_bogus_font">NexISgen.Com</span></h1>
<p align="center"><font face="wp_bogus_font"><br />
</font></p>
<h2><font face="wp_bogus_font">&quot;ProTools&quot;</font></h2>
<p align="center"><font face="wp_bogus_font">Opensource Code Documentation and Presentation system</font></p>
<p align="center"><font face="wp_bogus_font"><br />
</font></p>
<ol>
<li><a title="" href="php/jumpPointDoc.php" style="font-family: wp_bogus_font">RUN</a><span style="font-family: wp_bogus_font">&nbsp;jumpPointDoc.php : Run all files in projectfiles db through html wrapping function and store the output in the doc folder.</span></li>
<li><a title="" href="jsTest.php" style="font-family: wp_bogus_font">RUN</a><span style="font-family: wp_bogus_font">&nbsp;.JS file test</span></li>
<li><a title="" href="cssTest.php" style="font-family: wp_bogus_font">RUN</a><span style="font-family: wp_bogus_font"> .CSS file test</span></li>
<li><a title="" href="phpTest.php" style="font-family: wp_bogus_font">RUN</a><span style="font-family: wp_bogus_font"> .PHP file test</span></li>
<li><a title="" href="forms/projectfiles.php" style="font-family: wp_bogus_font">RUN</a><span style="font-family: wp_bogus_font"> projectfiles form</span></li>
<li><a title="" href="forms/users.php" style="font-family: wp_bogus_font">RUN</a><span style="font-family: wp_bogus_font"> users form</span></li>
<li><a title="" href="doc/" style="font-family: wp_bogus_font">Open </a><span style="font-family: wp_bogus_font">Project Output Docs Folder</span></li>
<li><a title="" href="GoogleDocsBackup/" style="font-family: wp_bogus_font">Open </a><span style="font-family: wp_bogus_font">Project Google Docs Backup Folder</span></li>
<li><a title="" href="https://github.com/tfinnell/bit561" style="font-family: wp_bogus_font">Open </a><span style="font-family: wp_bogus_font">GITHUB.COM Project Download</span></li>
<li><a title="" href="http://www.nexisgen.com/cpanel" style="font-family: wp_bogus_font">Open </a><span style="font-family: wp_bogus_font">NexISgen.com CPANEL login to manage the public web site.</span></li>

</ol>
<p align="left"><font face="wp_bogus_font"><br />
</font></p>
<p align="center"><font face="wp_bogus_font"><br />
</font></p>
<p class="c10 c2"><span class="c3 c5">Professional Development Software</span></p>
<p class="c0 c10"><span class="c3 c5"></span></p>
<p class="c2"><span class="c3 c7">Vision:</span></p>
<p class="c0"><span class="c3 c7"></span></p>
<p class="c2"><span>The path to profound </span><span>knowledge and wisdom in a field can be elusive.</span><span>&nbsp;In a book entitled &ldquo;Talent is Overrated&rdquo; Geoff Colvin sums up the research on the development of expertise as a two part proposition: (1) you have to put your 10,000 hours in, and (2) you have to engage in deliberate practice. Research in a number of fields has shown that simply putting in your time is not enough. &nbsp;As Colvin puts it, &ldquo;&hellip;many people not only failed to become outstandingly good at what they do, no matter how many years they spend doing it, they frequently don&rsquo;t even get any better than they were when they started.&rdquo; &nbsp;Nonetheless, you have to put the time in. &nbsp;Colvin cites considerable research which casts doubt on the idea of innate talent being much of a predictor of superior performance. &nbsp;</span></p>
<p class="c0"><span></span></p>
<p class="c2"><span>Along with the time on task (10,000 hours minimum) comes the idea of deliberate practice. &nbsp;You </span><span>must</span><span>&nbsp;focus on what you don&rsquo;t know. Again in Colvin&rsquo;s words, &ldquo;&hellip;deliberate practice requires that one identify certain sharply defined elements of performance that need to be improved, and then work intensely on them&hellip;. The great performers isolate remarkably specific aspect of what they do and focus on just those things until they are improved; then it&rsquo;s on to the next aspect.&rdquo; Deliberate practice, focusing on what you do not know, is fairly intense. &nbsp;It takes working up to and even in high level performers four hours a day of deliberate practice is about all they can handle.</span></p>
<p class="c0"><span></span></p>
<p class="c2"><span>In a cognitive field like information technology your ability to learn quickly is an essential skill. &nbsp;It is a skill that improves as your knowledge base gets larger. &nbsp;Our capacity to remember well is fairly specific to our field of expertise. &nbsp;&ldquo;Indeed, top performers&rsquo; deep understanding of their field becomes the structure on which they can hang the huge quantities of information they learn about it&hellip;. It&rsquo;s clear that the superior memory of great performers doesn&rsquo;t just happen. &nbsp;Since it is built on deep understanding of the field, it can be achieved only through years of intensive study.&rdquo; [Geoffrey Colvin]</span></p>
<p class="c0"><span></span></p>
<p class="c2"><span>Professional expertise, then, comes with a price tag, the learning curve must be scaled with effort and with carefully structured practice. The IT field is no exception, but what is particularly odd about IT is that there is so little discussion of the tool set that could be created on a computer to help with the process. </span><span class="c3">What would a tool that assists in the development of a professional skill set look like? </span></p>
<p class="c2"><span class="c3">Some suggestions for inclusion in ProTools</span></p>
<p class="c0"><span class="c3"></span></p>
<ol class="c4" start="1">
<li class="c1"><span>A professional toolkit would presumably include tested and debugged code that could be reused. &nbsp;For example, validation is a necessity for data in any application. &nbsp;The code used to provide validation could be structured to make it easy to include in both the front end and the middle tier. &nbsp;The code could also coordinate validation in the two places through the database. &nbsp;Other examples would include code to handle data passage between the browser and the database. &nbsp;Code that we create for ourselves needs to be located (where are we storing it) and documented.</span></li>
<li class="c1"><span>Tested and debugged code might not be stored in separate files. &nbsp;Smaller pieces of reusable code (snippets) might be kept in a database. &nbsp;The code might be directly drawn from the database for inclusion in applications dynamically. &nbsp;HTML particularly lends itself to this use. &nbsp;The snippets also might be simply stored for cut and paste inclusion into an application.</span></li>
<li class="c1"><span>Code and discussion might also be created simply for the purpose of studying a language. &nbsp;An example might be using callbacks in PHP function parameter lists. &nbsp;Some sample code on what it looks like and some discussion might be included just to help prevent forgetting how it works.</span></li>
<li class="c1"><span>Non code discussion of data processing information that you want to remember could also be included. &nbsp;Discussions and recording of ideas from agile methodology might be an example.</span></li>
<li class="c1"><span>Information tracking coding standards that will be followed in one&rsquo;s professional programming efforts might also be of interest.</span></li>
<li class="c1"><span>URL storage of web sites that have useful programming information would be valuable. &nbsp;The problem with favorite lists on browsers is that they don&rsquo;t follow us as we move about the web. &nbsp;There are some good web sites for sharing URLs with other people on the Web, however, they are standalone applications that do not necessarily integrate well with other stored professional knowledge.</span></li>
<li class="c1"><span>Evaluations of available software tools could also prove useful. &nbsp;The proliferation of high quality frameworks helping solve various application problems is hard to keep up with available solutions.</span></li>
<li class="c1"><span>Since documentation is a professional necessity, the site should support and encourage good documentation habits. &nbsp;The tools should support the creation of automatically generated documentation in web site form. &nbsp;In so far as possible documentation should be driven by information contained within the source code documents creating a software application.</span></li>
<li class="c1"><span>Integration of work is a major concern for IT professionals, and so the site should provide support for the integration of project work. &nbsp;In particular the small tasks derived from the overall project vision and used to create product (overall) and sprint (short interval) backlogs should be published in the database. &nbsp;Who has committed to work on small projects, time estimates, and actual completion information is valuable and needs to be tracked for each project a team or individual undertakes. &nbsp;The tracking allows improvement and agile is focused on continuous improvement.</span></li></ol>
<p class="c0"><span></span></p>
<p class="c2"><span>Expecting every programmer to build a site for their own professional use is unrealistic. &nbsp;It&rsquo;s a problem that takes considerable effort to resolve well. &nbsp;Individuals cannot and do not undertake it lightly. &nbsp;It&rsquo;s a common problem for IT people and consequently it&rsquo;s a problem that should have one or a few generic tools available for long term professional development. &nbsp;A group of IT knowledgeable folks should have better success at solving the problem than an individual would have.</span></p>
<p class="c0"><span></span></p>
<p class="c2"><span>A site supporting professional development would need to provide that support over an extended time period&mdash;careers last for 40 years and beyond. &nbsp;</span></p>
<p class="c0"><span></span></p>
<p class="c2"><span>The site would be driven by open source licensed code</span><span class="c9">.</span><a href="#" id="id.2045d84a008f" name="id.2045d84a008f"></a><span class="c8">&nbsp;</span><span>An</span><span>y professional using it could have access to the code driving the site so as to permit modification and extension. &nbsp;Presumably, many groups might want to create a clone of the site for their specific purposes and to gain control over the long term viability of their particular site.</span></p>
<p class="c0"><span></span></p>
<p class="c2"><span class="c3">Mission Statement</span></p>
<p class="c2"><span>Construct a database driven website which supports the development of professional knowledge in a variety of languages; supports the documentation and integration of the work of software project team members; and increases the long-term productivity of IT professionals. </span></p>
<p class="c0"><span></span></p>
<p class="c0"><span></span></p>
<p class="c0"><span></span></p>
</body>
</html>

