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
            .popup .content {
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
                            <form method="post" action="/include/multi.php">
                            <table class="ui table">
                                <thead>
                                    <tr>
                                        <th>견적번호</th>
                                        <th>제품명</th>
                                        <th>가로X세로X수량</th>
                                        <th>가격</th>
                                        <th></th>
                                        <th></th>
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
                                        <td><?php echo $list["idx"];?></td>
                                        <td><?php echo $list["product"];?></td>
                                        <td><?php echo $list["width"].'x'.$list["length"].'x'.$list["quantity"];?></td>
                                        <td><?php echo $list["product"];?></td>
                                        <td>
                                            <a href="#popup<?php echo $list["idx"];?>">상세보기</a>
                                        </td>
                                        <td>
                                            <a href="javascript:printIt(document.getElementById('printme').innerHTML)">인쇄</a>
                                        </td>
                                        <td>
                                            <a href="edit_order.php?idx=<?php echo $list["idx"];?>">상태 수정</a>
                                        </td>
                                        <td>
                                            <?php if($list["done_chk"]==Y){echo('<a class="ui blue label">완료</a>');}else{echo('<a class="ui red label">미완료</a>');}?>
                                        </td>
                                    </tr>
                                    <div id="popup<?php echo $list["idx"];?>" class="overlay">
                                        <div class="popup" id="printme">
                                            <h2>견적번호 : <?php echo $list["idx"];?>번</h2>
                                            <a class="close" href="#">&times;</a>
                                            <div class="content">
                                                <div class "ui divider"></div>
                                                <h5>주문자명 : <?php echo $list["name"];?></h5>
                                                <h5>연락처 : <?php echo $list["contact"];?></h5>
                                                <h5>이메일 : <?php echo $list["email"];?></h5>
                                                <hr>
                                                <h5>주문상품 : <?php echo $list["product"];?></h5>
                                                <h5>주문량 : <?php echo $list["width"].'x'.$list["length"].'x'.$list["quantity"];?></h5>
                                                <h5>주문일시 : <?php echo $list["log"];?></h5>
                                                <hr>
                                                <h5>기타 요구사항 : <?php echo $list["other"];?></h5>
                                            </div>
                                        </div>
                                    </div> 
                                    <?php } ?>
                                </tbody>
                            </table>
                        </form>
                        </div>
                    </div>
                </div>
            </div>                           
            <div class="ui center aligned basic segment" id="footer">
                2018
                <a href="https://github.com/Juneyoung-Kang">Juneyoung KANG</a>
            </div>
        </div>

        <script type="text/javascript">
            var win=null;
            function printIt(printThis)  {
                win = window.open();
                self.focus();
                win.document.open();
                win.document.write('<'+'html'+'><'+'head'+'><'+'style'+'>');
                win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
                win.document.write('<'+'/'+'style'+'><'+'/'+'head'+'><'+'body'+'>');
                win.document.write(printThis);
                win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
                win.document.close();
                win.print();
                win.close();
            }
        </script>

        <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.js'></script>
        <script src="../js/index.js"></script>
    </body>

</html>