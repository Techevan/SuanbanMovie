<?php
    header('Access-Control-Allow-Origin: *');

    include_once 'db_controller.php';

    class MovieSearch{
        function __construct(){
            date_default_timezone_set('Asia/Shanghai');
            $this->DBController = new DBController();
            $this->DBController->connDatabase();
            // Parameters
            $this->keyword = $_REQUEST['keyword'];
            $this->category = $_REQUEST['category'];
            $this->minrate = $_REQUEST['minrate'];
            $this->maxrate = $_REQUEST['maxrate'];
            $this->page = $_REQUEST['page'];
        }

        public function closeDBConnection() {
            // 断开与数据库的连接
            $this->DBController->disConnDatabase();
        }

        public function getSearchResult(){
            //SELECT *
            //FROM(   SELECT * 
            //        FROM (  SELECT * 
            //                FROM movie_genre JOIN movies ON movie_genre.id=movies._id
            //                WHERE genre_id=(?)  ) CT 
            //        WHERE average<=(?) and average>(?)  ) AT
            //WHERE locate('Nick',title)=1
            //LIMIT (?),(?);

            $sqlString='';
            // 处理分类
            if($this->category!=''){
                $sqlString='(SELECT * FROM movie_genre JOIN movies ON movie_genre.id=movies._id WHERE genre_id='.$this->category.'  ) CT ';
            }else{
                $sqlString='(movie_genre JOIN movies ON movie_genre.id=movies._id)';
            }
            // 处理评分
            if(!($this->minrate==0&&$this->maxrate==0)){
                $sqlString='(SELECT * FROM '.$sqlString.' WHERE average<='.$this->maxrate.' and average>'.$this->minrate.' ) AT';
            }
            // 处理关键字
            if($this->keyword!=''){
                $sqlString='SELECT distinct _id,poster,title,summary,duration,imdb,year,average,star5,star4,star3,star2,star1 FROM '.$sqlString.' WHERE locate("'.$this->keyword.'",title)>0';
            }else{
                $sqlString='SELECT distinct _id,poster,title,summary,duration,imdb,year,average,star5,star4,star3,star2,star1 FROM '.$sqlString;
            }

            $resultCount = mysqli_query($this->DBController->getConnObject(),"SELECT COUNT(*) FROM (".$sqlString.") TT;");
            if ($resultCount && mysqli_num_rows($resultCount)){
                $totalItemCount= json_encode(mysqli_fetch_all($resultCount)[0][0]);
            }else{
                $totalItemCount= 0;
            }
            

            //echo "SELECT COUNT(*) FROM (".$sqlString.");";
            //
            $sqlString=$sqlString.' LIMIT '.((($this->page)-1)*10).', 10;';
            //$sqlString=$sqlString.' LIMIT 1 , 10;';
            // echo $sqlString;

            $result = mysqli_query($this->DBController->getConnObject(),$sqlString);
            $totalResult=[];
            //echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
            if ($result && mysqli_num_rows($result)){
                
                

                while ($row=mysqli_fetch_object($result))
                {
                    $rowTemp=(array)$row;
                    
                    // casts
                    $castResult=mysqli_query($this->DBController->getConnObject(),"SELECT name FROM movie_cast WHERE movie_id=".$row->_id);
                    if ($result && mysqli_num_rows($result)){
                        $resultTemp = mysqli_fetch_all($castResult, MYSQLI_ASSOC);
                        $rowTemp['casts']= $resultTemp;
                    }else{
                        $rowTemp['casts']= [];
                    }
                    
                    // directors
                    $directorResult=mysqli_query($this->DBController->getConnObject(),"SELECT name FROM movie_director WHERE movie_id=".$row->_id);
                    if ($result && mysqli_num_rows($result)){
                        $resultTemp = mysqli_fetch_all($directorResult, MYSQLI_ASSOC);
                        $rowTemp['directors']= $resultTemp;
                    }else{
                        $rowTemp['directors']= [];
                    }

                    // aka
                    $akaResult=mysqli_query($this->DBController->getConnObject(),"SELECT aka FROM movie_aka WHERE id=".$row->_id);
                    if ($result && mysqli_num_rows($result)){
                        $resultTemp = mysqli_fetch_all($akaResult);
                        $stringTemp = [];
                        foreach($resultTemp as $val){
                            array_push($stringTemp,$val[0]);
                        }
                        $rowTemp['aka']=$stringTemp;
                    }else{
                        $rowTemp['aka']= [];
                    }
                    
                    array_push($totalResult,$rowTemp);               
                }

                
                
                //$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
            }
            echo json_encode(array('data'=>$totalResult,'total'=>$totalItemCount,'test'=>$sqlString),JSON_UNESCAPED_UNICODE);
            return;


           
        }

    }

?>