<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src="/public/lib/js/jquery-3.1.1.min.js"></script>
    <style>
        body {
            padding-top:60px;
            padding-left:45%;
        }
    </style>
</head>

<body>
    <h3>마이닝 오퍼레이터 등록</h3>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="nav-collapse collapse">
                    <ul class="nav pull-right">
                        <?php if($this->session->userdata('is_login')){ ?>
                            <li><a href="/user/logout">로그아웃</a></li>
                            <li><a href="#"><?=$this->session->userdata('nickname')?> 님</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div><br>
    <div class="container">
        <div class="row-fluid">
            <div>
              <div class="span4"></div>
              <div class="span4">
              <?php echo validation_errors(); ?>
                <form class="form-horizontal" action="./register" method="post">
                  <div class="control-group">
                    <label class="control-label" for="inputEmail">이메일</label>
                    <div class="controls">
                      <input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="이메일">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="nickname">닉네임</label>
                    <div class="controls">
                      <input type="text" id="nickname" name="nickname" value="<?php echo set_value('nickname'); ?>" placeholder="닉네임">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="password">비밀번호</label>
                    <div class="controls">
                      <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>"  placeholder="비밀번호">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="re_password">비밀번호 확인</label>
                    <div class="controls">
                      <input type="password" id="re_password" name="re_password" value="<?php echo set_value('re_password'); ?>"  placeholder="비밀번호 확인">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                      <input type="submit" class="btn btn-primary" value="회원가입" />
                    </div>
                  </div>
                </form>
              </div>
              <div class="span4"></div>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script><?php if($this->session->flashdata('message')){ ?>alert('<?=$this->session->flashdata('message')?>');<?php } ?></script>
</body>
</html>