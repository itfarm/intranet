

function TaskAttachVisibility(Page,DivToDisplay) {
	//alert(DivToDisplay);
	Page.getElementById('attachentity').style.display = "none";
	Page.getElementById('attachnewentity').style.display = "none";
	Page.getElementById('attachexistingentity').style.display = "none";
	Page.getElementById('attachdocument').style.display = "none";
	Page.getElementById('attachnewnote').style.display = "none";
	Page.getElementById('assign').style.display = "none";
	Page.getElementById('refer').style.display = "none";
	Page.getElementById('percentcompleted').style.display = "none";
	Page.getElementById('close').style.display = "none";
	Page.getElementById(DivToDisplay).style.display = "inline";
	
	if (DivToDisplay == "attachentity") {
		Page.getElementById('attachexistingentity').style.display = "inline";
		Page.getElementById('attachexistingentityoption').checked = "true";
	} else if (DivToDisplay == "attachexistingentity" || DivToDisplay == "attachnewentity") {
		Page.getElementById('attachentity').style.display = "inline";
	}

}


function AssignVisibility(page,option,user_group_id) {

	if (option == "refer") {
		page.getElementById('user_group_id_refer').value = user_group_id;
		if (user_group_id.substr(0,1) == "G") {
			page.getElementById('viewable_by_prompt_refer').style.visibility = "visible";
		} else {
			page.getElementById('viewable_by_prompt_refer').style.visibility = "hidden";
			page.getElementById('task_viewable_by_id_refer').value = null;
		}

	} else {
		page.getElementById('user_group_id_assign').value = user_group_id;
			
		if (user_group_id.substr(0,1) == "G") {
			page.getElementById('viewable_by_prompt_assign').style.visibility = "visible";
		} else {
			page.getElementById('viewable_by_prompt_assign').style.visibility = "hidden";
			page.getElementById('task_viewable_by_id_assign').value = null;
		}
	}
}