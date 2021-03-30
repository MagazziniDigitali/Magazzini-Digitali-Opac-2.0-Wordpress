<?php
include_once (MD_PLUGIN_PATH . 'tools/solr/MDSolr.php');
include 'searchFacet.php';

function md_Search_Result() {
	$mdSolr = new MDSolr ();
	$result = $mdSolr->searchSolr ( $mdSolr->getKeyword() );

	md_Search($mdSolr);
	if ($result!= ''){
		md_Search_Facet($mdSolr->getFacet());
		
		echo '<div class="tecaSearchResult">';
		md_Search_Result_Navigator ($mdSolr->getStart(), $mdSolr->getEnd(), $mdSolr->getNumFound(), $mdSolr->getQTime(), $mdSolr->getIndietro(), $mdSolr->getAvanti(),
				$mdSolr->getFine(), $mdSolr->getRecPag(), MD_PLUGIN_URL);
		echo ($result);
		md_Search_Result_Navigator ($mdSolr->getStart(), $mdSolr->getEnd(), $mdSolr->getNumFound(), $mdSolr->getQTime(), $mdSolr->getIndietro(), $mdSolr->getAvanti(),
				$mdSolr->getFine(), $mdSolr->getRecPag(), MD_PLUGIN_URL);
		echo '</div>';
	}
}

