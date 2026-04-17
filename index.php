<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	mb_internal_encoding('UTF-8');
	
	function getRandomSymbols($j, $quantity, $requiredSymbolsArr) {
		$c = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'v', 'z'];
		$v = ['a', 'e', 'i', 'o', 'u', 'y'];
        $symbols = [];
        for ($i = $quantity; $i > 0; $i--, $j++) {
            if ($j % 2 !== 0) {
			    $symbols[] = $c[array_rand(array_diff($c, $requiredSymbolsArr))];
            } else {
                $symbols[] = $v[array_rand(array_diff($v, $requiredSymbolsArr))];
            }
        }
		return $symbols;
	}
	function getLogin($len, $symbols) {
        $requiredSymbolsArr = array_unique(mb_str_split($symbols, 1));
        $quantity = $len - count($requiredSymbolsArr);
        $randomSymbolsArr = getRandomSymbols(mt_rand(0, 1), $quantity, $requiredSymbolsArr);
        for ($i = count($requiredSymbolsArr); $i > 0; $i--) {
            array_splice($randomSymbolsArr, array_rand($randomSymbolsArr ? $randomSymbolsArr : $requiredSymbolsArr), 0, array_splice($requiredSymbolsArr, array_rand($requiredSymbolsArr), 1));
        }
        return implode('', $randomSymbolsArr);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="login.css?v=2">
</head>
<body>
    <main class="window">
        <h1 class="question">Какой длины должен быть логин?</h1>
        <form class="form" action="" method="POST">
            <p class="option">
                <label>Количество символов</label>
                <select class="select" name="len">
                    <?php for ($i = 4; $i <= 12; $i++ ): ?><option value="<?=$i?>" <?php if (isset($_POST['len']) and $_POST['len'] == $i){echo 'selected';}?>><?=$i?></option><?php endfor; ?>
                </select>
            </p>
            <p class="option">
                <label>Обязательные символы</label>
                <input class="input" name="symbols" maxlength="<?=$i?>" value="<?php if (isset($_POST['symbols'])) {echo $_POST['symbols'];} else {echo '';} ?>">
            </p>
            <input class="button" type="submit">
		</form>
		<p class="result"><?php
            if (isset($_POST['len'])) {
                echo getLogin($_POST['len'], $_POST['symbols']);
            }
        ?></p>
    </main>
</body>
</html>