<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8"/>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
					<!-- Bootstrap -->
					<link href="/public/lib/css/bootstrap.min.css" rel="stylesheet" media="screen">
					<script src="/public/lib/js/jquery-3.1.1.min.js"></script>
					<style>
						body{
							padding-top:60px;
							
						}
						.form_control{
							padding-top:20px;
						}
					</style>
					<link href="/public/lib/css/bootstrap-responsive.css" rel="stylesheet">
					
            </head>
            <body>
            <?php
            	if($this->session->flashdata('message')){
            ?>
            <script>
            	alert('<?=$this->session->flashdata('message')?>');
            </script>
            
            <?php } ?>
				<div class="navbar navbar-fixed-top">
					<div class="navbar-inner">
						<div class="container">
				
							<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
							<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</a>
				
							<!-- Be sure to leave the brand out there if you want it shown -->
							<a class="brand" href="<?=site_url()?>">BASEBALL MINING</a>
				
							<!-- Everything you want hidden at 940px or less, place within here -->
							<div class="nav-collapse collapse">
								<!-- .nav, .navbar-search, .navbar-form, etc -->
								<ul class="nav pull-right">
									<?php if($this->session->userdata('is_login')){ ?>
										<li><a href="/user/logout">로그아웃</a></li>
										<li><a href="#"><?=$this->session->userdata('nickname')?> 님</a></li>
										<li><a href="/user/register">회원가입</a></li>
									<?php } ?>
								</ul>
							</div>
				
						</div>
					</div>
				</div>
            	<div class="container">
					<div class="row-fluid">