<template>
    <div>
        <div id="top">
            <router-link :to="{path:'/'}" >首页</router-link>
            <router-link :to="{path:'/data'}" >数据统计</router-link>
            <router-link :to="{path:'/about'}" >关于</router-link>
            <a href="https://github.com/Techevan/SuanbanMovie" >GitHub</a>
        </div>
        <div id="header" style="min-width:1040px">
            <div id="headertop">
                <div class="page">
                    <div id="logo">蒜瓣电影</div>
                </div>
                <div style="clear:both"></div>
            </div>
            <div id="headerbottom">
              <div class="page" style="padding-top:15px">
                <el-row style="text-align:center">
                  <router-link  :to="{path:'/'}" ><el-col class="headeritem" :span="2">首页</el-col></router-link>
                  <router-link  :to="{path:'/data'}" ><el-col class="headeritem" :span="2">数据统计</el-col></router-link>
                  <router-link  :to="{path:'/about'}" ><el-col class="headeritem" :span="2">关于作业</el-col></router-link>
                  <a href="https://github.com/Techevan/SuanbanMovie" ><el-col class="headeritem" :span="2">GitHub</el-col></a>
                  <el-col :span="8" style="text-align:left;padding-left:20px;color:#878787">提示：下方为当前数据的可视化表达</el-col>
                </el-row> 
              </div>
            </div>
        </div>
        <div class="page">
            <el-row style="padding-top:20px">
                <el-col :span="12">
                    <div style="padding-right:10px">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <span style="font-weight:bold">词云图</span>
                            </div>
                            <div class="item">
                                <ve-wordcloud :data="chartData"></ve-wordcloud>
                            </div>
                        </el-card>
                    </div>
                    
                </el-col>
                <el-col :span="12">
                    <div style="padding-left:10px">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <span style="font-weight:bold">有评分的电影</span>
                            </div>
                            <div class="item">
                                <ve-liquidfill :data="liquidChartData"></ve-liquidfill>
                            </div>
                        </el-card>
                    </div>                    
                </el-col>
            </el-row>
            <el-row style="padding-top:20px">
                <el-col :span="24">
                    <div>
                        <el-card class="box-card" style="text-align:center">
                            <div slot="header" class="clearfix">
                                <span style="font-weight:bold">评分分布</span>
                            </div>
                            <div class="item">
                                <ve-pie :data="pieChartData"></ve-pie>
                            </div>
                        </el-card>
                    </div>
                </el-col>
            </el-row>
        </div>     
    </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'movie',
  created(){
    
  },
  data () {
    return {
        chartData: {
          columns: ['word', 'count'],
          rows: [],
          shape:'diamond',
        },
        pieChartData: {},
        liquidChartData:{}
    }
  },
  mounted(){
    // 获取词云图所需数据
    axios.get('https://www.techevan.wang/php/category_count_api.php').then((response)=>{
      let tempArr=[];
      for(let item of response.data){
        tempArr.push({'word':item.genre_name,'count':parseInt(item.num)})
      }
      this.chartData.rows= tempArr;
    })
    
    // 获取评分分布以及评分总数所需数据
    axios.get('https://www.techevan.wang/php/get_rate_api.php').then((response)=>{
      this.pieChartData={
          columns: ['评分', '数量'],
          rows: [
            { '评分': '8-10分', '数量': parseInt(response.data[0]) },
            { '评分': '6-8分', '数量': parseInt(response.data[1]) },
            { '评分': '4-6分', '数量': parseInt(response.data[2]) },
            { '评分': '2-4分', '数量': parseInt(response.data[3]) },
            { '评分': '0-2分', '数量': parseInt(response.data[4]) }
          ]
        };
        this.liquidChartData={
          columns: ['tag', 'percent'],
          rows: [{
            tag: '有评分的电影',
            percent: (parseInt(response.data[0])+parseInt(response.data[1])+parseInt(response.data[2])+parseInt(response.data[3])+parseInt(response.data[4]))/parseInt(response.data[5])
          }]
        }
    })
    
    
  },
  methods:{
    
    
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  a:link,a:visited,a:hover,a:active{
    color:black;
    text-decoration: none;
  }
  
  .page{
    width: 1040px;
    margin:auto;
  }
  
  #top{
    width:100%;
    background:#545652;
    height:28px;
    color:white;
    font-size:12px;
    vertical-align:center;
    line-height:28px;
    padding:0 10px;
  }

  #top a{
    color:white;
    text-decoration: none;
    padding:0 10px;
    font-weight: lighter;
  }

  #top a:hover{
    font-weight: bold;
  }

  #header{
    width:100%;
    background:#F0F3F5;
    height:115px;
    font-size:12px;
    vertical-align:center;
    line-height:28px;
    padding: 10px
  }

  #headertop{
    margin:auto;
    border-bottom: solid 1px #e0e0e0;
  }

  .headeritem{
    border-left:solid 1px #e0e0e0;
    border-right:solid 1px #e0e0e0;
    margin-left: -1px
  }

  .headeritem:hover{
    background-color: rgba(37,135,198, 0.1);
    transition: all ease 0.3s;
    cursor: pointer;
  }

  #logo{
      width:145px;
      height:56px;
      font-size: 32px;
      color:#1C88CB;
      font:'微软雅黑';
      padding-top:10px;
      font-weight: bold;
      float: left;
      line-height: 32px;
  }


</style>
