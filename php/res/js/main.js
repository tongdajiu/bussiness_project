$(document).ready(function(){
    var elem = document.getElementById('mySwipe');
    window.mySwipe = Swipe(elem, {
        startSlide: 0,
        auto: 3000,
        continuous: true,
        disableScroll: true,
        stopPropagation: true,
        callback: function (index, element) {
			$('#btn a').removeClass("activeSlide");
			$('#swipebtn'+index).addClass("activeSlide");
		},
        transitionEnd: function (index, element) { }
    });
	var temp = '';
	for(var i=0;i<window.mySwipe.getNumSlides();i++){
	  temp += '<a id="swipebtn'+i+'"';
	  if(i==0){
		  temp += ' class="activeSlide"';
	  }
	  temp += '></a>';

	}
	$('#btn').append(temp);
});