<?php 
  session_start();
  include('../include/dbconfig.php');
?>

<?php
	if(!isset($_SESSION['id'])) {
        header("Location: ./login.php");
    }
    if($_GET['idx']){
        $idx = $_GET['idx'];
        $sql = mq("select * from order_list where idx='$idx';");
        $list= $sql->fetch_array();
?>
    <!DOCTYPE html>
    <html lang="ko">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:title" content="자동견적 서비스" />
        <meta property="og:url" content="" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="" />
        <meta property="og:description" content="자동견적 서비스" />
        <title>자동견적 서비스 관리자 페이지</title>

        <style>
            @import url('https://fonts.googleapis.com/css?family=Noto+Sans');

            * {
                font-family: 'Noto Sans KR', sans-serif;
            }

            p {
                line-height: 1.7em;
            }

            a.anchor {
                color: inherit;
            }

            #container {
                margin: 40px 0 10px 0;
            }

            #header {
                margin-bottom: 50px;
                text-align: left;
            }

            #body {
                margin-bottom: 20px;
                text-align: left;
            }

            #footer {
                margin-top: 100px;
            }

            .dla,
            .dwa {
                background-color: #a6f3a6;
            }

            .dld,
            .dwd {
                background-color: #f8cbcb;
            }

            .steps {
                width: 100%;
            }

            #input {
                margin: 10px;
            }

            #stat {
                margin-left: auto;
                margin-right: auto;
                margin: 0;
                left: 0;
                right: 0;
            }
            .overlay {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.7);
                transition: opacity 500ms;
                visibility: hidden;
                opacity: 0;
            }
            .overlay:target {
                visibility: visible;
                opacity: 1;
            }

            .popup {
                margin: 70px auto;
                padding: 20px;
                background: #fff;
                border-radius: 5px;
                width: 30%;
                position: relative;
                transition: all 5s ease-in-out;
            }

            .popup h2 {
                margin-top: 0;
                color: #333;
                font-family: Tahoma, Arial, sans-serif;
            }
            .popup .close {
                position: absolute;
                top: 20px;
                right: 30px;
                transition: all 200ms;
                font-size: 30px;
                font-weight: bold;
                text-decoration: none;
                color: #333;
            }
            .popup .close:hover {
                color: #000000;
            }
            .popup .content1 {
                max-height: 30%;
                overflow: auto;
            }
        </style>
        <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css'>
    </head>

    <body>
        <div class="ui container" id="container">
            <div class="ui center aligned basic segment" id="header">
                <h1 class="ui icon header" style="text-align: left; margin-top: 50px;">
                    자동견적 서비스 관리자 페이지
                </h1>
                <p>
                    목재 및 기타 소모품을 위한 자동견적 서비스 관리자 페이지입니다.
                </p>
            </div>

            <div class="ui menu" style="margin-bottom:50px;margin-top:-30px;">
                <a class="item" href="/admin/index.php">최근 견적서 확인</a>
                <a class="item" href="/admin/add.php">견적 항목 추가</a>
                <a class="active item">견적 완료</a>
            </div>

            <div class="ui center aligned basic segment" id="body">
                <h2 class="ui left floated header">견적 완료</h2>
                <div class="ui clearing divider"></div>

                <div class="column">
                <div class="ui segment">
                  <div class="ui relaxed padded grid stackable">
                      <div class="row">
                        <div class="column">
                          <h2 class="ui header">
                            <div class="content">
                              견적 완료하기
                            </div>
                          </h2>
                        </div>
                      </div>
                      <div class="ui divider"></div>
                      <div class="row">
                        <div class="column">
                        <form class="ui form" method="post" action="/include/multi.php">
                        <h4 class="ui dividing header"><?php echo $list['idx']?>번 견적을 완료 상태로 전환합니다.</h4>
                          <button class="ui button submit primary" tabindex="0" name="submit" type="submit">완료 처리하기</button>
                          <input type="hidden" name="cmd" value="6">
                          <input type="hidden" name="idx" value="<?php echo $list['idx']?>">
                        </form>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="ui center aligned basic segment" id="footer">
                2018
                <a href="https://github.com/Juneyoung-Kang">Juneyoung KANG</a>
            </div>
        </div>

        <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.js'></script>
        <script src="js/index.js"></script>
    </body>

    </html>
<?php
}else{
echo "<script>alert('잘못된 접근입니다.'); location.href='/admin/index.php'; </script>";
    }
?> 