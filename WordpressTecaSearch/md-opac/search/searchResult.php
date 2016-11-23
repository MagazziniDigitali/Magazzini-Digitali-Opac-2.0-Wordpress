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
	echo '<a href="javascript:history.back()">torna indietro</a>';
	echo '<div class="tecaSearchForm">';
	echo '  <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="GET" id="tecaSearchForm" name="tecaSearchForm">';
	echo '    <fieldset class="tecaSearchForm">';
	echo '      <input type="hidden" name="valueSolr" value="'.$mdSolr->getValueSolr().'" />';
	echo '      <input type="hidden" name="keySolr" value="'.$mdSolr->getKeySolr().'" />';
	echo '      <input type="hidden" name="qStart" value="'.$mdSolr->getQStart().'" />';
	echo '      <input type="hidden" name="facetQuery" value="" />';
	echo '      <input type="hidden" name="recPag" value="'.$mdSolr->getRecPag().'" />';
	echo '      <legend>Cerca nella Teca Digitale:</legend>';
	echo '      <input class="defaultText" title="Ricerca per parola:" type="text" name="keyword" value="'.$mdSolr->getKeyword().'"/>';
	echo '      <input type="button" value="Cerca" onclick="cerca(0);"/>';
	echo '    </fieldset>';
	echo '  </form>';
	echo '</div>';
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
