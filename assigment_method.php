<?php
	function assigmentMethod($matrix)
	{
		$height = count($matrix);
		$width = count($matrix[0]);

		if ($height < $width) {
			for ($i=$height; $i<$width; $i++) {
				$matrix[$i] = array_fill(0, $width, INF);
			}
		} else if ($width < $height) {
			foreach ($matrix as $m) {
				for($i=0; $i<$height; $i++) {
					$m[$i] = INF;
				}
			}
		}

		$min_cost = array_fill(0, $height, 0);
		$v = array_fill(0, $height, 0);
		$index = array_fill(0, $height, -1);

		foreach (range(0, $height-1) as $i) {
			$links = array_fill(0, $height, -1);
			$row = array_fill(0, $height, INF);
			$flag = array_fill(0, $height, false);

			$I = $i;
			$J = -1;
			$j = 0;

			while (true) {
				$j = -1;

				foreach (range(0, $height-1) as $jj) {
					if ($flag[$jj] == false) {
						$res = $matrix[$I][$jj] - $min_cost[$I] - $v[$jj];

						if ($res < $row[$jj]) {
							$row[$jj] = $res;
							$links[$jj] = $J;
						}

						if ($j == -1 || $row[$jj] < $row[$j]) {
							$j = $jj;
						}
					}
				}

				$most_min = $row[$j];

				foreach (range(0, $width-1) as $jj) {					
					if ($flag[$jj] == true) {
						$min_cost[$index[$jj]] += $most_min;
						$v[$jj]-= $most_min;
					} else {
						$row[$jj] -= $most_min;
					}
				}

				$min_cost[$i] += $most_min;
				$flag[$j] = true;
				$J = $j;
				$I = $index[$j];

				if ($I == -1) {
					break;
				}
			}

			while (true) {
				if ($links[$j] != -1) {
					$index[$j] = $index[$links[$j]];
					$j = $links[$j];
				} else {
					break;
				}
			}

			$index[$j] = $i;
		}

		$hasil = array();
		foreach (range(0, $width-1) as $j) {
			$hasil[$j] = $index[$j];
		}

		return $hasil;
	}

	$nodes = array(
        array(1, 4, 6, 3),
        array(9, 7, 10, 9),
        array(4, 5, 11, 7),
        array(8, 7, 8, 5)

    );

	$hasil = assigmentMethod($nodes);
	$cost = 0;
	foreach ($hasil as $key => $h) {
	    $cost = $cost + $nodes[$key][$h];
	}
	echo "<pre>"; print_r($hasil); echo "</pre>";
	echo "<pre>"; print_r($cost); echo "</pre>";
?>