<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <meta name="description" content=""> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <title>Notifier</title>
  <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="icon" sizes="192x192" href="images/android-desktop.png">

  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Material Design Lite">
  <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

  <!-- Tile icon for Win8 (144x144 + tile color) -->
  <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
  <meta name="msapplication-TileColor" content="#3372DF">

  <link rel="shortcut icon" href="images/favicon.png">
  <link rel="stylesheet" href="./material.min.css">
  <style>
    body {
      height: 100vh;
      width: 100vw;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    /*ORGANIZATION SIGNUP*/

    .organization-signup-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .organization-signup-container .signup-submit {
      margin-bottom: 20px;
    }

    .organization-signup-container .login-submit,
    .organization-signup-container .signup-submit {
      text-align: right;
      padding-right: 50px;
    }

    .organization-signup-container .demo-card-square.mdl-card {
      width: 400px;
    }

    .organization-signup-container form {
      text-align: center;
    }

    .organization-signup-container .mdl-card__supporting-text {
      width: auto;
    }

    .organization-signup-container .mdl-card__title {
      justify-content: center;
    }

    .organization-signup-container .back-button {
      position: absolute;
      top: 0;
      left: 0;
    }

    .organization-signup-container .arrow-back,
    .organization-signup-container .back-to-login {
      cursor: pointer;
    }

    .organization-signup-container .mdl-card__title-text {
      margin: auto;
      justify-content: center;
      position: relative;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="organization-signup-container">
    <div class="demo-card-square mdl-card mdl-shadow--4dp">
      <div class="mdl-card__title mdl-card--expand">
        <h4 class="mdl-card__title-text">
          <div class="back-button">
            <a class="arrow-back" href='/personal.html'><i class="material-icons">arrow_back</i></a>
          </div>
          Notifier - Org Sign Up
        </h4>
      </div>
      <div class="mdl-card__supporting-text">
        <form action="#">
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="org-name">
            <label class="mdl-textfield__label" for="org-name">Organization Name</label> <span class="mdl-textfield__error">Invalid Name</span>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="org-notifier-id">
            <label class="mdl-textfield__label" for="org-notifier-id">New Organization Username</label>
            <span class="mdl-textfield__error">Invalid Username</span>
          </div>
        </form>
      </div>
      <div class="signup-submit">
        <a class="signup-submit-btn mdl-button mdl-button--colored mdl-js-button mdl-button--raised mdl-js-ripple-effect">Sign Up</a>
      </div>
    </div>
  </div>
  <script src="./material.min.js"></script>
  <script src="./jquery.min.js"></script>
  <script type="text/javascript">
    var $orgSignup = $('.organization-signup-container');
    $orgSignup.find('.signup-submit-btn').on('click', function (e) {
      e.preventDefault();
      var $orgName = $orgSignup.find('#org-name');
      var $orgNotifierid = $orgSignup.find('#org-notifier-id');
      var orgName = $orgName.val();
      var orgNotifierid = $orgNotifierid.val();
      // console.log(orgName, orgUsername);

      $.ajax({
        type: 'POST',
        data: {
          'org-name': orgName,
          'org-notifier-id': orgNotifierid
        },
        url: '/server/org_signup.php'
      }).done(function(data) {
        if($.trim(data) === '1') {
          alert('Organisation account created successfully.');
          location.href = './personal.html';
        } else if($.trim(data) === '0'){
          alert('Please login first.');
          location.href = './index.html';
        } else {
          // console.log(data);
          try {
            data = JSON.parse(data);
            for (var item in data) {
              var $errorInput = $('#' + item);
              var $errorInputContainer = $errorInput.parent();
              //visually indicate error
              $errorInputContainer.addClass('is-invalid');
              //add error msg to error span
              $errorInput.siblings('span').html(data[item]);
            }
          } catch (e) {
            console.log(e);
          }
        }

      }).fail(function(event, jqxhr, settings, thrownError) {
        console.log(event + jqxhr.status + settings + thrownError);
      });
    })
  </script>
</body>

</html>
