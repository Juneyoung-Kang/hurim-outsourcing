<?php 
  session_start();
  include('./include/dbconfig.php');
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:title" content="자동견적 서비스"/>
  <meta property="og:url" content=""/>
  <meta property="og:type" content="website"/>
  <meta property="og:image" content=""/>
  <meta property="og:description" content="자동견적 서비스"/>
  <title>자동견적 서비스</title>

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
        자동견적 서비스
      </h1>
      <p>
        목재 및 기타 소모품을 위한 자동견적 서비스입니다.
      </p>
    </div>

    <div class="ui center aligned basic segment" id="body">
      <h2 class="ui left floated header">견적 입력하기</h2>
      <div class="ui clearing divider"></div>
      <p>
        <strong>추가하기를 누르면 견적에 자동으로 포함됩니다. 포함된 견적은 항목별로 삭제할 수 있습니다. <br>상품별로 입력가능한 크기나 수량에 제한이 있을 수 있습니다.</strong>
      </p>
      <form method="post" action="/include/multi.php">
        <div class="ui selection dropdown" id="input">
          <input type="hidden" name="product" required>
          <i class="dropdown icon"></i>
          <div class="default text">목재 종류 및 두께</div>
          <div class="menu">
          <?php
            $sql = mq("select * from product_list order by idx asc");  
            while($list = $sql->fetch_array()){
          ?>
            <div class="item" data-value="<?php echo $list["value"];?>"><?php echo $list["name"];?></div>
          <?php } ?>
          </div>
        </div>
        <div class="ui divider"></div>
            <div class="ui labeled input" style="margin: 10px;">
              <div class="ui label">가로</div>
              <input type="number" placeholder="단위: mm" required name="width">
            </div>
            <div class="ui labeled input" style="margin: 10px;">
              <div class="ui label">세로</div>
              <input type="text" placeholder="단위: mm" required name="length">
            </div>
            <div class="ui labeled input" style="margin: 10px;">
              <div class="ui label">수량</div>
              <input type="text" placeholder="EA" required name="quantity">
            </div>
            <button class="ui primary submit button" name="submit" type="submit">
              추가하기
            </button>
            <input type="hidden" name="cmd" value="2">
        </div>
      </form>
      <div class="ui clearing divider"></div>
      <div class="ui two column grid stackable">
      <div class="column">
        <div class="ui segment">
          <div class="ui relaxed padded grid">
              <div class="row">
                <div class="column">
                  <h2 class="ui header">
                    <div class="content">
                      견적(주문) 목록
                    </div>
                  </h2>
                </div>
              </div>
              <div class="ui divider"></div>
              <div class="row">
                <div class="column">
                <form class="ui form" method="post" action="/include/multi.php">
                  <table class="ui table">
                    <thead>
                      <tr>
                      <th>제품명</th>
                      <th>가로X세로X수량</th>
                      <th>가격</th>
                    </tr></thead>
                    <tbody>
                    <?php
                      $session = session_id();
                      $sql2 = mq("select * from order_session where session_id = '$session'");  
                      while($result = $sql2->fetch_array()){
                    ?>
                      <tr>
                      <td>
                        <?php
                        echo $result["product"];
                        ?>
                        </td>
                        <td>
                        <?php echo $result["width"].'x'.$result["length"].'x'.$result["quantity"];?>
                        </td>
                        <td>
                        <?php echo $result["product"];?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <input type="hidden" name="cmd" value="0">
                  <button class="ui button submit primary" type="submit" name="submit">처음부터 다시 작성</button>
                  </form>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="ui segment">
          <div class="ui relaxed padded grid stackable">
              <div class="row">
                <div class="column">
                  <h2 class="ui header">
                    <div class="content">
                      주문서 작성
                    </div>
                    <div class="content" style="float:right; color:red; font-size:20px;">
                      합계 : 원
                    </div>
                  </h2>
                </div>
              </div>
              <div class="ui divider"></div>
              <div class="row">
                <div class="column">
                <form class="ui form" method="post" action="/include/multi.php">
                <h4 class="ui dividing header">주문자 정보</h4>
                  <div class="field">
                    <label>주문자</label>
                    <div class="two fields">
                      <div class="field">
                        <input type="text" name="name" placeholder="주문자명">
                      </div>
                      <div class="field">
                        <input type="text" name="contact" placeholder="연락처">
                      </div>
                    </div>
                      <div class="field">
                        <input type="email" name="email" placeholder="이메일">
                      </div>
                  </div>
                  <h4 class="ui dividing header">기타 요구사항</h4>
                  <div class="field">
                      <div class="field">
                        <textarea type="text" name="other" placeholder="기타 요구사항"></textarea>
                      </div>
                  </div>
                  <button class="ui button submit primary" type="submit" name="submit">견적서 제출하기</button>
                  <input type="hidden" name="cmd" value="3">
                </form>
                </div>
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