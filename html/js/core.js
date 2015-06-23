/*
 * Author : fatoni.work@gmail.com
 */
 
$(document).ready(function() {

	/*SELECT FIELD*/
	$('select').material_select();
	/*END SELECT FIELD*/

	/*MENU SLIDE*/
	$('.navmob').jPushMenu();
	/*END MENU SLIDE*/

	/*MODAL*/
	$('.modal-trigger').leanModal();
	/*END MODAL*/

	/*TAB*/
	$('ul.tabs').tabs('select_tab', 'tab_id');
	/*END TAB*/

	/*DATE PICKER*/
	$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month
		selectYears: 15 // Creates a dropdown of 15 years to control year
	});
	/*END DATE PICKER*/

	/*COLAPSE*/
	$('.collapsible').collapsible({
      	accordion : false 
    });
    /*END COLAPSE*/

    /*DROPDOWN*/
	$('.dropdown-button').dropdown({
		inDuration: 300,
		outDuration: 225,
		constrain_width: false, // Does not change width of dropdown to that of the activator
		hover: true, // Activate on hover
		gutter: 0, // Spacing from edge
		belowOrigin: false // Displays dropdown below the button
		}
	);
	/*DROPDOWN*/
	
});