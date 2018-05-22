<?php 
  session_start();
  include('../include/dbconfig.php');
?>

<?php
	if(!isset($_SESSION['id'])) {
    header("Location: ./login.php");
  }
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

            <div class="ui menu" style="margin-bottom:50px;margin-top:-30px;">
                <a class="active item">최근 견적서 확인</a>
                <a class="item" href="/admin/add.php">견적 항목 추가</a>
            </div>

            <div class="ui center aligned basic segment" id="body">
                <h2 class="ui left floated header">최근 견적서 확인</h2>
                <div class="ui clearing divider"></div>
                <p>
                    <strong>최근 견적서를 확인할 수 있습니다.</strong>
                </p>

                <div class="column">
                    <div class="row">
                        <div class="column">
                            <table class="ui table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>견적번호</th>
                                        <th>제품명</th>
                                        <th>가로X세로X수량</th>
                                        <th>가격</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = mq("select * from order_list order by idx desc");  
                                    while($list = $sql->fetch_array()){
                                ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" tabindex="0">
                                        </td>
                                        <td><?php echo $list["idx"];?></td>
                                        <td><?php echo $list["product"];?></td>
                                        <td><?php echo $list["width"].'x'.$list["length"].'x'.$list["quantity"];?></td>
                                        <td><?php echo $list["product"];?></td>
                                        <td>
                                            <a herf="#">상세보기</a>
                                        </td>
                                        <td>
                                            <a herf="#">인쇄</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button class="ui primary button" style="margin-top:15px;">
                    완료된 견적으로 처리
                </button>
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