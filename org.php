<!DOCTYPE html>
<html lang="en">
  <?php
    if (!isset($_COOKIE['org_notifier_id'])) {
        echo "<script>alert('Please login first');";
        echo "location.href = './index.html';</script>";
    }
  ?>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

  </head>

  <body>
    <div class="org-app-container">
      <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">
        <header class="mdl-layout__header">
        </header>
        <div class="mdl-layout__drawer">
          <span class="mdl-layout-title">Notifier</span>
          <nav class="mdl-navigation">
            <a class="mdl-navigation__link compose-btn">Compose</a>
            <a class="link-sent mdl-navigation__link ">Sent</a>
            <a class="link-groups mdl-navigation__link ">Groups</a>
            <!-- <a class="link-authorized mdl-navigation__link ">Authorized Users</a> -->
             <?php
             $root_dir = $_SERVER['DOCUMENT_ROOT'];
             session_start();
             $org_notifier_id = $_COOKIE['org_notifier_id'];
             $notifier_id = $_SESSION['notifier_id'];
             include $root_dir.'/server/database_functions/org_profile.php';
             if (is_admin_access($org_notifier_id, $notifier_id)) {
                 echo '  <a class="link-authorized mdl-navigation__link ">Authorized Users</a>';
             }
            ?>
            <a class="logout-btn mdl-navigation__link">Logout</a>
          </nav>
        </div>
        <main class="mdl-layout__content">
          <div class="page-content">
            <div class="compose-container-dialog">
              <dialog id="compose-box-dialog" class="mdl-dialog compose-box">

                <h1 class="mdl-dialog__title compose-box-title">Compose</h1>
                <div class="compose-error">Please add Recipients</div>
                <div class="mdl-dialog__content" id="dialog-content">
                  <!-- Floating Multiline Textfield -->
                  <div class="mdl-list">
                    <span class="mdl-list__item select-recipients" id="select-recipients">
                      <a class="mdl-button mdl-js-button mdl-button--primary select-recipient">
                        Select Recipients
                      </a>
                    </span>
                    <ul class="mdl-list recipients-list" id="accordion-recipient-list">
                    </ul>


                  </div>

                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label subject">
                    <textarea class="mdl-textfield__input" type="text" rows="2" id="subject"></textarea>
                    <label class="mdl-textfield__label" for="subject">Subject</label>
                  </div>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label message">
                    <textarea class="mdl-textfield__input" type="text" rows="6" id="message"></textarea>
                    <label class="mdl-textfield__label" for="message">Message</label>
                  </div>

                  <span class="mdl-dialog__actions">
                    <button type="button" class="mdl-button close" id="close">Close</button>
                    <!-- Accent-colored raised button with ripple -->
                    <button class="btn-send mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                      Send
                    </button>
                  </span>
                </div>
                <div class="spinner">
                  <!-- <img src="assets/spinner.gif" alt="Loading..." height="50" width="50"> -->
                </div>
              </dialog>

            </div>
            <div class="message-overlay-container">
            </div>
            <div class="group-overlay-container">
              <div class="mdl-list members">

              </div>
              <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary back-btn">
                Back
              </button>
            </div>
            <div class="sent-container">
              <ul class="mdl-list message-list"></ul>
            </div>
            <div class="groups-container">
              <button class="mdl-button mdl-button--raised mdl-js-button mdl-js-ripple-effect mdl-button--accent create-group-btn">
                Create Group
              </button>

              <!-- <ul class="groups mdl-list" id="accordion-org-groups">
                <li class="mdl-list__item">group item</li>
              </ul> -->
              <ul class="mdl-list groups-list"></ul>
              <dialog id="create-group-dialog" class="mdl-dialog create-group">

                <h1 class="mdl-dialog__title compose-box-title">Create Group</h1>
                <div class="spinner-wrapper">
                  <div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active"></div>
                </div>
                <div class="mdl-dialog__content" id="dialog-content">
                  <!-- Floating Multiline Textfield -->
                  <div class="error"></div>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="create-group-input">
                    <label class="mdl-textfield__label" for="create-group-input">Group Name</label>
                  </div>
                  <span class="mdl-dialog__actions">
                    <button type="button" class="mdl-button close" id="close">Close</button>
                    <!-- Accent-colored raised button with ripple -->
                    <button class="create-group-btn mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                      Create
                    </button>
                  </span>

                </div>
              </dialog>

            </div>
            <div class="authorized-container">
              <button class="mdl-button mdl-button--raised mdl-js-button mdl-js-ripple-effect mdl-button--accent authorize-user-btn">
                Add
              </button>
              <ul class="mdl-list auth-list">
              </ul>
              <dialog id="authorize-user-dialog" class="mdl-dialog authorize-user">

                <h1 class="mdl-dialog__title compose-box-title">
                  Share this link
                </h1>
                <div class="mdl-dialog__content" id="dialog-content">
                  <!-- Floating Multiline Textfield -->
                  <div class="error"></div>
                  <div class="auth-link">
                    Link: <span class="link"></span>
                  </div>
                  <span class="mdl-dialog__actions">
                    <button type="button" class="mdl-button close" id="close">Close</button>
                    <button class="update-link-btn mdl-button mdl-js-button mdl-js-ripple-effect">
                      Update Link
                    </button>
                  </span>

                </div>
              </dialog>
            </div>
            <div>
              <script type="text/javascript">
                function dialogs(buttonElementSelector, dialogElementSelector) {
                  'use strict';
                  var dialogButton = document.querySelector(buttonElementSelector);

                  var dialog = document.querySelector(dialogElementSelector);
                  if (!dialog.showModal) {
                    dialogPolyfill.registerDialog(dialog);
                  }
                  dialogButton.addEventListener('click', function() {
                    dialog.showModal();
                  });
                  dialog.querySelector("button.close")
                    .addEventListener('click', function() {
                      dialog.close();
                    });
                };
                dialogs('.compose-btn', '#compose-box-dialog');
                dialogs('.authorize-user-btn', '#authorize-user-dialog');
                dialogs('.create-group-btn', '#create-group-dialog');
              </script>
            </div>
          </div>
        </main>
    </div>
    </div>

    <script src="./material.min.js" charset="utf-8"></script>
    <script src="./org.js" charset="utf-8"></script>
  </body>

</html>
