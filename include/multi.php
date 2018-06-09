<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php
session_start();
include("dbconfig.php");
ini_set('display_errors', 0);

define("CMD_REQUEST_LOGOUT", 0);
define("CMD_REQUEST_LOGIN", 1);
define("CMD_REQUEST_ADD_ORDER", 2);
define("CMD_REQUEST_SUBMIT_ORDER", 3);
define("CMD_REQUEST_ADD_LIST", 4);
define("CMD_REQUEST_UPDATE_LIST", 5);
define("CMD_REQUEST_DONE_ORDER", 6);
define("CMD_REQUEST_DELETE_PRODUCT", 7);

switch ((int) $_POST['cmd']) {
    case CMD_REQUEST_LOGOUT:
        if(isset($_POST["submit"])){
            $session = session_id();
            $sql = "delete from order_session where session_id = '$session'";
            $mysqli->query($sql);
            session_destroy();
            die("<script>window.location.href='../index.php';</script>");
        } 
        break;
    case CMD_REQUEST_LOGIN:
        if (isset($_POST["submit"])) {
            if (empty($_POST["id"]) || empty($_POST["pw"])) {
                die("<script>alert('empty'); history.go(-1);</script>");
            } else {
                $id = $_POST['id'];
                if (preg_match("/'|\"|\\|`|@|[*]|-|;|=|%|*|<|>/i", $id)) {
                    die("<script>alert('아이디에 특수문자를 입력할 수 없습니다.'); history.go(-1); </script>");
                }
                $pw = $_POST['pw'];
                $id = addslashes($id);
                $id = stripslashes($id);
                $pw = stripslashes($pw);
                $id = mysqli_real_escape_string($conn, $id);
                $pw = mysqli_real_escape_string($conn, $pw);
                $pw = hash('sha512', $pw);

                $query = "select * from admin where id='$id' and pw='$pw'";
                $row = mysqli_fetch_assoc($mysqli->query($query));

                if ($row) {
                    $_SESSION['id'] = $row['id'];
                    die("<script>alert('{$_SESSION['id']}님 오신걸 환영합니다.'); window.location.href='/admin/index.php';</script>");
                } else {
                    die("<script>alert('입력하신 계정이 로그인에 실패 하였습니다.'); history.go(-1);</script>");
                }
            }
        }
        break;
    case CMD_REQUEST_ADD_ORDER:
        if (isset($_POST["submit"])) {
            if (empty($_POST["product"])) {
                die("<script>alert('empty'); history.go(-1);</script>");
            } else {
                // ADD_ORDER
                $product = $_POST['product'];
                $width = $_POST['width'];
                $length = $_POST['length'];
                $quantity = $_POST['quantity'];

                $product = htmlspecialchars($product);
                $width = htmlspecialchars($width);
                $length = htmlspecialchars($length);
                $quantity = htmlspecialchars($quantity);

                $product = addslashes($product);
                $width = addslashes($width);
                $length = addslashes($length);
                $quantity = addslashes($quantity);

                $product = stripslashes($product);
                $width = stripslashes($width);
                $length = stripslashes($length);
                $quantity = stripslashes($quantity);

                $product = mysqli_real_escape_string($conn, $product);
                $width = mysqli_real_escape_string($conn, $width);
                $length = mysqli_real_escape_string($conn, $length);
                $quantity = mysqli_real_escape_string($conn, $quantity);

                $session = session_id();

                $_SESSION['session'] = $session;

                // value 추가
                $query0 = mq("select * from product_list where value = '".$_POST['product']."'");
                $list0 = $query0->fetch_array();

                $price = $list0['price'];
                $final_price = (double)$price * $width * $length * $quantity;

                // 만약 선택한 것이 최소량보다 작을 떄
                $query = mq("select * from product_list where value = '".$_POST['product']."'");
                $list = $query->fetch_array();
                if($width<$list['min_width'] || $width>$list['max_width']){
                    die("<script>alert('가로가 너무 짧거나 길어요! 해당 상품의 가로는 ".$list['min_width']."~".$list['max_width']."mm 입니다.'); history.go(-1);</script>");
                }else if($length<$list['min_length'] || $length>$list['max_length']){
                    die("<script>alert('세로가 너무 짧거나 길어요! 해당 상품의 세로는 ".$list['min_length']."~".$list['max_length']."mm 입니다.'); history.go(-1);</script>");
                }else if($quantity<$list['min_q'] || $quantity>$list['max_q']){
                    die("<script>alert('수량이 너무 많거나 적어요! 해당 상품의 수량는 최소 ".$list['min_q']."개부터 ".$list['max_q']."개 입니다.'); history.go(-1);</script>");
                }else{
                $sql = "insert into order_session(session_id, product, price, width, length, quantity) 
                    values('$session','$product','$final_price','$width','$length','$quantity')";
                $mysqli->query($sql);
                die("<script>alert('성공적으로 입력되었습니다!'); window.location.href='/';</script>");
                }
            }
        }
        break;
    case CMD_REQUEST_SUBMIT_ORDER: // done!
        if (isset($_POST["submit"])) {
            if (empty($_POST["name"])) {
                die("<script>alert('empty'); history.go(-1);</script>");
            }else
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $other = $_POST['other'];   

            $name = htmlspecialchars($name);
            $contact = htmlspecialchars($contact);
            $email = htmlspecialchars($email);
            $other = htmlspecialchars($other);

            $name = addslashes($name);
            $contact = addslashes($contact);
            $email = addslashes($email);
            $other = addslashes($other);

            $name = stripslashes($name);
            $contact = stripslashes($contact);
            $email = stripslashes($email);
            $other = stripslashes($other);

            $name = mysqli_real_escape_string($conn, $name);
            $contact = mysqli_real_escape_string($conn, $contact);
            $email = mysqli_real_escape_string($conn, $email);
            $other = mysqli_real_escape_string($conn, $other);
        
            $session = session_id();

            $sql = mq("select * from order_session where session_id = '$session'");
            while($list = $sql->fetch_array()){
                $sql2 = "insert into order_list(name, contact, email, other, product, price, width, length, quantity) 
                values('$name', '$contact', '$email', '$other', '".$list['product']."', '".$list['price']."', '".$list['width']."', '".$list['length']."', '".$list['quantity']."')";
                $mysqli->query($sql2);
            }
            die("<script>alert('성공적으로 견적이 등록되었습니다!'); window.location.href='/';</script>");
        }
        break;
    case CMD_REQUEST_ADD_LIST: // done!
        if (isset($_POST['submit'])){
            $name = $_POST['name'];
            $price = $_POST['price'];
            $value = $_POST['value'];

            $sql_chk = "select * from product_list where value = '$value'";
            $result = mysqli_fetch_array($mysqli->query($sql_chk));
            if($result){
                die("<script>alert('고유번호가 중복됩니다.'); history.go(-1);</script>");
            }

            $max_q = $_POST['max_q'];
            $min_q = $_POST['min_q'];
            if($max_q<$min_q){
                die("<script>alert('최소 수량이 최대 수량보다 큽니다!'); history.go(-1);</script>");
            }
            $max_width = $_POST['max_width'];
            $min_width = $_POST['min_width'];
            if($max_width<$min_width){
                die("<script>alert('최소 가로이 최대 가로보다 큽니다!'); history.go(-1);</script>");
            }
            $max_length = $_POST['max_length'];
            $min_length = $_POST['min_length'];
            if($max_length<$min_length){
                die("<script>alert('최소 세로가 최대 세로보다 큽니다!'); history.go(-1);</script>");
            }
            $stock_chk = "N";
            if($_POST['fixed1']==NULL){
                $sql = "insert into product_list(name, price, value, max_q, min_q, max_width, min_width, max_length, min_length, stock_chk) 
                values('$name', '$price', '$value', '$max_q', '$min_q', '$max_width', '$min_width', '$max_length', '$min_length', '$stock_chk')";
                $mysqli->query($sql);
                die("<script>alert('성공적으로 입력되었습니다!'); window.location.href='/admin/add.php';</script>");
            }else 
                $fixed1 = $_POST['fixed1'];
                $fixed2 = $_POST['fixed2'];
                $fixed3 = $_POST['fixed3'];
                $fixed4 = $_POST['fixed4'];
                $fixed5 = $_POST['fixed5'];
                $fixed6 = $_POST['fixed6'];
            $sql = "insert into product_list(name, price, value, max_q, min_q, max_width, min_width, max_length, min_length, fixed1, fixed2, fixed3, fixed4, fixed5, fixed6, stock_chk) 
            values('$name', '$price', '$value', '$max_q', '$min_q', '$max_width', '$min_width', '$max_length', '$min_length', '$fixed1', '$fixed2', '$fixed3', '$fixed4', '$fixed5', '$fixed6', '$stock_chk')";
            $mysqli->query($sql);
            die("<script>alert('성공적으로 입력되었습니다!'); window.location.href='/admin/add.php';</script>");
        }
        break;
    case CMD_REQUEST_UPDATE_LIST:
        if (isset($_POST['submit'])){
            $name = $_POST['name'];
            $price = $_POST['price'];
            $value = $_POST['value'];
            $stock_chk = $_POST['stock_chk'];
            $max_q = $_POST['max_q'];
            $min_q = $_POST['min_q'];
            if($max_q<$min_q){
                die("<script>alert('최소 수량이 최대 수량보다 큽니다!'); history.go(-1);</script>");
            }
            $max_width = $_POST['max_width'];
            $min_width = $_POST['min_width'];
            if($max_width<$min_width){
                die("<script>alert('최소 가로이 최대 가로보다 큽니다!'); history.go(-1);</script>");
            }
            $max_length = $_POST['max_length'];
            $min_length = $_POST['min_length'];
            if($max_length<$min_length){
                die("<script>alert('최소 세로가 최대 세로보다 큽니다!'); history.go(-1);</script>");
            }

            if($_POST['fixed1']==NULL){
                $sql = "update product_list set name='$name', price='$price', value='$value', max_q='$max_q', min_q='$min_q', max_width='$max_width', min_width='$min_width', max_length='$max_length', min_length='$min_length', stock_chk='$stock_chk' where value='$value'";
                $mysqli->query($sql);
                die("<script>alert('성공적으로 수정되었습니다!'); window.location.href='/admin/add.php';</script>");
            }else 
                $fixed1 = $_POST['fixed1'];
                $fixed2 = $_POST['fixed2'];
                $fixed3 = $_POST['fixed3'];
                $fixed4 = $_POST['fixed4'];
                $fixed5 = $_POST['fixed5'];
                $fixed6 = $_POST['fixed6'];
            $sql = "update product_list set name='$name', price='$price', value='$value', max_q='$max_q', min_q='$min_q', max_width='$max_width', min_width='$min_width', max_length='$max_length', min_length='$min_length', stock_chk='$stock_chk', fixed1='$fixed1', fixed2='$fixed2', fixed3='$fixed3', fixed4='$fixed4', fixed5='$fixed5', fixed6='$fixed6' where value='$value'";
            $mysqli->query($sql);
            die("<script>alert('성공적으로 수정되었습니다!'); window.location.href='/admin/add.php';</script>");
        }
        break;
    case CMD_REQUEST_DONE_ORDER:
        if (isset($_POST['submit'])){
            $idx = $_POST['idx'];
            $sql = "update order_list set done_chk='Y' where idx='$idx'";
            $mysqli->query($sql);
            die("<script>alert('성공적으로 처리되었습니다!'); window.location.href='/admin/index.php';</script>");
        }
        break;
    case CMD_REQUEST_DELETE_PRODUCT:
        if (isset($_POST['submit'])){
            $value = $_POST['value'];
            $sql = "delete from product_list where value='$value'";
            $mysqli->query($sql);
            die("<script>alert('성공적으로 삭제되었습니다!'); window.location.href='/admin/add.php';</script>");
        }
        break;
}


?>
