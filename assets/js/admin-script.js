(function($){
"use strict";
	var lcovidSC = {
		genInput : '',
		table : '',
		inputs : '',
		actInputs : '',
		prefix : '[',
		mod  : '',
 		suffix : ']',
		_init : function(){
			this.mod = $('#shortcodes').val()
			this.genInput = $('input#gn_shortcode'),
			this.inputs = $('input#gn_shortcode').closest('table').find('.lcovid-inputs'),
			this.actInputs = $('input#gn_shortcode').closest('table').find('.lcovid-inputs:not([disabled])'),
			this.table = $('input#gn_shortcode').closest('table')
			this.showHide()
			this.setShortcode()
		},
		setInput : function(){
			this.actInputs = this.genInput.closest('table').find('.lcovid-inputs:not([disabled])')
		},
		setShortcode : function(){
			var sc = this.prefix
			this.actInputs.each(function(){
				if($(this).attr('id') == 'shortcodes'){
					sc = this.mod = sc + $(this).val().trim()
				}else if($(this).attr('type') == 'checkbox'){
					if($(this).is(":checked")){
						if($(this).data('default') == 'yes') return true
						sc += ' '+$(this).attr('id') + '="yes"'
					}
					else{
						if($(this).data('default') != 'yes') return true
						sc += ' '+$(this).attr('id') + '="no"'
					}
				}else{
					if( $(this).data('default') == $(this).val().trim() ) return true
					if( $(this).val().trim() ){
						if( $(this).val().trim() == 'space' )
							sc += ' '+$(this).attr('id') + '=" "'
						else
							sc += ' '+$(this).attr('id') + '="' + $(this).val().trim() + '"'
					}
					
 				}
			})
			sc += this.suffix
			this.genInput.val(sc)
		},
		checkCondition : function(cond){
			var _this = this
			var count = 0; var enable = 0;
			$.each(cond,function(k,v){
				let thisId = _this.table.find('#'+k)
				count++;
				if(thisId.attr('type') == 'checkbox'){
					if(thisId.is(':checked')) enable++;
				}else if(thisId.val().trim()  || thisId.val() ){
					let val =  thisId.val().trim() || thisId.val();
					if( $.type(v) == 'array' ){
						console.log(v)
						console.log(val)
						console.log($.inArray(val, v ) !== -1)
                        if( $.inArray(val, v ) !== -1 ) enable++;
					}else{
                        if( val == v ) enable++;
                    }
		 		}	
			})
			return (count == enable) ? true : false
		},
		showHide : function(){
			var _this = this
			this.inputs.each(function(){
				if( $(this).is('[data-show]') ){
					let cond = $(this).data('show')
					let res = _this.checkCondition(cond)
					if(res){
						$(this).prop('disabled', false);
						_this.setInput();
						$(this).closest('tr').show()
					}else{
						$(this).prop('disabled', true);
						_this.setInput();
						$(this).closest('tr').hide()
					}
				}
			})
			this.setInput()
		},
		start : function(){
			var _this = this
			this.inputs.each(function(){
				if($(this).attr('type') == 'checkbox' || $(this).is('select') ){
					$(this).change( function(){  _this.showHide(); _this.setShortcode() } );
				}else{
					$(this).keyup( function(){ _this.showHide(); _this.setShortcode() } );
					if($(this).attr('type') == 'number')
						$(this).change( function(){ _this.showHide(); _this.setShortcode() } );
 				}
			})
		}
		
	}


	$(document).ready(function() {
		lcovidSC._init();
		lcovidSC.start();
		if($('#copy').length > 0){
			$('#copy').click(function(e) {
				e.preventDefault()
				var copyText = $('#gn_shortcode')
				copyText.select()
				document.execCommand("copy");
				$('#copy').val('copied')
				setTimeout(function(){ $('#copy').val('copy') }, 500)
			});
			
		}
	})
})(jQuery)