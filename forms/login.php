<html>
  <head>
    <title>Login</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>

    <link rel="stylesheet" href="../css/bit561.css" type="text/css" />
  </head>
  <body>

    <div id="leftside">
      <img src="../images/leftside.jpg" width="125" height="1275"></img>
    </div>

    <div id="rightside">
      <img src="../images/rightside.jpg" width="125" height="1275"></img>
    </div>

    <div id="topside">
      <h2 align="center" id="pagetitle">Login</h2>
    </div>

    <div id="helpComments">
    </div>

    <div id="bgframe">
      <div id="instructions">
      </div>

      <div id="main">

        <h3>BIT561 -- Cascadia Professional Studies</h3>

        <hr color="black" width="670px" />

        <table>
          <tr>
            <td width="150" valign="center">
              <font size="+1" style="bold">
                <strong id="formTitle">Please Login</strong>
            </font>
          </td>
          </tr>
        </table><br />

        <form method="POST" action="../php/authorize.php">
          Username:<br />
          <input type="text" name="userName" />
          <br /><br />
          Password:<br />
          <input type="password" name="password" />
          <br /><br />
          <input type="submit" id="submit" value="Submit" />
        </form>

      </div>
    </div>
  </body>
</html>
