//复选框函数
function checked(obj){
	if(obj.getAttribute("class")=="filesLi checkIcon_bg"){
		obj.setAttribute("class","filesLi checkIconActive_bg");
	}else{
		obj.setAttribute("class","filesLi checkIcon_bg");
	}
}
//文件排序方法
//function sort(obj){
//	if(obj.getAttribute("class")=="gradual_reduce"){
//		obj.setAttribute("class","gradual_increase");
//		sort_gradual_increase(obj);
//	}else{
//		obj.setAttribute("class","gradual_reduce");
//		sort_gradual_reduce(obj);
//	}
//}


