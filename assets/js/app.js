(function($){
"use strict";

var lcovid = {
	time : '',
	table : '',
	fileName : 'Covid19Data',
	fileTitle : 'COVID 19 Affected Data',
	pdfFontSize : 10,
	init : function(){
		this.time = this.getTime();
	},
	getTime : function(){
		var cTm = new Date();
		return cTm.getDate() +'/'+ cTm.getMonth() + '/' + cTm.getFullYear() + ' ' + cTm.getHours() + ':' + cTm.getMinutes()+':'+ cTm.getSeconds();
	},
	showRow : function(item,tbl){
		if(item == ''){
			tbl.find('tbody tr').show()
			return false;
		} 
		tbl.find('tbody tr').hide()
		tbl.find('tbody td').each(function(){
			if( $(this).text().toLowerCase().includes(item)){
				$(this).closest('tr').show()
			}
		})
	},
	tableData : function(tbl){
		var tdCount = 0
		return tbl.find('tr').map(function(  ) {
			let elem = ($(this).find('th').length > 0) ? $(this).find('th') : $(this).find('td')
			tdCount++
		  	return  [ elem.map( function(value, key){
		  		return ($(this).is('th')) ? { text: $(this).text(), style: 'tableHeader' } : { text: $(this).text(), style: (tdCount%2 == 0) ? 'tableBodyEven' : 'tableBodyOdd'  }  
		  	}).get() ]
		}).get()
	},
	sortTable : function(tbl,index,ord='asc'){
		var tableData = [];
		let tblBody = tbl.find('tbody')
		tbl.find('tbody tr').each(function(key,val){
			let thisVal = $(this).find('td').eq(index).text()
			thisVal = thisVal.replace(/,/g,'').replace(/\./g,'').replace(/[ ]/g,'')
			thisVal = ( parseInt(thisVal) || parseInt(thisVal) == 0 ) ? parseInt(thisVal) : thisVal
			tableData.push( {key :  thisVal, div : $(this) } )
		})
		if(ord == 'dsc')
			tableData.sort( function(a,b){ return a.key > b.key ? -1 : (a.key < b.key ? 1 : 0) } )
		else
	        tableData.sort( function(a,b){ return a.key < b.key ? -1 : (a.key > b.key ? 1 : 0) } )
	    tblBody.find('tr').detach()

		$.each(tableData,function(index,val){
		    tblBody.append(val.div)
		})
	},
	rgb2hex : function(rgb){
		rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
		return (rgb && rgb.length === 4) ? "#" +
		  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
		  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
		  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
	},
	doPdf : function(){
		// This fuction can use in Live COVID19 Pro version
		return false;
	},
	doExcel : function(){
		// This fuction can use in Live COVID19 Pro version
		return false;
	},
	doPrint : function(){
		// This fuction can use in Live COVID19 Pro version
		return false;
	},
	initTable : function(elem){
		var actions = elem.data('actions')
		const table = elem.closest('.lcvad-table').find('table')
		this.table = table

		// Search Data
		elem.find('.lcvad-buttons input[type="text"]').keyup(function(e) {
			let val = $(this).val().trim().toLowerCase()
			lcovid.showRow(val,table)
		})

		// Table Sorting
		if(actions.sorting){
		   	table.find('th').click(function(e) {
				let order = ($(this).hasClass('asc') ? 'dsc' : 'asc');
				lcovid.sortTable($(this).closest('table'),$(this).index(),order )
				$(this).toggleClass('asc')	
			});
		}

	},
	initCounter : function(elem){
		var numAttr = elem.closest('.lcvad-numbers').data('attrs');
		if(numAttr.counter)
		elem.numerator( { delimiter : numAttr.delimiter , toValue : elem.data('to-value') , duration : numAttr.dur  } )
	}
}

$(document).ready(function() {
	const thisScope = $('.lcavad-def-container') 	
	lcovid.init()
	if(thisScope.length > 0){
		thisScope.each(function() {
	   		if($(this).find('.lcvad-number').length > 0){
			   	$(this).find('.lcvad-number').each(function() {
			   		lcovid.initCounter($(this))
			   	})	
			}
			if($(this).hasClass('lcvad-table')){
				lcovid.initTable($(this))
			}
	   	
	   	})	 
	}
		
});	

$(window).on("elementor/frontend/init", function() {
    elementorFrontend.hooks.addAction('frontend/element_ready/lcvad-table.default',function($scope,$){
    	var thisScope = $scope.find('.elem-container')
    	lcovid.init()
    	lcovid.initTable(thisScope)
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/lcvad-global.default',function($scope,$){
    	var thisScope = $scope.find('.elem-container')
    	lcovid.init()
    	thisScope.find('.lcvad-number').each(function() {
			 lcovid.initCounter($(this))
		})	
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/lcvad-country.default',function($scope,$){
    	var thisScope = $scope.find('.elem-container')
    	lcovid.init()
    	thisScope.find('.lcvad-number').each(function() {
			 lcovid.initCounter($(this))
		})	
    });
});

})(jQuery)
