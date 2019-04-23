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
                  <el-col :span="8" style="text-align:left;padding-left:20px;color:#878787">提示：点击下方查看评分分布，可查看电影星级饼图</el-col>
                </el-row> 
              </div>
            </div>
        </div>
        <div class="page" v-if="detail">
            <el-col :span="8">
                <div style="padding:40px 0;" :class="headerFixed?'isFixed':''">
                    <img :src="getPoster(detail.poster)" style="border-radius:10px;width:300px;height:450px" :onerror="imgerror"/>
                </div>
            </el-col>
            <el-col :span="16" :offset="headerFixed?8:0">
                <div style="padding-top:40px;">
                    <div style="font-size:36px;font-weight:bold;color:#434343">{{detail.title}}</div>
                    <div style="font-size:14px;margin-top:10px;color:#434343">
                        <span id='akatitle' v-if='detail.aka&&(detail.aka.length!=1||detail.aka[0]!="")'>
                            <span v-for="(akaitem,index) in detail.aka" v-bind:key='index'>
                                <span v-if="index!=0">/</span>
                                 {{akaitem}} 
                            </span>
                        </span>
                    </div>
                </div>
                <div style="padding-top:10px;font-size:15px">
                    <el-row style="margin-top:8px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">导演</el-col>
                        <el-col :span="20" style="color:#434343">
                            <span v-for="(directoritem,index) in detail.directors" v-bind:key="index">{{directoritem.name}} </span>
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">卡司</el-col>
                        <el-col :span="20" style="color:#434343">
                            <span v-for="(castitem,index) in detail.casts" v-bind:key="index">
                                <span v-if="index!=0">/</span>
                                 {{castitem.name}} 
                            </span>
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">编剧</el-col>
                        <el-col :span="20" style="color:#434343">
                            <span v-for="(writeritem,index) in detail.writers" v-bind:key="index">
                                <span v-if="index!=0">/</span>
                                 {{writeritem.name}} 
                            </span>
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">国家</el-col>
                        <el-col :span="20" style="color:#434343">
                            <span v-for="(countryitem,index) in detail.countries" v-bind:key="index">
                                <span v-if="index!=0">/</span>
                                 {{countryitem}} 
                            </span>
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">评分</el-col>
                        <el-col :span="20" style="color:#434343">
                            <span style="color:#FFB11B;font-weight:bold;margin-right:5px">{{detail.rating.average}}</span>
                            <el-tag size="mini" @click="dialogVisible=true;" v-if="detail.rating.average" class="eltag">点击查看评分分布</el-tag>
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">时长</el-col>
                        <el-col :span="20" style="color:#434343">
                            {{detail.duration}} 分钟
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">分类</el-col>
                        <el-col :span="20" style="color:#434343">
                            <span v-for="(categoryitem,index) in detail.genres" v-bind:key="index">
                                <span v-if="index!=0">/</span>
                                 {{categoryitem}} 
                            </span>
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">语言</el-col>
                        <el-col :span="20" style="color:#434343">
                            <span v-for="(languageitem,index) in detail.languages" v-bind:key="index">
                                <span v-if="index!=0">/</span>
                                 {{languageitem}} 
                            </span>
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">年份</el-col>
                        <el-col :span="20" style="color:#434343">
                            {{detail.year}}
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">IMDB</el-col>
                        <el-col :span="20" style="color:#434343">
                            {{detail.imdb}}
                        </el-col>
                    </el-row>
                    <el-row style="margin-top:12px;">
                        <el-col :span="2" style="color:#2587C6;font-weight:bold">简介</el-col>
                        <el-col :span="20" style="color:#434343">
                            {{detail.summary}}
                        </el-col>
                    </el-row>
                </div>
            </el-col>
        </div>
                
<el-dialog
  title="用户评分"
  :visible.sync="dialogVisible"
  width="30%"
  >
  <ve-pie style="padding-top:40px" :data="chartData"></ve-pie>
</el-dialog>

        
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
    // handleScroll为页面滚动的监听回调
    window.addEventListener('scroll', this.handleScroll);
  },
  destroyed(){
    window.removeEventListener('scroll', this.handleScroll);
  },
  data () {
    return {
      imgerror:`this.src="${require('../assets/fail.png')}"`,
      headerFixed:false,
      dialogVisible:false,
      chartData: {},
      detail:null
    }
  },
  mounted(){
    axios.get('./static/films.json').then((response)=>{
      var fullList=response.data.slice();
      for(let item of fullList){
          if(item._id==this.$route.query.id){
            this.detail=item;
            if(!this.detail.rating.average){
                break;
            }
            this.chartData= {
                columns: ['评分', '评分人数'],
                rows: [
                    { '评分': '★', '评分人数': this.detail.rating.stars[0] },
                    { '评分': '★★', '评分人数': this.detail.rating.stars[1] },
                    { '评分': '★★★', '评分人数': this.detail.rating.stars[2] },
                    { '评分': '★★★★', '评分人数': this.detail.rating.stars[3] },
                    { '评分': '★★★★★', '评分人数': this.detail.rating.stars[4] },
                ]
            }
            break;
          }
      }
    })
    
  },
  methods:{
    getPoster:(url)=>{
        if(!url){
            return;
        }
        return 'https://images.weserv.nl/?url='+url.substring( 7 )
    },
    handleScroll(){
      // 得到页面滚动的距离
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
      // 判断页面滚动的距离是否大于吸顶元素的位置
      this.headerFixed = scrollTop > 113;
    },
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

  .isFixed{
    position: fixed;
    top: 10px;
    left: px2rem(20);
    right: px2rem(20);
  }

  .eltag:hover{
      cursor: pointer;
  }

</style>
