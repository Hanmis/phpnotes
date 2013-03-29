/*
功能：滑动门（手风琴）效果封装类
作者：老胡
日期：2010-06-29
*/
function __AccordionClass()
{
    this.isMultiExpand = false; // 是否允许多个同时展开
    this.expandClassName = '';  // 内容展开后的，头类名称
    this.foldedClassName = '';  // 内容折叠后的，头类名称
    this.speedTime = 5 ;       // 展开折叠速度 ，隔多少毫秒执行一次
    this.speedCount = 10 ;       // 展开折叠渐变次数，多少次完成展开折叠
    this.defaultExpandIndex = 0; // 默认展开的索引
    var isIE = document.all ? true:false;
    var accordion = [];
    var obj = null;
    var accordionPan = function()
    {   
        this.isExpand = true;
        this.maxHeight=0;
        this.timer=null;
        this.header=null;
        this.content = null;
    };
    this.initAccordion = function(headerList,contentList,exClassName,fdClassName)
    {
        if(headerList&&contentList&&headerList!=null&&contentList!=null&&headerList.length>0&&headerList.length==contentList.length){
              obj = this;
              for(var i=0;i<headerList.length;i++)
              {
                  accordion[i] = new  accordionPan();
                  accordion[i].maxHeight = contentList[i].offsetHeight;
                  accordion[i].header = headerList[i];
                  accordion[i].content = contentList[i];
                  accordion[i].content.style.overflow='hidden';
                  if(exClassName&&exClassName!=null&&exClassName!='')obj.expandClassName = exClassName;
                   if(fdClassName&&fdClassName!=null&&fdClassName!='')obj.foldedClassName = fdClassName;
                  obj.bindEvent(i);
              }
              if(!obj.isMultiExpand)
              {
                   obj.expandFolded(obj.defaultExpandIndex);
              }
        }
    };
    this.bindEvent = function(i)
    {
         if(window.addEventListener){
               accordion[i].header.addEventListener('click', function(e){ obj.expandFolded(i);  },false); 
         }else{
               accordion[i].header.attachEvent("onclick",function(){ obj.expandFolded(i);  });   
         }   
    };
    this.expandFolded = function(i)
    {    
             if( accordion[i].isExpand)
             {
                 if(obj.isMultiExpand)
                 {
                    clearInterval(accordion[i].timer);
         	        accordion[i].timer=setInterval(function(){obj.folded(i);},obj.speedTime);
         	     }else{
         	          for(var j=0;j<accordion.length;j++){
         	           if(i!=j)obj.toFolded(j);
                    }
         	     }
             }
             else
             {
                 clearInterval(accordion[i].timer);
            	 accordion[i].content.style.display='';
		         accordion[i].timer=setInterval(function(){obj.expand(i);},obj.speedTime);
		         if(!obj.isMultiExpand)
                 {
                    for(var j=0;j<accordion.length;j++){
                       if(i!=j)obj.toFolded(j);
                    }
                 }
             }
    };
    this.toFolded = function(i){
         clearInterval(accordion[i].timer);
          accordion[i].timer=setInterval(function(){obj.folded(i);},obj.speedTime);
    };
    this.expand=function(i)
    {
       var h = accordion[i].content.offsetHeight;
       if(h<accordion[i].maxHeight)
       {
		   var v = Math.round((accordion[i].maxHeight-h)/obj.speedCount);
		    v = (v<1) ? 1 :v ;
		    v+=h;
		   accordion[i].content.style.height=( v)+'px';
		   if(isIE){
		        accordion[i].content.style.filter= 'alpha(opacity='+(v*100/accordion[i].maxHeight)+');';
		   }else{
		         accordion[i].content.style.opacity = (v/accordion[i].maxHeight);
		   }
	   }else{
	        if(obj.expandClassName !='') accordion[i].header.className = obj.expandClassName ;
		    accordion[i].content.style.height=accordion[i].maxHeight +'px';
		    accordion[i].isExpand = true;
		    clearInterval(accordion[i].timer);
	   }
    };
    this.folded=function(i)
    {
       var h = accordion[i].content.offsetHeight;
       if(h> 0)
       {
		   var v = Math.round(h/obj.speedCount);
		   v = (v<1) ? 1 :v ;
		   accordion[i].content.style.height=(h - v)+'px';
		   if(isIE){
		        accordion[i].content.style.filter= 'alpha(opacity='+(v*100/accordion[i].maxHeight)+');';
		   }else{
		         accordion[i].content.style.opacity = (v/accordion[i].maxHeight);
		   }
	   }else{
	        if(obj.foldedClassName !='') accordion[i].header.className = obj.foldedClassName ;
		    accordion[i].content.style.height='0px';
		    accordion[i].content.style.display='none';
		    accordion[i].isExpand = false;
		    clearInterval(accordion[i].timer);
	   }
    }
}