function md_Search($mdSolr){
//	echo '<a href="javascript:history.back()">torna indietro</a>';
	if (isset ( $_REQUEST ['RA_Fields'] )) {
               $raFields = $_REQUEST ['RA_Fields'];
               $xml = simplexml_load_string(hex2bin($raFields));
	}
?>
<div class="tecaSearchForm">
  <form action="<?php echo (esc_url( $_SERVER['REQUEST_URI'] )) ?>" method="GET" id="tecaSearchForm" name="tecaSearchForm">
    <fieldset class="tecaSearchForm">
      <input type="hidden" name="valueSolr" value="<?php echo ($mdSolr->getValueSolr()) ?>" />
      <input type="hidden" name="keySolr" value="<?php echo ($mdSolr->getKeySolr()) ?>" />
      <input type="hidden" name="qStart" value="<?php echo ($mdSolr->getQStart()) ?>" />
      <input type="hidden" name="facetQuery" value="" />
      <input type="hidden" name="RA_Fields" value="" />
      <input type="hidden" name="recPag" value="<?php echo ($mdSolr->getRecPag()) ?>" />
      <legend class="primary-navigation">Cerca nel Catalogo:</legend>
      <div class="campiRicerca">
        <input class="defaultText" title="Ricerca per parola:" type="text" name="keyword" id="keyword" value=""/>
        <a onclick="showHidden('ricercaAvanzata');">Ricerca Avanzata</a>
<?php
	if (isset($raFields) && $raFields!=''){
        	echo('<div id="ricercaAvanzata" style="display: block;">');
	} else {
        	echo('<div id="ricercaAvanzata" style="display: none;">');
	}
?>
          <em>Operatore</em>
          <select id="RA_operatore">
            <option value="and"> AND</option>
            <option value="or"> OR</option>
            <option value="not"> NOT</option>
          </select><br/>
          <em>Aggiungi campo</em><br/>
          <select id="RA_campoName">
            <option value=""></option>
            <optgroup label="Scheda Agente">
              <option value="agentName">Nome Agente</option>
	    </optgroup>
            <optgroup label="Scheda Contenitore">
              <option value="provenienzaOggetto">Provenienza Oggetto</option>
              <option value="objectIdentifier">Identificatore Oggetto</option>
              <option value="actualFileName">Nome File Attuale</option>
              <option value="sha1">Codice Sha1</option>
              <option value="size">Dimensione in Byte</option>
              <option value="mimeType">Mime Type</option>
              <option value="promon">Codice Promon</option>
              <option value="originaFileName">Nome del File Originale</option>
            </optgroup>
            <optgroup label="Scheda Evento">
              <option value="eventID">Identificativo Evento</option>
              <option value="eventType">Tipo di Evento</option>
              <option value="eventOutCome">Evento Out Come</option>
              <option value="agentDepositante">Codice Agente Destinatario</option>
            </optgroup>
            <optgroup label="Scheda Bibliografica">
              <option value="tipoDocumento">Tipo Documento</option>
              <option value="bid">Bid dell'opera</option>
              <option value="bni">Codice Bni dell'opera</option>
              <option value="titolo">Titolo dell'opera</option>
              <option value="autore">Autore dell'opera</option>
              <option value="pubblicazione">Pubblicazione dell'opera</option>
              <option value="soggetto">Soggetto dell'opera</option>
              <option value="descrizione">Descrizione dell'opera</option>
              <option value="contributo">Contributo dell'opera</option>
              <option value="tiporisorsa">Tipo Risorsa dell'opera</option>
              <option value="formato">Formato dell'opera</option>
              <option value="fonte">Fonte dell'opera</option>
              <option value="lingua">Lingua dell'opera</option>
              <option value="relazione">Relazione dell'opera</option>
              <option value="copertura">Copertura dell'opera</option>
              <option value="gestionediritti">Diritti dell'opera</option>
              <optgroup label="Scheda Bibliografica - Gestionale">
                <option value="biblioteca">Biblioteca dell'opera</option>
                <option value="inventario">Inventario dell'opera</option>
                <option value="collocazione">Colocazione dell'opera</option>
              </optgroup>
              <optgroup label="Scheda Bibliografica - Oggetto">
                <option value="piecegr">Piece GR dell'opera</option>
                <option value="piecedt">Piece DT dell'opera</option>
                <option value="piecein">Piece IN dell'opera</option>
              </optgroup>
            </optgroup>
          </select>
          <input type="text" id="RA_campoValue">
          <br/>
          data da:
          <input type="text" id="RA_dataDa" size="10" maxLength="10">
          a:
          <input type="text" id="RA_dataA" size="10" maxLength="10">
          depositato da:
          <input type="text" id="RA_depositatoDa" size="10" maxLength="10" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd/mm/yyyy"> (dd/mm/yyyy)
          a:
          <input type="text" id="RA_depositatoA" size="10" maxLength="10" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd/mm/yyyy"> (dd/mm/yyyy)
          <input type="button" value="ADD" onclick="addRicercaAvanzata();"/>
          <br/>
          <br>
 <select data-placeholder="Lista filtri applicati" class="chosen-select" multiple tabindex="4" id="RA_filtri">
<?php
	if (isset($raFields)){
		for ($x =0; $x<count($xml->RA_filtri); ++$x){
			echo('<option value="');
			echo(htmlentities($xml->RA_filtri[$x]->value, ENT_QUOTES));
			echo('"');
			if ($xml->RA_filtri[$x]->selected=='true'){
				echo(' selected="selected"');	
			}
			echo('>');
			echo($xml->RA_filtri[$x]->text);
			echo('</option>');
		}
	}
?>
</select>
<br/>
<table width="100%">
  <tr>
    <th>Oggetto</th>
    <th>Agente</th>
    <th>Contenitore</th>
    <th>Evento</th>
    <th>File</th>
  </tr>
  <tr>
    <td>
<input type="checkbox" id="oggettoRegistro"<?php if(isset($xml->RA_esclusioni->oggettoRegistro)){echo(' checked="checked"');}?>/> Registro<br/>
<input type="checkbox" id="oggettoDiritti"<?php if(isset($xml->RA_esclusioni->oggettoDiritti)){echo(' checked="checked"');}?>/> Diritti<br/>
    </td>
    <td>
      <input type="checkbox" id="agentSoftware"<?php if(isset($xml->RA_esclusioni->agentSoftware)){echo(' checked="checked"');}?>/> Software
    </td>
    <td>
      <input type="checkbox" id="contenitoreAdmtape"<?php if(isset($xml->RA_esclusioni->contenitoreAdmtape)){echo(' checked="checked"');}?>/> Admtape
    </td>
    <td>
      <input type="checkbox" id="eventSend"<?php if(isset($xml->RA_esclusioni->eventSend)){echo(' checked="checked"');}?>/> Send<br/>
      <input type="checkbox" id="eventDecompress"<?php if(isset($xml->RA_esclusioni->eventDecompress)){echo(' checked="checked"');}?>/> Decompress<br/>
<input type="checkbox" id="eventValidation"<?php if(isset($xml->RA_esclusioni->eventValidation)){echo(' checked="checked"');}?>/> Validation<br/>
<input type="checkbox" id="eventCopyPremis"<?php if(isset($xml->RA_esclusioni->eventCopyPremis)){echo(' checked="checked"');}?>/> CopyPremis<br/>
<input type="checkbox" id="eventMoveFile"<?php if(isset($xml->RA_esclusioni->eventMoveFile)){echo(' checked="checked"');}?>/> MoveFile<br/>
<input type="checkbox" id="eventGeoReplica"<?php if(isset($xml->RA_esclusioni->eventGeoReplica)){echo(' checked="checked"');}?>/> GeoReplica<br/>
<input type="checkbox" id="eventIndex"<?php if(isset($xml->RA_esclusioni->eventIndex)){echo(' checked="checked"');}?>/> Index
    </td>
    <td>
<input type="checkbox" id="fileMd5"<?php if(isset($xml->RA_esclusioni->fileMd5)){echo(' checked="checked"');}?>/> File Md5<br/>
<input type="checkbox" id="fileHtml"<?php if(isset($xml->RA_esclusioni->fileHtml)){echo(' checked="checked"');}?>/> File Html<br/>
<input type="checkbox" id="fileJp2"<?php if(isset($xml->RA_esclusioni->fileJp2)){echo(' checked="checked"');}?>/> File Jp2<br/>
<input type="checkbox" id="fileJpeg"<?php if(isset($xml->RA_esclusioni->fileJpeg)){echo(' checked="checked"');}?>/> File Jpeg<br/>
<input type="checkbox" id="fileTif"<?php if(isset($xml->RA_esclusioni->fileTif)){echo(' checked="checked"');}?>/> File Tif<br/>
<input type="checkbox" id="filePremis"<?php if(isset($xml->RA_esclusioni->filePremis)){echo(' checked="checked"');}?>/> File Premis<br/>
<input type="checkbox" id="fileJson"<?php if(isset($xml->RA_esclusioni->fileJson)){echo(' checked="checked"');}?>/> File Json<br/>
<input type="checkbox" id="fileManifest"<?php if(isset($xml->RA_esclusioni->fileManifest)){echo(' checked="checked"');}?>/> File Manifest<br/>
    </td>
  </tr>
</table>
<!--
          <div class="chosen-container chosen-container-multi chosen-container-active" title="" style="width: 100%;">
            <ul class="chosen-choices">
              <li class="search-choice"><span>United States</span><a class="search-choice-close" data-option-array-index="1"></a></li>
              <li class="search-choice"><span>Aland Islands</span><a class="search-choice-close" data-option-array-index="4"></a></li>
              <li class="search-choice"><span>+Ed:"Casa" </span><a class="search-choice-close" data-option-array-index="4"></a></li>
            </ul>
          </div>
-->
        </div>
      </div>
      <div class="campiBottoni">
        <input type="button" value="Cerca" onclick="cerca(0);"/>
      </div>
 <script type="text/javascript">
  var keyword = "<?php echo ($mdSolr->getKeyword()) ?>";
  document.getElementById("keyword").value = keyword;
 </script>
    </fieldset>
  </form>
</div>
<?php
	}

