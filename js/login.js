//拖拽按钮
$('#drag').drag();
//一键设为首页
function SetHome(obj,vrl){ 
	try{ 
		obj.style.behavior='url(#default#homepage)';
		obj.setHomePage(vrl); 
		return false;
	} 
	catch(e){
		alert('您的浏览器不支持一键设为首页，请到浏览器【设置】功能里操作。');
	} 
}