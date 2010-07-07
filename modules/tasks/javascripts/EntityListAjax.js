

  // Function name to be called when the event occurs causing a requery
  function ShowEntities(str)
  {
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
        	document.getElementById("entity_list").innerHTML=xmlHttp.responseText;
			
        }
      }
       
	  // Reference to the file to be put in the division with its query string  
      var url="dashboard/entity_list.php";
	  url=url+"?entity_search="+str;
	  url=url+"&sid="+Math.random();
      xmlHttp.open("GET",url,true);
      xmlHttp.send(null);
  }

