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
                <a class="active item">견적 항목 추가</a>
            </div>

            <div class="ui center aligned basic segment" id="body">
                <h2 class="ui left floated header">견적 항목 추가</h2>
                <div class="ui clearing divider"></div>

                <h3 class="ui left floated header">현재 상품 목록</h3>
                <div class="ui clearing divider"></div>

                <div class="column">
                    <div class="row">
                        <div class="column">
                            <table class="ui table">
                                <thead>
                                    <tr>
                                        <th>제품명</th>
                                        <th>단가 가격</th>
                                        <th>최대 수량</th>
                                        <th>최소 수량</th>
                                        <th>가로/세로 고정값 여부</th>
                                        <th>가로/세로 최댓값</th>
                                        <th>가로/세로 최소값</th>
                                        <th>품절 여부</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = mq("select * from product_list order by idx asc");  
                                    while($list = $sql->fetch_array()){
                                ?>
                                    <tr>
                                        <td><?php echo $list["name"];?></td>
                                        <td><?php echo $list["price"];?></td>
                                        <td><?php echo $list["max_q"];?></td>
                                        <td><?php echo $list["min_q"];?></td>
                                        <td><?php if(isset($list["fixed1"])){echo "Y";}else echo "N";?></td>
                                        <td><?php echo $list["max_width"].'/'.$list["max_length"];?></td>
                                        <td><?php echo $list["min_width"].'/'.$list["min_length"];?></td>
                                        <td><?php echo $list["stock_chk"];?></td>
                                        <td>
                                            <a href="edit.php?value=<?php echo $list["value"];?>">수정하기</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="ui divider"></div>

                <div class="column">
                <div class="ui segment">
                  <div class="ui relaxed padded grid stackable">
                      <div class="row">
                        <div class="column">
                          <h2 class="ui header">
                            <div class="content">
                              항목 추가하기
                            </div>
                          </h2>
                        </div>
                      </div>
                      <div class="ui divider"></div>
                      <div class="row">
                        <div class="column">
                        <form class="ui form" method="post" action="/include/multi.php">
                        <h4 class="ui dividing header">제품 정보</h4>
                          <div class="field">
                            <label>기본 정보</label>
                            <div class="three fields">
                              <div class="field">
                                <input type="text" name="name" placeholder="제품명" required>
                              </div>
                              <div class="field">
                                <input type="number" name="price" placeholder="단가 가격" required step="0.0000001">
                              </div>
                              <div class="field">
                                <input type="number" name="value" placeholder="고유 번호" required>
                              </div>
                            </div>
                          </div>
                          <h4 class="ui dividing header">수치 정보</h4>
                          <div class="field">
                            <label>수치 정보</label>
                            <div class="two fields">
                              <div class="field">
                                <input type="number" name="min_q" placeholder="최소 수량" required>
                              </div>
                              <div class="field">
                                <input type="number" name="max_q" placeholder="최대 수량" required>
                              </div>
                            </div>
                            <div class="four fields">
                              <div class="field">
                                <input type="number" name="min_width" placeholder="가로 최소" required>
                              </div>
                              <div class="field">
                                <input type="number" name="max_width" placeholder="가로 최대" required>
                              </div>
                              <div class="field">
                                <input type="number" name="min_length" placeholder="세로 최소" required>
                              </div>
                              <div class="field">
                                <input type="number" name="max_length" placeholder="세로 최대" required>
                              </div>
                            </div>
                          </div>
                          <div class="field">
                            <label>고정값 있는 경우에만 작성 (작은 순으로 나열, 최대 6개)</label>
                            <div class="six fields">
                              <div class="field">
                                <input type="text" name="fixed1" placeholder="가로x세로">
                              </div>
                              <div class="field">
                                <input type="text" name="fixed2" placeholder="가로x세로">
                              </div>
                              <div class="field">
                                <input type="text" name="fixed3" placeholder="가로x세로">
                              </div>
                              <div class="field">
                                <input type="text" name="fixed4" placeholder="가로x세로">
                              </div>
                              <div class="field">
                                <input type="text" name="fixed5" placeholder="가로x세로">
                              </div>
                              <div class="field">
                                <input type="text" name="fixed6" placeholder="가로x세로">
                              </div>
                            </div>
                          </div>
                          <button class="ui button submit primary" tabindex="0" name="submit" type="submit">항목 추가하기</button>
                          <input type="hidden" name="cmd" value="4">
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