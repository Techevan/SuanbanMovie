<template>
    <div v-loading="loading">
        <div id="top">
            <a href="#" @click="clickHomepage">首页</a>
            <a href="#">数据统计</a>
            <a href="#">关于</a>
            <a href="#">Github</a>
        </div>
        <div id="header">
            <div id="headertop">
                <div class="page">
                    <div id="logo">蒜瓣电影</div>
                </div>
                <div id="searchbar">
                    <el-input
                        placeholder="请输入内容"
                        v-model="searchbar">
                        <i slot="prefix" class="el-input__icon el-icon-search"></i>
                    </el-input>       
                </div>
                <div id="searchbtn">
                    <el-button type="primary" @click="searchbtn" plain>搜索</el-button>
                </div>
                <div style="clear:both"></div>
            </div>
            <div id="headerbottom">
              <div class="page" style="padding-top:15px">
                <el-row style="text-align:center">
                  <el-col class="headeritem" :onclick="clickHomepage" :span="2">首页</el-col>
                  <el-col class="headeritem" @click="clickData" :span="2">数据统计</el-col>
                  <el-col class="headeritem" :span="2">关于作业</el-col>
                  <el-col class="headeritem" :span="2">GitHub</el-col>
                  <el-col :span="8" style="text-align:left;padding-left:20px;color:#878787">提示：点击下方电影条目查看详情，并提供筛选和搜索服务</el-col>
                </el-row> 
              </div>
            </div>
        </div>

        <div class="page">
            <el-col :span="18" style="padding-top:20px">
                <el-table
                    v-loading='loading'
                    @row-click='clickRow'
                    :data="showArray"
                    style="width: 100%">
                    <el-table-column
                    :label='"共"+movieArray.length+"个结果"'
                    width="120"
                    prop="poster">
                        <template slot-scope="props">
                            <img class="poster" :src="getPoster(props.row.poster)" alt='' :onerror="imgerror"/>
                        </template>
                    </el-table-column>
                    <el-table-column
                    prop="name">
                    <template slot-scope="props">
                        <div class="title oneline">
                        <span id="maintitle">{{props.row.title}}</span>
                        <span id='akatitle' v-if='props.row.aka.length!=1||props.row.aka[0]!=""'>
                            <span v-for="(akaitem,index) in props.row.aka" v-bind:key="'aka'+index">/ {{akaitem}} </span>
                        </span>
                        </div>
                        <div class="cast oneline">
                        <span v-for="(directoritem,index) in props.row.directors" v-bind:key="'director'+index">{{directoritem.name}} </span>
                        <span>(导演)</span>
                        <span v-for="(castitem,index) in props.row.casts" v-bind:key="'cast'+index">/ {{castitem.name}} </span>
                        </div>
                        <div class="summary threeline">
                        <span>{{props.row.summary}}</span>
                        </div>
                        <div class="rate oneline">
                        <span v-if='props.row.rating.rating_people'>
                            <span style="color:#FEAB43"  >★</span>
                            <span style="color:#FEAB43">{{props.row.rating.average}}</span> (共{{props.row.rating.rating_people}}人参与评分)
                        </span>
                        <span v-if='!props.row.rating.rating_people'>
                            <span>当前尚无用户参与评分</span>
                        </span>
                        </div>
                    </template>
                    </el-table-column>
                </el-table>
                <div style="width:100%;text-align:center;margin:30px 0">
                  <el-pagination
                    v-loading='loading'
                    @current-change='pageChange'
                    background
                    layout="prev, pager, next"
                    :current-page='currentPage'
                    :total="movieArray.length">
                  </el-pagination>
                </div>
            </el-col>
            <el-col :span="6" style="padding-top:20px">
                <div style="padding-left:30px"  :class="headerFixed?'isFixed':''">
                    <div style="font-size:14px;color:#909399;height:23px;line-height:23px;vertical-align:middle;font-weight:bold;padding-top:12px;padding-bottom:12px">在结果中筛选</div>
                    <div>
                        <el-form ref="form" :model="form" label-width="80px">
                            <div class="elsection" style="margin-top:0">
                              <div class="elsubsection" v-if='form.resultTag.length!=0'>
                                <el-tag
                                  v-bind:key="'tag'+index"
                                  v-for="(tag,index) in form.resultTag"
                                  closable
                                  :disable-transitions="false"
                                  @close="handleClose(tag)">
                                  搜索关键字：{{tag}}
                                </el-tag>
                              </div>
                              <div class="elsubsection" v-if='form.rateRange!=0'>
                                <el-tag
                                  v-bind:key="'ratetag'+index"
                                  v-for="(tag,index) in form.rateRange"
                                  closable
                                  :disable-transitions="false"
                                  @close="handleRateClose(tag)">
                                  评分范围：{{(tag-1)*2}}~{{tag*2}}分
                                </el-tag>
                              </div>
                              <div class="elsubsection" v-if='form.category!=""'>
                                <el-tag
                                  v-bind:key="'categorytag'+index"
                                  v-for="(tag,index) in [form.category]"
                                  closable
                                  :disable-transitions="false"
                                  @close="handleCategoryClose(tag)">
                                  电影分类：{{form.category}}
                                </el-tag>
                              </div>
                            </div>
                            <div class="elsection">
                                <div class="ellabel">按评分</div>
                                <el-radio-group v-model="form.rateRange" @change='rateChange' style="width:100%;display:block">
                                  <div style="margin:5px 0;">
                                      <el-radio v-model="form.rateRange" label="5" border style="width:100%;display:block">8~10分</el-radio>
                                  </div>
                                  <div style="margin:5px 0;">
                                      <el-radio v-model="form.rateRange" label="4" border style="width:100%;display:block">6~8分</el-radio>
                                  </div>
                                  <div style="margin:5px 0;">
                                      <el-radio v-model="form.rateRange" label="3" border style="width:100%;display:block">4~6分</el-radio>
                                  </div>
                                  <div style="margin:5px 0;">
                                      <el-radio v-model="form.rateRange" label="2" border style="width:100%;display:block">2~4分</el-radio>
                                  </div>
                                  <div style="margin:5px 0;">
                                      <el-radio v-model="form.rateRange" label="1" border style="width:100%;display:block">0~2分</el-radio>
                                  </div>
                                </el-radio-group>
                            </div>
                            <div class="ellabel">
                                <div class="ellabel">按分类</div>
                                <div>
                                    <el-select v-model="form.category" filterable placeholder="请选择分类" style="width:100%;" @change="categoryChange">
                                        <el-option
                                        v-for="(item,index) in categories"
                                        :key="'category'+index"
                                        :label="item"
                                        :value="item">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </el-form>
                        
                    </div>
                </div>   
            </el-col>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import * as util from '../util/util';
