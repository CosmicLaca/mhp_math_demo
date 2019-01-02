<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Monty Hall Problem</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>

<?PHP

    /*
     * Sorry, this is a spaghetty code for testing only.
     * Please check my other projects for MVC codes or ask my CV.
     */

	session_start();

	$Passed = 0;
	$Win = 0;
	$Lost = 0;
	$Win_ch = 0;
	$Win_ch1 = 0;
	$Win_ch2 = 0;
	$Win_ch3 = 0;
	$Lost_ch = 0;
	$LostRND = 0;
	$WinRND = 0;
	$N = 0;

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['TestsNum'])) {

		if ($_POST['TestsNum'] > 500) {
			echo '<h1>Lófaszt!</h1>';
			exit;
		}

		echo '<h1>Monty Hall Problem demo:</h1>';

		echo '<table border=1 cellpadding=2 cellspacing=0>
		<tr>
		<th>#</th>
		<th>ajtó 1</th>
		<th>ajtó 2</th>
		<th>ajtó 3</th>
		<th>Random választott</th>
		<th>Kinyitották</th>
		<th>Ha vált</th>
		<th>Ha nem vált</th>
		<th>Ha random vált</th>
		<th>Fix 1 / Kinyit</th>
		<th>Fix 2 / Kinyit</th>
		<th>Fix 3 / Kinyit</th>
		</tr>';


		for ($i = 1; $i <= $_POST['TestsNum']; $i++) {
			$Basearray = array('Kecske', 'Kecske', 'Autó');
			shuffle($Basearray);
			$FixedArray = $Basearray;

			$selected = array_rand($Basearray);
			if ($Basearray[$selected] == 'Autó') {
				$color = '00ff00';
				$Passed++;
			} else {
				$color = 'ff6666';
			}

			$ajto1 = $Basearray[0];
			$ajto2 = $Basearray[1];
			$ajto3 = $Basearray[2];

			// sorszam es 3 ajto random + random valasztas
			echo '<tr>
			<td>' . ++$N . '</rd>
			<td>' . $Basearray[0] . '</td>
			<td>' . $Basearray[1] . '</td>
			<td>' . $Basearray[2] . '</td>
			<td style="background:#' . $color . '">' . ($selected + 1) . ': ' . $Basearray[$selected] . '</td>';
			$SelectedState = $Basearray[$selected];

			unset($Basearray[$selected]);

			// Megmutatjak az egyik kecsket
			echo '<td>';

			$Opened = array_rand($Basearray);

			if ($Basearray[$Opened] == 'Autó') {
				unset($Basearray[$Opened]);
				echo ((array_keys($Basearray)[0]) + 1) . ': ' . $Basearray[array_keys($Basearray)[0]];
			} else {
				echo ($Opened + 1) . ': ' . $Basearray[$Opened];
			}

			// ha valt
			if ($SelectedState == 'Autó') {
				echo '</td><td style="background:#ff6666"> - </td>';
				$Lost_ch++;
			} else {
				echo '<td style="background:#00ff00"> + </td>';
				$Win_ch++;
			}

			// ha nem valt
			if ($SelectedState == 'Autó') {
				echo '</td><td style="background:#00ff00"> + </td>';
				$Win++;
			} else {
				echo '<td style="background:#ff6666"> - </td>';
				$Lost++;
			}

			// random valt
			$RandCHG = array('Cserél', 'Marad');
			$RandCHG_IDX = array_rand($RandCHG);
			echo '<td>' . $RandCHG[$RandCHG_IDX] . ': ';
			if ($RandCHG[$RandCHG_IDX] == 'Cserél') {
				if ($SelectedState == 'Autó') { echo '<span style="background:#ff6666">Veszít</span>'; $LostRND++; } else { echo '<span style="background:#00ff00">Nyer</span>'; $WinRND++; }
			} else {
				if ($SelectedState == 'Autó') { echo '<span style="background:#00ff00">Nyer</span>'; $WinRND++; } else { echo '<span style="background:#ff6666">Veszít</span>'; $LostRND++; }
			}
			echo '</td>';

			// fix 1-2-3
			foreach ($FixedArray as $key => $value) {
				$Openfix = '';
				$LooserFix = array_keys($FixedArray, "Kecske");

				if ($value == 'Autó') {
					$color = '00ff00';
					$WinnerKeys[] = $key;
					$FixLos = array_rand($LooserFix);
					$Openfix = (($LooserFix[$FixLos]) + 1);
				} else {
					unset($LooserFix[$key]);
					$color = 'ff6666';
					$Openfix = ((array_values($LooserFix)[0]) + 1);
					if (array_values($LooserFix)[0] == $key) { $Openfix++; }
				}

				echo '<td style="background:#' . $color . '">' . $value . ' / ' . $Openfix . '</td>';

			}

			echo '</tr>';
		}

		$Winners = array_count_values($WinnerKeys);

		if (!isset($Winners[0])) { $Winners[0] = 0; }
		if (!isset($Winners[1])) { $Winners[1] = 0; }
		if (!isset($Winners[2])) { $Winners[2] = 0; }

		echo '<tr><td colspan=4><span style="background:#ff6666">Vesztett</span> / <span style="background:#00ff00">Nyert</span> - %:</td>

			 <td><span style="background:#ff6666">'
			 . ($_POST['TestsNum'] - $Passed) . '</span>/<span style="background:#00ff00">' . $Passed
			 . '</span> - ' . round(((100 / ($_POST['TestsNum'])) * $Passed), 2) . '%' .
			 '</td>

			 <td>-</td>

			 <td><span style="background:#ff6666">'
			. ($_POST['TestsNum'] - $Win_ch) . '</span>/<span style="background:#00ff00">' . $Win_ch
			. '</span> - ' . round(((100 / ($_POST['TestsNum'])) * $Win_ch), 2) . '%' .
			'</td>

			<td><span style="background:#ff6666">'
			. ($_POST['TestsNum'] - $Passed) . '</span>/<span style="background:#00ff00">' . $Passed
			. '</span> - ' . round(((100 / ($_POST['TestsNum'])) * $Passed), 2) . '%' .
			'</td>

			<td><span style="background:#ff6666">'
			. ($_POST['TestsNum'] - $WinRND) . '</span>/<span style="background:#00ff00">' . $WinRND
			. '</span> - ' . round(((100 / ($_POST['TestsNum'])) * $WinRND), 2) . '%' .
			'</td>

			<td><span style="background:#ff6666">'
			. ($_POST['TestsNum'] - $Winners[0]) . '</span>/<span style="background:#00ff00">' . $Winners[0]
			. '</span> - ' . round(((100 / ($_POST['TestsNum'])) * $Winners[0]), 2) . '%' .
			'</td>

			<td><span style="background:#ff6666">'
			. ($_POST['TestsNum'] - $Winners[1]) . '</span>/<span style="background:#00ff00">' . $Winners[1]
			. '</span> - ' . round(((100 / ($_POST['TestsNum'])) * $Winners[1]), 2) . '%' .
			'</td>

			<td><span style="background:#ff6666">'
			. ($_POST['TestsNum'] - $Winners[2]) . '</span>/<span style="background:#00ff00">' . $Winners[2]
			. '</span> - ' . round(((100 / ($_POST['TestsNum'])) * $Winners[2]), 2) . '%' .
			'</td>';

		echo '</tr></table>';

		$AllRounds = $_POST['TestsNum'];

		$CurrentWin = $Win_ch;
		$CurrentRNDWin = $WinRND;

		if (file_exists('./.RaceResult.php')) {
			$Prevcont = file_get_contents('./.RaceResult.php');
			$PrevRes = (explode('|', $Prevcont));
			$AllRounds = ($AllRounds + $PrevRes[0]);
			$Win_ch = ($Win_ch + $PrevRes[1]);
			file_put_contents('./.RaceResult.php', $AllRounds . '|' . $Win_ch);
		} else {
			file_put_contents('./.RaceResult.php', $AllRounds . '|' . $Win_ch);
		}

		if (file_exists('./.RaceResult_RND.php')) {
			$Prevcont = file_get_contents('./.RaceResult_RND.php');
			$PrevRes = (explode('|', $Prevcont));
			//$AllRounds = ($AllRounds + $PrevRes[0]);
			$WinRND = ($WinRND + $PrevRes[1]);
			file_put_contents('./.RaceResult_RND.php', $AllRounds . '|' . $WinRND);
		} else {
			file_put_contents('./.RaceResult_RND.php', $AllRounds . '|' . $WinRND);
		}

		echo 'Eddig összesen nyert ha mindig cserélt: ' . $Win_ch . ' alkalommal, játszott: ' . $AllRounds . ' alkalommal.
		<br>
		Ha váltott nyert: ' . round(((100 / $AllRounds) * $Win_ch), 2) . ' %-ban. Ha nem váltott volna: ' . (100 - round(((100 / $AllRounds) * $Win_ch), 2)) . ' %-ban nyer.<br>
		Ha mindig véletlenszerűen döntött, nyert: ' . $WinRND . ' alkalommal, ami: ' . round(((100 / $AllRounds) * $WinRND), 2) . ' %.<hr>';


		if (file_exists('./.RaceResult_1.php')) {
			$Prevcont = file_get_contents('./.RaceResult_1.php');
			$PrevRes = (explode('|', $Prevcont));
			$Win_ch1 = $Winners[0];
			$Win_ch1 = ($Win_ch1 + $PrevRes[1]);
			file_put_contents('./.RaceResult_1.php', $AllRounds . '|' . $Win_ch1);
		} else {
			$Win_ch1 = $Winners[0];
			file_put_contents('./.RaceResult_1.php', $AllRounds . '|' . $Win_ch1);
		}

		if (file_exists('./.RaceResult_2.php')) {
			$Prevcont = file_get_contents('./.RaceResult_2.php');
			$PrevRes = (explode('|', $Prevcont));
			$Win_ch2 = $Winners[1];
			$Win_ch2 = ($Win_ch2 + $PrevRes[1]);
			file_put_contents('./.RaceResult_2.php', $AllRounds . '|' . $Win_ch2);
		} else {
			$Win_ch2 = $Winners[1];
			file_put_contents('./.RaceResult_2.php', $AllRounds . '|' . $Win_ch2);
		}

		if (file_exists('./.RaceResult_3.php')) {
			$Prevcont = file_get_contents('./.RaceResult_3.php');
			$PrevRes = (explode('|', $Prevcont));
			$Win_ch3 = $Winners[2];
			$Win_ch3 = ($Win_ch3 + $PrevRes[1]);
			file_put_contents('./.RaceResult_3.php', $AllRounds . '|' . $Win_ch3);
		} else {
			$Win_ch3 = $Winners[2];
			file_put_contents('./.RaceResult_3.php', $AllRounds . '|' . $Win_ch3);
		}

		echo 'A fix 1-es ha mindig vált, akkor nyer: ' . (100 - round(((100 / $AllRounds) * $Win_ch1), 2)) . ' %-ban.<br>';
		echo 'A fix 2-es ha mindig vált, akkor nyer: ' . (100 - round(((100 / $AllRounds) * $Win_ch2), 2)) . ' %-ban.<br>';
		echo 'A fix 3-es ha mindig vált, akkor nyer: ' . (100 - round(((100 / $AllRounds) * $Win_ch3), 2)) . ' %-ban.<hr>';

		if (!isset($_SESSION['SumGame'])) {
			$_SESSION['SumGame'] = ($_POST['TestsNum']);
			$_SESSION['SumWin'] = ($CurrentWin);
			$_SESSION['SumRandWin'] = ($CurrentRNDWin);
		} else {
			$_SESSION['SumGame'] = (($_POST['TestsNum']) + ($_SESSION['SumGame']));
			$_SESSION['SumWin'] = (($CurrentWin) + ($_SESSION['SumWin']));
			$_SESSION['SumRandWin'] = (($CurrentRNDWin) + ($_SESSION['SumRandWin']));
		}

		echo 'Te ebben a játékban játszottál: ' . $_SESSION['SumGame'] . ' alkalommal, ha cseréltél nyertél ' . $_SESSION['SumWin'] . ' alkalommal.<br>';
		echo 'Ha mindig váltottál ez: ' . round(((100 / $_SESSION['SumGame']) * $_SESSION['SumWin']), 2) . ' % nyeremény.<br>';
		echo 'Ha mindig véletlenszerűen döntöttél ez: ' . round(((100 / $_SESSION['SumGame']) * $_SESSION['SumRandWin']), 2) . ' % nyeremény.';

		echo '<hr><h3>Nyomj refresh-t ha akarsz még egyet!</h3>';
		echo 'Ha nem, <a href="index.php">katt ide.</a>';

		return;
	}

?>


<form name="form1" method="post" action="index.php">
	Események száma (10...500):<br>
  <span id="sprytextfield1">
  <input name="TestsNum" type="text" id="TestsNum" value="10" size="10" maxlength="3">
  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span><span class="textfieldMinValueMsg">The entered value is less than the minimum required.</span><span class="textfieldMaxValueMsg">The entered value is greater than the maximum allowed.</span></span>
  <input type="submit" name="button" id="button" value="Nézzük">
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minChars:1, maxChars:3, minValue:10, maxValue:500});
</script>
</body>
</html>
