<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
<title> ODDS CONNECT - DataMining </title>
<link href="/public/lib/base.css" rel="stylesheet" type="text/css">
<script src="/public/lib/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("a").attr("onfocus","this.blur();")
	});

	$(document).ready(function(){
		$("#userID").click(function(){ 
			var state = $(".Gbox").css("display"); 
			if(state == "none"){ 
				$("#userID").removeClass("on");
			}else{
				$("#userID").addClass("on");
			}
		});
		$("#userPW").click(function(){ 
			var state = $(".Gbox").css("display"); 
			if(state == "none"){ 
				$("#userPW").removeClass("on");
			}else{
				$("#userPW").addClass("on");
			}
		});
	});
</script>
</head>

<body>
	<div class="wrap login">
		<div class="login_w">
			<h1><img src="/public/lib/image/logo.jpg" alt="" /><img src="/public/lib/image/logo_span.jpg" alt="" /></h1>
			<div class="Gbox">
				<?php if($this->session->flashdata('message')){ ?>
					<script>alert('<?=$this->session->flashdata('message')?>');</script>
				<?php } ?>
				<form class="form-horizontal" action="/user/authentication/baseball" method="post">
					<fieldset>
						<legend>로그인</legend>
						<input type="text" id="userID" name="userID" />
						<input type="password" id="userPW" name="userPW" />
						<input type="submit" value="입력하기" />
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
