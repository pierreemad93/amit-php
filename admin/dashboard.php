<?php
session_start();
include "includes/connect.inc";
include  "includes/function.inc";
include  "includes/header.inc";
include  "includes/nav.inc";
?>
<div class="dashboard">
    <div class="container">
        <h1 class="text-center">Dashboard</h1>
        <div class="row">
            <div class="col-lg-4 member">
                <div class="row">
                    <div class="col-lg-6">
                        <span><?php echo countItem('id' ,'users')?></span>
                    </div>
                    <div class="col-lg-6">
                        <i class="fa fa-users fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include  "includes/footer.inc"?>
