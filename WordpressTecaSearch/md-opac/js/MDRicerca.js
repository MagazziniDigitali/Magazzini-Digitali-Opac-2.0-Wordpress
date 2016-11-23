/**
 * 
 */
function tecaRecPagKeyPress(event, campo){
	var chCode = event.keyCode;
	if (chCode==13 ||
			chCode==10){
		cerca(0, campo.value);
//        var tecaSearchForm = document.getElementById("tecaSearchForm");
//        tecaSearchForm.elements["recPag"].value = campo.value;
//        tecaSearchForm.elements["qStart"].value = 0;
//        document.forms.tecaSearchForm.submit();
	}
}

//function changePage(qStart){
//    var tecaSearchForm = document.getElementById("tecaSearchForm");
//    tecaSearchForm.elements["qStart"].value = qStart;
//    document.forms.tecaSearchForm.submit();
//}

function cerca(qStart, recPag){
    var x = document.getElementById("tecaSearchFacet");
    var tecaSearchForm = document.getElementById("tecaSearchForm");
    var text = "";
    var i;
    if (x != undefined){
        for (i = 0; i < x.length ;i++) {
            if (x.elements[i].type=='checkbox'){
              if (x.elements[i].checked){
                if (text != ''){
                  text += " ";
                }
                if (x.elements[i].name=='soggettoConservatore'){
                	if (x.elements[i].value=='non_identificabile'){
                        text += "+"+x.elements[i].name+":\"non identificabile\"";
                	} else {
                        text += "+"+x.elements[i].name+":\""+x.elements[i].value + "\"";
                	}
                }else if (x.elements[i].name=='subFondo'){
                	if (x.elements[i].value=='I_Serie_Carte_Patrimoniali'){
                        text += "+"+x.elements[i].name+":\"Serie_Carte_Patrimoniali\"";
                	} else {
                        text += "+"+x.elements[i].name+":\""+x.elements[i].value + "\"";
                	}
                } else {
                    text += "+"+x.elements[i].name+":\""+x.elements[i].value + "\"";
                }
              }
            }
        }
	text = text.replace(new RegExp('%22','g'),'"');
        tecaSearchForm.elements["facetQuery"].value = text;
    }
    tecaSearchForm.elements["qStart"].value = qStart;
    if (recPag != undefined){
    	tecaSearchForm.elements["recPag"].value = recPag;
    }
    document.forms.tecaSearchForm.submit();
}

function showSchedaByBid(id){
        var currentLocation = window.location;
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        currentLocation.pathname+
                        '?view=show&bid='+
                        id;
        window.location = url;
}

function showScheda(id){
        var currentLocation = window.location;
/*
        var pos = currentLocation.pathname.indexOf('index.php');
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        '/'+
                        currentLocation.pathname.substring(0,pos)+
                        'index.php?option=com_tecaricerca&view=show&myId='+
                        id;
*/
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        currentLocation.pathname+
                        '?view=show&myId='+
                        id;
        window.location = url;
}

function findTeca(key, value){
        var currentLocation = window.location;
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        currentLocation.pathname+
                        '?view=search&keySolr='+key+'&valueSolr='+
                        value;
        window.location = url;

}

function showImg(id){
  var currentLocation = window.location;

  var url = currentLocation.protocol+
                '//'+
                currentLocation.hostname+
                ':'+
                currentLocation.port+
                currentLocation.pathname+
                '?option=com_tecaviewer&view=showimg&myId='+id;
  window.location = url;
}

function showImgPopup(id){
  var currentLocation = window.location;

  var url = currentLocation.protocol+
                '//'+
                currentLocation.hostname+
                ':'+
                currentLocation.port+
                currentLocation.pathname+
                '?option=com_tecaviewer&view=showimg&myId='+id;
//  window.location = url;
  var popup_window=window.open(url, '_blank');
  try 
  {
    popup_window.focus();   
  } catch (e) {
    alert("!!! Attenzione !!! il vostro browser non permette l'apertura di Pop-up");
  }
}

function showOgettiDigitaliId(soggettoConservatoreKey, fondoKey, subFondoKey, subFondo2Key){
  var currentLocation = window.location;
  var url = "";

  url = currentLocation.protocol+'//'+currentLocation.hostname+':'+currentLocation.port+currentLocation.pathname;
  url += '?valueSolr=';
  url += '&keySolr=';
  url += '&qStart=0';
  url += '&facetQuery=%2BsoggettoConservatoreKey_fc%3A%22'+soggettoConservatoreKey+'%22';
  if (fondoKey != undefined){
    url += '+%2BfondoKey_fc%3A%22'+fondoKey.replace(new RegExp(soggettoConservatoreKey+'.','g'),'')+'%22';
  }
  if (subFondoKey!=undefined){
    url += '+%2BsubFondoKey_fc%3A%22'+subFondoKey.replace(new RegExp(soggettoConservatoreKey+'.'+fondoKey+'.','g'),'')+'%22';
  }
  if (subFondo2Key!=undefined){
    url += '+%2BsubFondo2Key_fc%3A%22'+subFondo2Key+'%22';
  }
  url += '&recPag=10';
  url += '&keyword=';
  window.location = url;
}

function showOgettiDigitali(soggettoConservatore, fondo){
  var currentLocation = window.location;

  var url = currentLocation.protocol+
                '//'+
                currentLocation.hostname+
                ':'+
                currentLocation.port+
                currentLocation.pathname+
                '?valueSolr=&keySolr=&qStart=0&facetQuery=%2BsoggettoConservatore_fc%3A%22'+soggettoConservatore.replace(new RegExp(' ','g'),'_')+
		'%22+%2Bfondo_fc%3A%22'+fondo.replace(new RegExp(' ','g'),'_')+
		'%22&recPag=10&keyword=Ricerca+per+parola%3A';
  window.location = url;
}
