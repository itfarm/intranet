

  // Function name to be called when the event occurs causing a requery
  function ShowUsersGroups(str, option, user_id)
  {
  //alert("test");
  var xmlHttp;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
    xmlHttp.onreadystatechange=function()
      {
      	if(xmlHttp.readyState==4)
        {
			// Reference to the division to be requeried
        	if (option == "assign") {
				document.getElementById("user_group_list_assign").innerHTML=xmlHttp.responseText;
			} else if (option == "refer") {
				document.getElementById("user_group_list_refer").innerHTML=xmlHttp.responseText;
			}
        }
      }
       
	  // Reference to the file to be put in the division with its query string  
      var url="dashboard/user_group_list.php";
	  url=url+"?user_group_search="+str+"&option="+option+'&user_id='+user_id;
	  url=url+"&sid="+Math.random();
		
      xmlHttp.open("GET",url,true);
      xmlHttp.send(null);
  }

