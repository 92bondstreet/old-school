function ShowTeeMan() {
    
    man = document.getElementById("model-man");
    woman = document.getElementById("model-woman");
	man.className = 'selected';      
   	woman.className = 'noselected';
	
	mants = document.getElementById("tshirt-man");
	womants = document.getElementById("tshirt-woman");
        mants.style.display = 'block';      
   	womants.style.display = 'none';
	
	mancart = document.getElementById("formArticle-man");
	womancart = document.getElementById("formArticle-woman");
	mancart.style.display = 'block';      
   	womancart.style.display = 'none';
}

function ShowTeeWoman() {
    
    man = document.getElementById("model-man");
    woman = document.getElementById("model-woman");
    man.className = 'noselected';      
   	woman.className = 'selected';      	  
	
	mants = document.getElementById("tshirt-man");
	womants = document.getElementById("tshirt-woman");
	mants.style.display = 'none';      
   	womants.style.display = 'block';
	
	mancart = document.getElementById("formArticle-man");
	womancart = document.getElementById("formArticle-woman");
	mancart.style.display = 'none';      
   	womancart.style.display = 'block';
}

function ShowCurrentFaq(FaqId) {
	 
   var alldiv = document.getElementsByTagName('div');
   
    
   for(var x=0; x<alldiv.length; x++) {
    		
       class_name = getClass(alldiv[x]);
        
       if(class_name == 'faq_design'){   
        	if (alldiv[x].id == FaqId){
		        	alldiv[x].style.display = 'block';
		        }
        	else
		        	alldiv[x].style.display = 'none';
		   }
    }
}

function getClass(current_element){

	if(current_element.getAttribute("class"))
		return current_element.getAttribute("class");
	else if(current_element.attributes['class'])
		return current_element.attributes['class'].nodeValue;
}

function AddToCart(current_form,adding)
{
  // init product/article value
 	document.forms[current_form].product.value = PRODUCT_Button;
 	document.forms[current_form].article.value = ARTICLE_Button;
 
	if(US_OR_EU_Button.name == 'EU')
  {
	  document.forms[current_form].action = 'https://universetee.spreadshirt.fr/shop/basket/addtobasket';
	  // change button apparence
  	document.forms[current_form].EU.value = adding;
  	document.forms[current_form].EU.style.cursor = 'progress';
  }
  else
 	if(US_OR_EU_Button.name == 'US')
  {
    document.forms[current_form].action = 'https://universetee.spreadshirt.com/shop/basket/addtobasket';
    // change button apparence
  	document.forms[current_form].US.value = adding;
  	document.forms[current_form].US.style.cursor = 'progress';
  }
  
  
  
  document.forms[current_form].submit();
 
  return true;
}

function showContact(LangId){

	var alldiv = document.getElementsByTagName('div');
  LangId = 'contact-'+LangId;
      
  for(var x=0; x<alldiv.length; x++) {
    		
       class_name = getClass(alldiv[x]);
        
       if(class_name == 'contact_lang'){   
        	if (alldiv[x].id == LangId){
		        	alldiv[x].style.display = 'block';
		        }
        	else
		        	alldiv[x].style.display = 'none';
		   }
    }
}