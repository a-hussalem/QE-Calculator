<?php
session_start();
$_SESSION['r'];


if (isset($_GET['a']) &&
    isset($_GET['b']) &&
    isset($_GET['c']) &&
    isset($_GET['r'])) {

    $a = $_GET['a'];
    $b = $_GET['b'];
    $c = $_GET['c'];
    $r = $_GET['r'];

    if (
        (!$a && (!isZero($a))) ||
        (!$b && (!isZero($b))) ||
        (!$c && (!isZero($c)))
    ) {

        $r = "All inputs are required";

    } elseif (
        !is_numeric($a) ||
        !is_numeric($b) ||
        !is_numeric($c)
    ) {
        $r = "Only numbers!";

    } elseif (
        isZero($a) ||
        isZero($b) ||
        isZero($c)
    ) {
        $r = "0!";
    }


}
//$r = "# All Inputs are required";

echo $r;


/**
 * @param $n
 * @return bool
 */
function isZero($n)
{
    return $n == 0 ? true : false;
}

/**
 * @param $a
 * @param $b
 * @param $c
 * @return bool
 */
function hasRealSol($a, $b, $c)
{
    $r = sqrt(pow($b, 2) - 4 * $a * $c);
    return $r >= 0 ? true : false;
}


/**
 * @param $a
 * @param $b
 * @param $c
 * @return int
 */
function numOfSol($a, $b, $c)
{
    $r = sqrt(pow($b, 2) - 4 * $a * $c);
    return $r == 0 ? 1 : 2;
}

/**
 * @param $a
 * @param $b
 * @param $c
 * @param $s
 * @return float|int
 */
function solveQE($a, $b, $c, $s)
{
    if ($s == '+') {
        return $r = (-$b + sqrt(pow($b, 2) - (4 * $a * $c))) / (2 * $a);
    }

    if ($s == '-') {
        return $r = (-$b - sqrt(pow($b, 2) - (4 * $a * $c))) / (2 * $a);
    }
}

/**
 * @param $a
 * @param $b
 * @param $c
 * @return mixed
 */
function rReturn($a, $b, $c)
{
    if (hasRealSol($a, $b, $c)) {

        if (numOfSol($a, $b, $c) == 2) {
            $r = solveQE($a, $b, $c, '+');
            $r .= ' | ' . solveQE($a, $b, $c, '-');
        } else {
            $r = solveQE($a, $b, $c, '+');
        }
    } else {
        $r = 'No real solution';
    }

    return $r;
}

// ----- # END OF PHP CODE

?>

<!-- # START OF HTML CODE -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>QE</title>
    <meta name="description" content="QE">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="font-family: Cairo, sans-serif;">
<header style="margin-bottom: 4rem;">
    <div class="container-fluid p-4" style="background-color: #000000;color: rgb(255,255,255);">
        <div class="row align-items-center">
            <div class="col-auto m-auto"><i class="fa fa-calculator logo" style="font-size: 42px;"></i></div>
            <div class="col">
                <h4 class="text-monospace m-0 app-name">Quadratic Equation Calculator<br></h4>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid">
    <form id="qeForm" method="get" action="<?php $_SERVER['PHP_SELF'] ?>" target="_self">
        <div class="form-row flex-grow-1 justify-content-center">
            <div class="col-4 col-md-2">
                <div class="form-group border rounded shadow-sm" style="background-color: #f7f7f7;padding: 24px;">
                    <label><strong>A</strong></label>
                    <input class="form-control form-control-sm p-2" type="text" name="a"
                           value="<?php isset($_GET['a']) ? $_GET['a'] : ''; ?>" autofocus="" inputmode="numeric"></div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group border rounded shadow-sm" style="background-color: #f7f7f7;padding: 24px;">
                    <label><strong>B</strong></label>
                    <input class="form-control form-control-sm p-2" type="text" name="b"
                           value="<?php isset($_GET['b']) ? $_GET['b'] : ''; ?>" inputmode="numeric"></div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group border rounded shadow-sm" style="background-color: #f7f7f7;padding: 24px;">
                    <label><strong>C</strong></label>
                    <input class="form-control form-control-sm p-2" type="text" name="c"
                           value="<?php isset($_GET['c']) ? $_GET['c'] : ''; ?>" minlength="1" inputmode="numeric">
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="form-group border rounded shadow-sm" style="background-color: #f0ffe9;padding: 24px;">
                    <label><strong>Solution</strong><br></label>
                    <input class="form-control form-control-lg" type="text" name="r"
                           readonly="" placeholder="# " value="<?php isset($r) ? $r : ''; ?>"
                           style="background-color: rgb(40,40,40);color: rgb(255,255,255);">
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-auto">
                            <button class="btn btn-success btn-sm shadow-sm" type="submit">SOLVE</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-danger btn-sm shadow-sm" type="button" onclick="resetQE()">RESET!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<script>
    function resetQE() {
        $("#qeForm :input").each(function () {
            $(this).val('');
        });
    }

</script>
</body>

</html>