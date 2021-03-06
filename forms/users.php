<?php
/*
session_start();

if ($_SESSION['loggedIn'] != true)
  header('location:../forms/login.php');
*/
?>

<html>
  <head>
    <title>Users</title>

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
      <h2 align="center" id="pagetitle">Users</h2>
    </div>

    <div id="helpComments">
    </div>

    <div id="bgframe">
      <div id="instructions">
      </div>

      <div id="main">

        <h3>BIT561 -- Cascadia Professional Studies</h3>

        <hr color="black" width="670px" />

        <table><tr><td width="150" valign="center"><font size="+1" style="bold">
                <strong id="formTitle">Users</strong></font></td>
          </tr>
        </table><br />


        <select id="userselect" class="wideSelect">
          <option value="No User Selected">No User Selected</option>
        </select>
        <br /><br />
        <form id="userscontrol" class="dataControl">
          <img src="../images/prevArrow.jpg" 
            title="Look at the previous user in the dropdown list." />
          <img src="../images/SaveData.jpg" 
            title="Save the current user information." />
          <img src="../images/NewData.jpg" 
            title="Blank the form to create a new user." />
          <img src="../images/DeleteData.jpg" 
            title="Remove the current user from the database." />
          <img src="../images/ExitData.jpg" title="Exit the user form." />
          <img src="../images/nextArrow.jpg" 
            title="Look at the next user in the dropdown list." />
          <input type="hidden" class="formdata dirtyFlag" value="false" />
        </form>
        <form name="users" id="users">
          <fieldset id="object_ID" class="required">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="fields">object_ID:</td>
              </tr>
              <tr>
                <td>
                  <input disabled="disabled" class="formdata object_ID"
                    size="84" value="" />
                </td>
              </tr>
              <tr>
                <td class="undertitle"></td>
              </tr>
            </table>
          </fieldset>
          <fieldset id="userName" class="required">
            <table border="0" cellspacing="9" cellpadding="0">
              <tr>
                <td class="fields">User Name
                  <span class="asterisk">&nbsp;*</span></td>
              </tr>
              <tr>
                <td>
                  <input type="text" class="formdata userName" size="84"
                    value="" />
                </td>
              </tr>
              <tr>
                <td class="undertitle">Enter desired username</td>
              </tr>
            </table>
          </fieldset>

          <fieldset id="firstName" class="required">
            <table border="0" cellspacing="9" cellpadding="0">
              <tr>
                <td class="fields">First Name
                  <span class="asterisk">&nbsp;*</span></td>
              </tr>
              <tr>
                <td>
                  <input type="text" class="formdata firstName" size="84"
                    value="" />
                </td>
              </tr>
              <tr>
                <td class="undertitle">Enter your given name</td>
              </tr>
            </table>
          </fieldset>

          <fieldset id="lastName" class="required">
            <table border="0" cellspacing="9" cellpadding="0">
              <tr>
                <td class="fields">Last Name
                  <span class="asterisk">&nbsp;*</span></td>
              </tr>
              <tr>
                <td>
                  <input type="text" class="formdata lastName" size="84"
                    value="" />
                </td>
              </tr>
              <tr>
                <td class="undertitle">Enter your surname</td>
              </tr>
            </table>
          </fieldset>

          <fieldset id="email" class="required">
            <table border="0" cellspacing="9" cellpadding="0">
              <tr>
                <td class="fields">Email
                  <span class="asterisk">&nbsp;*</span></td>
              </tr>
              <tr>
                <td>
                  <input type="text" class="formdata email" size="84" 
                    value="" />
                </td>
              </tr>
              <tr>
                <td class="undertitle">Enter a valid email address</td>
              </tr>
            </table>
          </fieldset>

          <fieldset id="password" class="required">
            <table border="0" cellspacing="9" cellpadding="0">
              <tr>
                <td class="fields">Password
                  <span class="asterisk">&nbsp;*</span></td>
              </tr>
              <tr>
                <td>
                  <input type="password" class="formdata password"
                    size="84" value="" />
                </td>
              </tr>
              <tr>
                <td class="undertitle">Enter your desired password</td>
              </tr>
            </table>
          </fieldset>

        </form>
      </div>
    </div>

    <script src="../tools/request.js" type="text/javascript"></script>
    <script src="../tools/utilities.js" type="text/javascript"></script>
    <script src="../javascript/tools/getElements/getElements.js" 
      type="text/javascript"></script>
    <script src="../base/structure.js" type="text/javascript"></script>
    <script src="../base/carousel.js" type="text/javascript"></script>
    <script src="../base/formhandler.js" type="text/javascript"></script>
    <script src="../base/view.js" type="text/javascript"></script>
    <script src="../base/validator.js" type="text/javascript"></script>
    <script src="../controls/usersControl.js" type="text/javascript">
    </script>

    <script>

      $U.setUpUsers();

    </script>
  </body>
</html>
