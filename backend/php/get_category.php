<?php
    header('Access-Control-Allow-Origin: *');

    include_once 'db_controller.php';

    class CategoryDetail{
        function __construct(){
            date_default_timezone_set('Asia/Shanghai');
            $this->DBController = new DBController();
            $this->DBController->connDatabase();
        }

        public function closeDBConnection() {
            // 断开与数据库的连接
            $this->DBController->disConnDatabase();
        }

        public function getCategory(){
            $sql="SELECT * FROM genres";
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result,MYSQLI_ASSOC);
            }
            
            echo(json_encode($resultTemp,JSON_UNESCAPED_UNICODE));
           
        }

    }
?>