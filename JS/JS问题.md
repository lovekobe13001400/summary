###1.随机数组排序（可以当随机发牌来对待）：
function shuffle(arr){
  var len = arr.length;
  for(var i = 0; i < len - 1; i++){
    var idx = Math.floor(Math.random() * (len - i));
    var temp = arr[idx];
    arr[idx] = arr[len - i - 1];
    arr[len - i -1] = temp;
  }
  return arr;
}
 
//以下测试随机排序算法
var arr = [0,1,2,3,4,5,6,7,8,9];
var res = [0,0,0,0,0,0,0,0,0,0];
 
var t = 100000000;
for(var i = 0; i < t; i++){
  //随机排序好的数组
  var sorted = shuffle(arr.slice(0));
  sorted.forEach(function(o,i){
    res[i] += o;
  });
}
//res:统计1,2,3,4,5..有几个
res = res.map(function(o){
  return o / t;
  
});
//最终结果：每个位置的大概数字为多少，数字大了无限接近0.45
console.log(res);
 
###2.浏览器不支持取本地文件
问题：Cross origin requests are only supported for protocol schemes: http, data, chrome, chrome-extension, https, chrome-extension-resource.
不支持本地取xml，json文件，放到服务器就行