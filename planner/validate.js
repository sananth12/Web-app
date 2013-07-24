function checkform()
    {
      var flag=0;
      var fname=document.getElementById("name");
      var password=document.getElementById("pass");
      var pass_rep=document.getElementById("rep_pass");
      
		
      
      if(fname.value=="")
      {  flag++;
         document.getElementById("name").disabled = true;
         document.getElementById("name").style.borderColor = 'yellow';        
          document.getElementById("name").disabled = false;
         document.getElementById("name_error").innerHTML = "This field must not be left empty";    
          //return false;
      }
       if(document.getElementById("username").value=="")
     {
              document.getElementById("username").disabled = true;
         document.getElementById("username").style.borderColor = 'yellow';        
          document.getElementById("username").disabled = false;
         document.getElementById("username_error").innerHTML = "This field must not be left empty";    
         flag++;// return false;
     } 
   
     if(password.value=="")
     {
       document.getElementById("pass").disabled = true;
         document.getElementById("pass").style.borderColor = 'yellow';        
          document.getElementById("pass").disabled = false;
         document.getElementById("pass_error").innerHTML = "This field must not be left empty";    
         flag++;// return false;
     }
	  if(password.value!="")
     {
          if(password.value.length <5 || password.value.length >10)
		 {document.getElementById("pass").disabled = true;
         document.getElementById("pass").style.borderColor = 'yellow';        
          document.getElementById("pass").disabled = false;
         document.getElementById("pass_error").innerHTML = "Password must have 5-10 characters only";    
         flag++;// return false;
		 }
		 else
		 {
		   var ex=/\W/;
		  if(ex.test(password.value))
		   {document.getElementById("pass").disabled = true;
         document.getElementById("pass").style.borderColor = 'yellow';        
          document.getElementById("pass").disabled = false;
         document.getElementById("pass_error").innerHTML = "Password must contain a-z, A-Z ,0-9, _ characters only";    
         flag++;// return false;
		     
		   }
		 }
		 
     }
	
    
	  if(document.getElementById("email").value=="")
     {
              document.getElementById("email").disabled = true;
         document.getElementById("email").style.borderColor = 'yellow';        
          document.getElementById("email").disabled = false;
         document.getElementById("email_error").innerHTML = "This field must not be left empty";    
         flag++;// return false;
     }
	 if(document.getElementById("email").value!="")
     {    
	    
         //var re = /\S+@\S+\.\S+/;
		 /**        The official standard  known as RFC 2822 which I came across online **/
		 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          if(!re.test(email.value))
		   {  document.getElementById("email").disabled = true;
         document.getElementById("email").style.borderColor = 'yellow';        
          document.getElementById("email").disabled = false;
         document.getElementById("email_error").innerHTML = "Invalid e-mail id";    
         flag++;// return false;
		 }
		 
     }
     if(pass_rep.value!=password.value)
     {
	document.getElementById("rep_pass").disabled = true;
         document.getElementById("rep_pass").style.borderColor = 'yellow';        
          document.getElementById("rep_pass").disabled = false;
         document.getElementById("rep_pass_error").innerHTML = "The passwords donot match!";    
         flag++;// return false;
     } 
     if(pass_rep.value=="")
     {
       document.getElementById("rep_pass").disabled = true;
         document.getElementById("rep_pass").style.borderColor = 'yellow';        
          document.getElementById("rep_pass").disabled = false;
         document.getElementById("rep_pass_error").innerHTML = "This field must not be left empty";    
         flag++;// return false;
     }
     
     if(flag!=0)
      return false;
     else
      return true;
    }