function md_Search_Result_Navigator($start, $end, $numFound, $QTime, $indietro, $avanti, $fine, $recPag, $baseurl){
	echo '<table class="tecaSearchNavigator">';
	echo '  <tbody>'; 
	echo '    <tr>';
	echo '      <td class="lStatus">';
	echo '        Record: ' . $start . '-' . $end . '/' . $numFound . ' Tempo: ' . $QTime;
	echo '      </td>';
	echo '      <td class="navigator">';
	if ($indietro > -1) {
		 echo '        <a href="" onclick="cerca(0);return false;">';
	}
	echo '        <img src="' . $baseurl . '/images/navigator/start.ico" class="gwt-Image" style="width: 20px; height: 20px;" alt="Inizio" title="Inizio">';
	if ($indietro > -1) {
		echo '        </a>';
	}
	echo '      </td>';

	echo '      <td class="navigator">';
	if ($indietro > -1) {
		echo '        <a href="" onclick="cerca(' . $indietro . ');return false;">';
	}
	echo '        <img src="' . $baseurl . '/images/navigator/left.ico" class="gwt-Image" style="width: 20px; height: 20px;" alt="Indietro" title="Indietro">';
	if ($indietro > -1) {
		echo '        </a>';
	}
	echo '      </td>';

	echo '      <td class="navigator">';
	if ($avanti > - 1) {
		echo '        <a href="" onclick="cerca(' . $avanti . ');return false;">';
	}
	echo '        <img src="' . $baseurl . '/images/navigator/right.ico" class="gwt-Image" style="width: 20px; height: 20px;" alt="Avanti" title="Avanti">';
	if ($avanti > - 1) {
		echo '        </a>';
	}
	echo '      </td>';

	echo '      <td class="navigator">';
	if ($avanti > - 1) {
		echo '        <a href="" onclick="cerca(' . $fine . ');return false;">';
	}
	echo '        <img src="' . $baseurl . '/images/navigator/stop.ico" class="gwt-Image" style="width: 20px; height: 20px;" alt="Fine" title="Fine">';
	if ($avanti > - 1) {
		echo '        </a>';
	}
	echo '      </td>';

	echo '      <td class="lRecPag">';
	echo '        Record per pagina :';
	echo '      </td>';
	echo '      <td class="iRecPag">';
	echo '        <input type="text" title="Record per pagina" value="' . $recPag . '" onkeypress="tecaRecPagKeyPress(event, this);">';
	echo '      </td>';
	echo '    </tr>';
	echo '  </tbody>';
	echo '</table>';
}

?>
