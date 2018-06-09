//获取元素的绝对位置
function getxy(e){
	var a = new Array()
	var t = e.offsetTop;
	var l = e.offsetLeft;
	var w = e.offsetWidth;
	var h = e.offsetHeight;
	while (e = e.offsetParent) {
		t += e.offsetTop;
		l += e.offsetLeft;
	}
	a[0] = l;
	a[1] = t;
	a[2] = w;
	a[3] = h
	return a;
}
//去字符串中的数字1,2..
function getNum(text){
    var value = text.replace(/[^0-9]/ig,""); 
    return value;
}
//排序方法——按数字-从小到大
function sort_num_increase(a,b){
	return a - b;
}
//排序方法——按数字-从大到小
function sort_num_reduce(a,b){
	return b - a;
}
//排序方法——按字符串-从小到大
function sort_str_increase(a,b){
	if(a.length==b.length){
        return b.localeCompare(a);
    }else{
        return b.length-a.length;
    }
}
//排序方法——按字符串-从大到小
function sort_str_reduce(a,b){
	if(a.length==b.length){
        return b.localeCompare(a);
    }else{
        return a.length-b.length;
    }
}
