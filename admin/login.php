<?php 
  session_start();
  include('../include/dbconfig.php');
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

            <div class="ui center aligned basic segment" id="body">
                <h2 class="ui left floated header">관리자 로그인</h2>
                <div class="ui clearing divider"></div>
                <div class="ui segment">
                    <div class="ui relaxed divided padded full grid">
                        <div class="row">
                            <div class="column">
                                <h1 class="ui header">
                                    <div class="content">
                                        로그인
                                    </div>
                                </h1>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="row">
                            <div class="wide column">
                                <form class="ui form" action="../include/multi.php" method="post">
                                    <div class="field">
                                        <div class="ui left icon input">
                                            <i class="user icon"></i>
                                            <input name="id" placeholder="아이디(유저이름) | ID(Username)" type="text" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui left icon input">
                                            <i class="lock icon"></i>
                                            <input name="pw" placeholder="비밀번호 | Password" type="password" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="cmd" value="1">
                                    <button type="submit" name="submit" class="ui fluid large teal submit button">
                                        로그인
                                    </button>
                                </form>
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