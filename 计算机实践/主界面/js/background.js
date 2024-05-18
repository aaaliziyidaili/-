const totalElements=5;
let i=0,j=5;
window.onload=function(){
	mymap.dispatchAction({type:'highlight',seriesIndex:0,dataIndex:i});
	setInterval(function(){
		var currentImage=document.getElementById(`img-${i}`);
		currentImage.setAttribute("style","z-index: 80;");
		j=i;
		i++;
		if(i>=totalElements){
			i=0;
		}
		var nextImage=document.getElementById(`img-${i}`);
		currentImage.classList.add('transition-start');
		currentImage.classList.add('right');
		nextImage.classList.add('transition-end');
		nextImage.classList.add('right');
		nextImage.setAttribute("style","z-index: 70;");
		
		currentImage.onanimationend=function(){
			currentImage.classList.remove('active');
			currentImage.classList.remove('transition-start');
			currentImage.classList.remove('right');
			currentImage.setAttribute("style","z-index: 70;");
			mymap.dispatchAction({type:'downplay',seriesIndex:0,dataIndex:j});
			mymap.dispatchAction({type:'highlight',seriesIndex:0,dataIndex:i});
			
		}
		nextImage.onanimationend=function(){
			nextImage.classList.add('active');
			nextImage.classList.remove('transition-end');
			nextImage.classList.remove('right');
			nextImage.setAttribute("style","z-index: 80;");
		}
	},6000);
}
