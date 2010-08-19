<script type"text/javascript">
  //for language change
  function showPage(str)
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
        	document.getElementById("pageWindow").innerHTML=xmlHttp.responseText;
        }
      }
      var menuid=document.getElementById("menuid").value;
      var url="<?php echo $page?>.php";
	  url=url+"?langCode="+str+"&menuid="+menuid;
	  url=url+"&sid="+Math.random();

      xmlHttp.open("GET",url,true);
      xmlHttp.send(null);
  }
</script>