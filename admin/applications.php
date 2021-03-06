<?php
	include "../class/includes.class.php";
	$include = new includes();
	echo $include->includeCSS();
	echo $include->includeJS();
?>
<script>
	$(document).ready(function(){
		var applications = {
			dataType: "json",
			dataFields: [
				{name: "status"},
				{name: "acctNo"},
				{name: "consumerName"},
				{name: "bName"},
				{name: "address"},
				{name: "municipality"},
				{name: "type"},
				{name: "so"},
				{name: "addedBy"},
				{name: "dateAdded"},
			],
			url: "sources/allApps.php",
			pagenum: 0,
			pagesize: 20,
			// pager: function (pagenum, pagesize, oldpagenum) {
				// callback called when a page or page size is changed.
			// }
			async: false
		}
		
		var appData = new $.jqx.dataAdapter(applications);
		
		$("#grid").jqxGrid({
			width: "100%",
			height: "100%",
			source: appData,
			pageable: true,
			theme: "metro",
			showtoolbar: true,
			sortable: true,
			filterable: true,
			altrows: true,
			rendertoolbar: function(toolbar){
				var container = $("<div style='margin: 5px;'></div>");
				var span = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>Search : </span>");
				var input = $("<input class='jqx-input jqx-widget-content jqx-rc-all' id='searchField' type='text' style='height: 23px; float: left; width: 223px;' />");
				var searchButton = $("<div style='float: left; margin-left: 5px;' id='search'><img style='position: relative; margin-top: 2px;' src='../assets/images/search_lg.png'/><span style='margin-left: 4px; position: relative; top: -3px;'></span></div>");
				var dropdownlist2 = $("<div style='float: left; margin-left: 5px;' id='dropdownlist'></div>");
				container.append(span);
				toolbar.append(container);
				container.append(span);
				container.append(input);
				container.append(dropdownlist2);
				container.append(searchButton);
				
				$("#search").jqxButton({height:18,width:24});
					$("#dropdownlist").jqxDropDownList({ 
					autoDropDownHeight: true,
					selectedIndex: 0,
					width: 200, 
					height: 25, 
					source: [
						"Consumer Name", "Address"
					]
				});
			},
			columns: [
				{text: "Account Number", dataField: "acctNo", cellsalign: "center", align: "center", pinned: true, width: 150},
				{text: "Consumer Name", dataField: "consumerName", align: "center", pinned: true, width: 250},
				{text: "Business Name", dataField: "bName", align: "center", pinned: true, width: 250},
				{text: "Status", dataField: "status", cellsalign: "center", align: "center", width: 180},
				{text: "Address", dataField: "address", align: "center", width: 290},
				{text: "Municipality", dataField: "municipality", align: "center", width: "150"},
				{text: "Type", dataField: "type", align: "center", width: 180},
				{text: "Service Order", dataField: "so", align: "center", width: 150},
				{text: "Added By", dataField: "addedBy", align: "center", width: 200},
				{text: "Date Added (Y-m-d)", dataField: "dateAdded", align: "center", width: 150}
			]
		});
	});
</script>
