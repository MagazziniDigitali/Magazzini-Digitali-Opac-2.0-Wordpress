<?php

function md_Search_Facet($facet) {
	echo '<div class="tecaSearchFacet">';
	echo '<form id="tecaSearchFacet" name="tecaSearchFacet">';
	echo '  <fieldset class="tecaSearchFacet">';
	echo $facet;
	echo '  </fieldset>';
	echo '</form>';
	echo '</div>';
}
?>
