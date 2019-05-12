<?php
    header('Access-Control-Allow-Origin: *');

    include_once 'db_controller.php';

    class MovieDetail{
        function __construct(){
            date_default_timezone_set('Asia/Shanghai');
            $this->DBController = new DBController();
            $this->DBController->connDatabase();
            $this->id = $_REQUEST['id'];
        }

        public function closeDBConnection() {
            // 断开与数据库的连接
            $this->DBController->disConnDatabase();
        }

        public function getDetail(){
            $sql="SELECT * FROM movies WHERE _id=".$this->id;
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result,MYSQLI_ASSOC);
            }
            

            $resultT=$resultTemp[0];        

            $sql="SELECT name FROM movie_cast WHERE movie_id=".$this->id;
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $resultT['casts']=$resultTemp;
            }else{
                $resultT['casts']=[];
            }

            

            $sql="SELECT name FROM movie_writer WHERE movie_id=".$this->id;
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $resultT['writers']=$resultTemp;
            }else{
                $resultT['writers']=[];
            }
            
            

            $sql="SELECT name FROM movie_director WHERE movie_id=".$this->id;
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $resultT['directors']=$resultTemp;
            }else{
                $resultT['directors']=[];
            }
            

            $sql="SELECT language FROM movie_language WHERE id=".$this->id;
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result);
                $stringTemp = [];
                foreach($resultTemp as $val){
                    array_push($stringTemp,$val[0]);
                }
                $resultT['languages']=$stringTemp;
            }else{
                $resultT['languages']=[];
            }

            $sql="SELECT genre_name FROM movie_genre JOIN genres ON movie_genre.genre_id=genres.genre_id WHERE id=".$this->id;
            $result = mysqli_query($this->DBController->getConnObject(),$sql);
            if ($result && mysqli_num_rows($result)){
                $resultTemp = mysqli_fetch_all($result);
                $stringTemp = [];
                foreach($resultTemp as $val){
                    array_push($stringTemp,$val[0]);
                }
                $resultT['genres']=$stringTemp;
            }else{
                $resultT['genres']=[];
            }

            echo(json_encode($resultT,JSON_UNESCAPED_UNICODE));
           
        }

    }
?>