<?php

/**
 * Render tabular statistics including total and sorted by level of difficulty.
 *
 * @param	string	$text	Custom field name.
 * @return	string	HTML
 */
 
	function ras_level_stats($atts) {
		extract(lAtts(array(
			'fieldname' => '',
		), $atts));

	$totals = new AggregateByName($fieldname);
	$stats = $totals->articlesData("Excerpt,".$totals->field."");
	$sum = $totals->sumName();
 
				$es = 0;
				$mod = 0;
				$diff = 0;

			foreach($stats as $elem)
				{
				$elem['Excerpt'] = strtolower($elem['Excerpt']);

				switch($elem['Excerpt'])
					{
					case 'easy' : $es += $elem[$totals->field]; break;
					case 'moderate' : $mod += $elem[$totals->field]; break;
					case 'difficult' : $diff += $elem[$totals->field]; break;
					}
				}

		$rs =	'<table cellpadding="4" cellspacing="10" border="1" style="font-size:11px;"><tr><td>Easy</td><td>'.$es.'</td></tr>'.n.
				'<tr><td>Moderate</td><td> '.$mod.'</td></tr>'.n.
				'<tr><td>Difficult</td><td>'.$diff.'</td></tr>'.n.
				'<tr><td>Total</td><td>'.$sum.'</td></tr></table>';
	return $rs;
}

?>