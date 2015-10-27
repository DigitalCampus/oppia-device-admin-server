<!DOCTYPE html>
<html>

  <head>
    <title>OppiaMobile - Remote Device Administration</title>

    <!-- Mobile support -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Twitter Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design for Bootstrap -->
    <link href="css/roboto.min.css" rel="stylesheet">
    <link href="css/material-fullpalette.css" rel="stylesheet">
    <link href="css/ripples.min.css" rel="stylesheet">

    <!-- Dropdown.js -->
    <link href="//cdn.rawgit.com/FezVrasta/dropdown.js/master/jquery.dropdown.css" rel="stylesheet">

    <!-- Page style -->
   <style>
      * {
        box-sizing: border-box;
      }
      .header-panel {
        background-color: #74B042;
        height: 160px;
        position: relative;
        z-index: 3;
      }
      .header-panel div {
        position: relative;
        height: 100%;
      }
      .header-panel hgroup {
        color: #FFF;
        font-size: 20px;
        font-weight: 400;
        position: absolute;
        bottom: 15px;
        padding-left: 35px;
      }
      .header-panel h1, h2{ margin: 0; }
      .header-panel h2{ font-size: 19px; color:#DDD;padding-left:5px;}
      .header-panel .logo{ position: absolute; bottom:0; right: 8%; width:180px; z-index: -10;}
      body{
        margin: 0;
      }
      .btn-actions{
        position: absolute;
        bottom: 0;
        right: 10px;
      }
      .action-icon{
        
        text-align: right;
        color: #AAA;
      }
      .action-icon [class^="mdi-"], [class*="mdi-"]{
        font-size: 48px;
      }
      .message-success{
        color:#74B042;
        font-size: 1.1em;
        vertical-align: middle;
        line-height: 45px;
      }
      .message-success i{ vertical-align: middle;}
      </style>


    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

  </head>
  <body>
    <div class="header-panel">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12">
            <hgroup>
              <h1>OppiaMobile</h1>
              <h2>Remote Device Administration</h2>
            </hgroup>
          </div>
        </div>
        <img class="logo" src="img/oppia-material.png">
      </div>
    </div>
    <br/>
    <div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            



            <div class="list-group">
                
              <?php
                require_once('db/oppia_db.php');
                $result = $db->query('SELECT * FROM devices') or die('Query failed');
                foreach($result as $row)
                {
              ?>

                <div class="list-group-item" data-device="<?php echo $row['sender_id']; ?>" >
                  <div class="row-action-primary">
                      <i class="mdi-hardware-phone-android"></i>
                  </div>
                  <div class="row-content">
                      <div class="least-content"></div>
                      <h4 class="list-group-item-heading"><?php echo $row['model_name']; ?></h4>
                      <p class="list-group-item-text">Registered: <em><?php echo $row['registered']; ?></em> by <strong><?php echo $row['username']; ?></strong><br/>
                      <strong>senderID: </strong><?php echo substr($row['sender_id'], 0, 20); ?>...</p>
                      <a class="btn btn-primary btn-raised btn-actions">ADMIN</a>
                  </div>
              </div>
              <div class="list-group-separator"></div>
              <?php  } 
              $db = NULL;


              ?>
            
          </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="loadingModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
              Sending Push message...
              <div class="message-success"><i class="mdi-action-done-all"></i> Message sent. </div>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="adminModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Admin device</h3>
            <h5 id="modelName"></h5>
            <input type="hidden" id="senderID">
          </div>
          <div class="modal-body">
            

            <div class="row">
              <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 action-icon"><i class="mdi-av-videocam-off"></i></div>
                    
                      <div class="col-md-7 col-sm-7 col-xs-10">
                      <h4>Disable camera</h4>
                      Send a message to the device to disable all the device cameras.<br/>
                      
                      </div>
                      <div class="text-right col-md-3 col-sm-3"><br/><a class="btn btn-primary btn-raised" data-admin-btn data-action="disable_camera">SEND</a></div>
              </div>
            </div>

            <hr class="hidden-xs"/>

            <div class="row">
              <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 action-icon"><i class="mdi-av-videocam"></i></div>
                    
                      <div class="col-md-7 col-sm-7 col-xs-10">
                      <h4>Enable camera</h4>
                      Send a message to the device to enable again all the device cameras (to undo the prior action).<br/>
                      
                      </div>
                      <div class="text-right col-md-3 col-sm-3"><br/><a class="btn btn-primary btn-raised" data-admin-btn data-action="enable_camera">SEND</a></div>
              </div>
            </div>
            <hr class="hidden-xs" />

            <div class="row">
              <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-2 action-icon"><i class="mdi-action-lock"></i></div>
                    
                      <div class="col-md-8 col-sm-9 col-xs-10">
                      <h4>Lock device</h4>
                      Send a message to the device to lock its screen and set a new password.
                      </div>
                      <div class="col-md-7 col-sm-7 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-1">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password"></div>
                      <div class="col-md-3 col-sm-3 col-xs-3 text-right"><a class="btn btn-primary btn-raised" data-admin-btn data-action="password_lock">SEND</a></div>
              </div>
            </div>            

            <br/><br/>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Twitter Bootstrap -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Material Design for Bootstrap -->
    <script src="js/material.min.js"></script>
    <script src="js/ripples.min.js"></script>
    <script>
      $.material.init();
    </script>

    <script src="js/jquery.nouislider.min.js"></script>
    <script src="js/jquery.dropdown.js"></script>
    <script>
      var adminModal = $('#adminModal');
      var loadingModal = $('#loadingModal');
      var modelNameLabel = adminModal.find('#modelName');
      var passwordInput = adminModal.find('#inputPassword');
      var senderID;

      adminModal.find('[data-admin-btn]').on('click', function(){
          var data = { sender_id:senderID, action: $(this).attr('data-action') };
          if (data.action == "password_lock"){
            data.password = passwordInput.val();
            if (data.password == "") return;
          }
          adminModal.modal('hide');
          loadingModal.find('.message-success').hide().end().modal('show');
          $.post('send_message.php', data, function(){
            loadingModal.find('.message-success').fadeIn();
          });
      });

      $('.btn-actions').on('click', function(){ 
        var modelName = $(this).siblings('.list-group-item-heading').text();
        senderID = $(this).parents('.list-group-item').attr('data-device');
        modelNameLabel.html(modelName);
        passwordInput.val("");
        adminModal.modal('show'); 
      });
    </script>

  </body>
</html>
