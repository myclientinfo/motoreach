<?php
include '../include.php';

$GLOBALS['make_models'] = Site::getMakeModel();
$GLOBALS['model_badges'] = Site::getModelBadge();
$GLOBALS['model_series'] = Site::getModelSeries();

header("Content-type: text/javascript");
?>
var make_models = <?php echo json_encode($GLOBALS['make_models']) ?>;
var model_badges = <?php echo json_encode($GLOBALS['model_badges']) ?>;
var model_series = <?php echo json_encode($GLOBALS['model_series']) ?>;