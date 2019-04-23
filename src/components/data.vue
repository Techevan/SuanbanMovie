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
    axios.get('./static/films.json').then((response)=>{
      this.movieArray=response.data
    })
  },
  data () {
    return {
        chartData: {
          columns: ['word', 'count'],
          rows: getRows(),
          shape:'diamond',
        },
        pieChartData: {
          columns: ['评分', '数量'],
          rows: [
            { '评分': '8-10分', '数量': 41 },
            { '评分': '6-8分', '数量': 132 },
            { '评分': '4-6分', '数量': 19 },
            { '评分': '2-4分', '数量': 0 },
            { '评分': '0-2分', '数量': 0 }
          ]
        },
        liquidChartData:{
          columns: ['tag', 'percent'],
          rows: [{
            tag: '有评分的电影',
            percent: 0.96
          }]
        }
    }
  },
  mounted(){
    axios.get('./static/films.json').then((response)=>{
      var fullList=response.data.slice();
      
    })
    
  },
  methods:{
    
    
  }
}

function getRows () {
    return [{
      'word': '剧情',
      'count': 121
    }, {
      'word': '动作',
      'count': 26
    }, {
      'word': '西部',
      'count': 4
    }, {
      'word': '惊悚',
      'count': 42
    }, {
      'word': '犯罪',
      'count': 28
    }, {
      'word': '喜剧',
      'count': 46
    }, {
      'word': '科幻',
      'count': 15
    }, {
      'word': '动画',
      'count': 12
    }, {
      'word': '冒险',
      'count': 22
    }, {
      'word': '爱情',
      'count': 36
    }, {
      'word': '悬疑',
      'count': 17
    }, {
      'word': '恐怖',
      'count': 15
    }, {
      'word': '纪录片',
      'count': 8
    }, {
      'word': '运动',
      'count': 3
    }, {
      'word': '传记',
      'count': 10
    }, {
      'word': '历史',
      'count': 7
    }, {
      'word': '战争',
      'count': 10
    }, {
      'word': '奇幻',
      'count': 14
    }, {
      'word': '同性',
      'count': 3
    }, {
      'word': '音乐',
      'count': 7
    }, {
      'word': '家庭',
      'count': 9
    }, {
      'word': '短片',
      'count': 7
    }, {
      'word': '黑色电影',
      'count': 2
    }, {
      'word': '歌舞',
      'count': 4
    }, {
      'word': '灾难',
      'count': 1
    }, {
      'word': '情色',
      'count': 1
    }, {
      'word': '古装',
      'count': 1
    } 
    ]
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
