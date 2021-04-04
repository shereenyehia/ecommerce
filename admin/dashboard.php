<?php session_start()?>
<!--
    this is if check if admin use admin login or not
-->
<?php if(isset($_SESSION['USER_NAME'])):?>
   <!--Start Dashboard page-->
    <?php include "resources/includes/header.inc"?>
    <?php require "config.php"?>
    <?php include "resources/includes/navbar.inc"?>
    <!-- Start Dashboard -->
    <div class="container">
      <div class="row">
        <div class="colg-lg-4">
            <div class="members">
              <i class="fas fa-users"></i>
              <?php echo countItem("user_id" , "users")?>
        </div>
      </div>
    </div>
  </div>
<!-- Dashboard -->
    <?php include "resources/includes/footer.inc"?>
    <!--End Dashboard page-->
<?php else:?>
<?php header("location:index.php")?>
<?php endif?>