export default {
  name: 'movie',
  mounted(){
    this.loading=true;
    axios.get('./static/films.json').then((response)=>{
      console.log(response.data);
      this.fullListArray=response.data.slice();
      this.movieArray=response.data.slice();
      this.showArray=response.data.slice((this.currentPage-1)*10,(this.movieArray.length>this.currentPage*10)?this.currentPage*10:this.movieArray.length)
      setTimeout(() => {
        this.loading=false;
      }, 500);
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
      movieArray:[],
      showArray:[],
      fullListArray:[],
      searchbar:'',
      currentPage:1,
      form:{
          rateRange:0,
          category:'',
          resultTag:[],
      },
      loading:false,
      categories:['剧情','动作','西部','惊悚','犯罪','喜剧','科幻','动画','冒险','爱情',
      '悬疑','恐怖','纪录片','运动','传记','历史','战争','奇幻','同性','音乐','家庭','短片','黑色电影','歌舞','灾难','情色','古装'],
    }
  },
  watch:{
 
  },
  methods:{
    clickRow(rol,col,event){
      console.warn(rol)
      this.$router.push({
        path: '/detail',
          query: {
            id:rol._id
          }
      })
    },
    clickHomepage(){
      this.$router.push({
        path: '/',
      })
    },
    clickData(){
      console.warn('DATA')
      this.$router.push({
        path: '/data',
      })
    },
    pageChange(res){
      this.currentPage=res;
      this.showArray.splice(0,this.showArray.length);
      this.showArray=this.movieArray.slice((this.currentPage-1)*10,(this.movieArray.length>this.currentPage*10)?this.currentPage*10:this.movieArray.length)
    },
    presearch(){
      this.loading=true;
      this.currentPage=1;
      var tempFullListArray=this.fullListArray.slice();
      this.movieArray.splice(0,this.movieArray.length);
      this.movieArray=(util.search((this.form.resultTag[0])?this.form.resultTag[0]:'',this.form.category,this.form.rateRange==0?0:(this.form.rateRange-1)*2,
      this.form.rateRange==0?0:this.form.rateRange*2,tempFullListArray)).slice();
      this.showArray.splice(0,this.showArray.length);
      this.showArray=this.movieArray.slice((this.currentPage-1)*10,(this.movieArray.length>this.currentPage*10)?this.currentPage*10:this.movieArray.length)
      setTimeout(()=>{
        this.loading=false
      },500)
    },
    searchbtn(){
      this.form.resultTag.splice(0,1);
      this.form.resultTag.push(this.searchbar);
      this.searchbar='';
      this.presearch();
    },
    rateChange(res){
      this.presearch()
    },
    categoryChange(res){
      this.presearch()
    },
    getPoster:(url)=>{
      return 'https://images.weserv.nl/?url='+url.substring( 7 )
    },
    handleClose(tag) {
      this.form.resultTag.splice(this.form.resultTag.indexOf(tag), 1);
      this.presearch();
    },
    handleRateClose(tag){
      this.form.rateRange=0;
      this.presearch();
    },
    handleCategoryClose(tag){
      this.form.category='';
      this.presearch();
    },
    handleScroll(){
      // 得到页面滚动的距离
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
      // 判断页面滚动的距离是否大于吸顶元素的位置
      this.headerFixed = scrollTop > 165;
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
    border-bottom: solid 1px #e0e0e0;
    margin:auto;
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

  #searchbar{
      width:500px;
      line-height: 56px;
      vertical-align: middle;
      height:56px;
      float:left;
      margin-left: 10px
  }

  #searchbtn{
      width:100px;
      line-height: 56px;
      vertical-align: middle;
      height:56px;
      float:left;
      margin-left: 5px
  }

  .page{
    width: 1040px;
    margin:auto;
  }

  .poster{
    width:100px;
  }

  .title{
    margin-top: 5px;
    font-size: 14px;
  }
  .title #maintitle{
    color:#37a
  }

  .title #akatitle{
    color: #898989;
  }

  .oneline{
    display: -webkit-box;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    padding-left: 15px;
    padding-right:15px;
    box-sizing: border-box;
  }
  .cast{
    margin-top:6px;
    font-size: 12px;
    color:#434343;
    text-align: justify;
    line-height: 150%;
  }
  .rate{
    margin-top:12px;
    font-size: 12px;
    color:#989898;
    text-align: justify;
    line-height: 140%;
  }
  .summary{
    margin-top:10px;
    font-size: 13px;
    color:#767676;
    text-align: justify;
    line-height: 140%;
  }
  .threeline{
    display: -webkit-box;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    padding-left: 15px;
    padding-right:15px;
    box-sizing: border-box;
    height:52px;
  }

  .elsection{
    margin:20px 0;
  }
  .elsubsection{
    margin: 2px;
    display: inline-block;
  }

  .ellabel{
    font-size: 10px;
    color:#434343;
    margin:10px 0 ;
  }

  .isFixed{
    position: fixed;
    top: 10px;
    width:300px;
    left: px2rem(20);
    right: px2rem(20);
  }
</style>
