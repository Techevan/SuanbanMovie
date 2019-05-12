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
                  <el-col :span="8" style="text-align:left;padding-left:20px;color:#878787"></el-col>
                </el-row> 
              </div>
            </div>
        </div>
        <div class="page">
            <div style="padding-top:50px">
                <el-row>
                    <el-col :span="6" :offset="2">
                        <div>
                            <img src="../assets/avatar.jpg" class="avatar"/>
                        </div>
                        <div style="width:150px">
                            <div style="text-align:left;margin-top:30px;font-size:18px;font-weight:bold">
                                王嘉成
                            </div>
                            
                            <div style="text-align:left;margin-top:20px;font-size:14px;">
                                ●  1652673
                            </div>
                            <div style="text-align:left;margin-top:8px;font-size:14px;">
                                ●  (86) 181 1716 8330
                            </div>                            
                        </div>
                    </el-col>
                    <el-col :span="14" style="height:500px;">
                        <el-steps direction="vertical">
                            <el-step status='process' title="JSON解析" description="使用JavaScript将其解析，并 将解析后的内容动态生成为html元素，以列表的形式展示在首页"></el-step>
                            <el-step status='process' title="分页功能" description="点击下方页码切换分页"></el-step>
                            <el-step status='process' title="搜索功能" description="支持对电影名的搜索"></el-step>
                            <el-step status='process' title="筛选功能" description="可根据平均评分和电影分类进行筛选，点击标签删除筛选条件"></el-step>
                            <el-step status='process' title="电影详情页" description="点击主页上的电影条目可进入详情页"></el-step>
                            <el-step status='process' title="实现数据统计及可视化" description="在数据统计页面以及电影详情页面的评分分布处实现数据可视化"></el-step>
                            <el-step title="……"></el-step>
                        </el-steps>
                    </el-col>
                </el-row>
                
            </div>
        </div>     
    </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'movie',
  data () {
    return {
        
    }
  },
  mounted(){
    
  },
  methods:{
    
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

 .avatar{
    width:150px;
    height:150px;
    border-radius: 50%;
    box-shadow: 0 0 30pt #d7c4bb;
  }

  li{
    margin:0;
    padding:0;
  }
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
