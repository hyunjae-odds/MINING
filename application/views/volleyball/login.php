<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset-utf-8"/>	
	<title> ODDS CONNECT - DataMining </title>
	<link href="/public/lib/volley.css" rel="stylesheet" type="text/css">
	<script src="/public/lib/js/jquery-1.12.4.js"></script>

	<script type="text/javascript">
		$(function(){
			$("a").attr("onfocus","this.blur();")
            document.getElementsByName('sex').value='M';
		});

		$(document).ready(function(){
			//남자부여자부
			$(".Gbox ul li").click(function(){ 
				$(this).siblings().removeClass("on");
				$(this).addClass("on");

                $('#sex').val($('.on').attr('id'));
			});

			//login input
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
			<h1><img src="/public/lib/volleyball_image/logo.jpg"><img src="/public/lib/volleyball_image/logo_span.jpg"></h1>
			<div class="Gbox">
				<form action="/user/authentication/volleyball" method="post">
					<fieldset>
						<legend>로그인</legend>
						<ul>
							<li class="on" id="M">남자부 경기</li>
							<li id="W">여자부 경기</li>
						</ul>
						<input type="text" id="userID" name="userID">
						<input type="password" id="userPW" name="userPW">
                        <input type="hidden" id="sex" name="sex" value="">
						<input type="submit" value="입력하기">
					</fieldset>
				</form>
			</div>
<!--			<p>현재 접속자 수 : 3</p>-->
<!--			<p><b>NEXT MATCH : 18:30</b></p>-->
		</div>
	</div>
</body>
</html>