export function search(keyword,category,minrate,maxrate,fullArr){
    var resultArr=[];
    var tempResultArr=[];
    // 关键字检索部分
    if(keyword!=''){
      for(let item of fullArr){
        for(let key in item){
          if(key=='aka'||key=='countries'||key=='genres'||key=='languages'){
            // 数组
            for(let arritem of item[key]){
              if(arritem.indexOf(keyword)!=-1){
                // 有搜索结果
                if(resultArr.indexOf(item)==-1){
                  resultArr.push(item);
                }
                break;
              }
            }
          }else if(key=='casts'||key=='directors'||key=='writers'){
            // JSON数组
            for(let arritem of item[key]){
              if(arritem.name.indexOf(keyword)!=-1){
                // 有搜索结果
                if(resultArr.indexOf(item)==-1){
                  resultArr.push(item);
                }
                break;
              }
            }
          }else if(key=='imdb'||key=='summary'||key=='title'){
            // 字符串
            if(item[key].indexOf(keyword)!=-1){
              // 有搜索结果
              if(resultArr.indexOf(item)==-1){
                resultArr.push(item);
              }
              break;
            }
          }
          
        }
      }
    }else{
      resultArr=fullArr.slice();
    }
    // 评分筛选
    if(!(minrate==0&&maxrate==0)){
      tempResultArr.splice(0,tempResultArr.length)
      for(let item of resultArr){
        var tempRate=parseFloat(item.rating.average);
        if(tempRate<=maxrate&&tempRate>minrate){
          tempResultArr.push(item);
        }
      }
      resultArr.splice(0,resultArr.length);
      resultArr=tempResultArr.slice();
    }
    // 分类筛选
    if(category!=''){
      tempResultArr.splice(0,tempResultArr.length);
      for(let item of resultArr){
        for(let arritem of item.genres){
          if(arritem==category){
            tempResultArr.push(item);
            break;
          }
        }
      }
      resultArr.splice(0,resultArr.length);
      resultArr=tempResultArr;
    }
    return resultArr;
  }
