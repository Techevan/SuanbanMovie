<?php
    header('Access-Control-Allow-Origin: *');

    include_once 'db_controller.php';

    class DataDetail{
        function __construct(){
            date_default_timezone_set('Asia/Shanghai');
            $this->DBController = new DBController();
            $this->DBController->connDatabase();
        }

        public function closeDBConnection() {
            // 断开与数据库的连接
            $this->DBController->disConnDatabase();
        }

        public function categoryCount(){
            $sql="SELECT num,genre_name FROM (SELECT COUNT(*) num,genre_id FROM movie_genre GROUP BY genre_id) T JOIN genres ON genres.genre_id=T.genre_id;";
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result,MYSQLI_ASSOC);
            }
            
            echo(json_encode($resultTemp,JSON_UNESCAPED_UNICODE));
        }

        public function getRate(){
            $sql='SELECT COUNT(average) FROM movies WHERE average<=10 and average>8;';
            $sql.='SELECT COUNT(average) FROM movies WHERE average<=8 and average>6;';
            $sql.='SELECT COUNT(average) FROM movies WHERE average<=6 and average>4;';
            $sql.='SELECT COUNT(average) FROM movies WHERE average<=4 and average>2;';
            $sql.='SELECT COUNT(average) FROM movies WHERE average<=2 and average>0;';
            $sql.='SELECT COUNT(average) FROM movies';
            if(mysqli_multi_query($this->DBController->getConnObject(),$sql)){
                $returnResult=[];
                do
                {
                    // 存储第一个结果集
                    if ($result=mysqli_store_result($this->DBController->getConnObject()))
                    {
                        while ($row=mysqli_fetch_row($result))
                        {
                            array_push($returnResult,$row[0]);
                        }
                        mysqli_free_result($result);
                    }
                }
                while (mysqli_next_result($this->DBController->getConnObject()));

                echo json_encode($returnResult);
            }
        }

    }
?>