
jQuery(document).ready(function(){
	function sdf_FTS(_number,_decimal,_separator)
		{
		var decimal=(typeof(_decimal)!='undefined')?_decimal:2;
		var separator=(typeof(_separator)!='undefined')?_separator:'';
		var r=parseFloat(_number)
		var exp10=Math.pow(10,decimal);
		r=Math.round(r*exp10)/exp10;
		rr=Number(r).toFixed(decimal).toString().split('.');
		b=rr[0].replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g,"\$1"+separator);
		r=(rr[1]?b+'.'+rr[1]:b);

		return r;
	}
	setTimeout(function(){
			jQuery('#counter-1').text('0');
			jQuery('#counter-2').text('0');
			jQuery('#counter-3').text('0');
			jQuery('#counter-4').text('0');
			setInterval(function(){											
				var curval1=parseInt($('#counter-1').text());
				var curval2=parseInt($('#counter-2').text());
				var curval3=parseInt($('#counter-3').text());
				var curval4=parseInt($('#counter-4').text());
				if(curval1<=1343){
					jQuery('#counter-1').text(curval1+1);
				}
				if(curval2<=152){
					jQuery('#counter-2').text(curval2+1);
				}
				if(curval3<=88){
					jQuery('#counter-3').text(curval3+1);
				}
				if(curval4<=343){
					jQuery('#counter-4').text(curval4+1);
				}
			}, 2);
			
		}, 500);
});