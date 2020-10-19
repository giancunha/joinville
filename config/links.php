<?php
$GLOBALS['links'] = [
    'css' => [],
    'js'  => [],
    'addcss' => [
        'styleDefault',
        'styleInverse',
        'morris',
        'fontRoboto',
        'jqueryGritter',
        'bootstrapDatetimepicker',
        'jqueryDatatables',
        'bootstrapWysihtml5',
        'prettyPhoto',
        'style'
    ],
    'addjs' => [
        'jquery',
        'jquery-ui',
        'jquery-migrate',
        'bootstrap',
        'modernizr',
        'jquery-sparkline',
        'toggles',
        'retina',
        'jquery-cookies',
        'select2',
        'jquery-gritter',
        'jquery-datatables',
        'wysihtml5',
        'bootstrap-wysihtml5',
        'ckeditor',
        'ckeditor-jquery',
        'dataTables-fnFilterClear',
        'jquery-maskedinput',
        'maskmoney',
        'clipboard',
        'jquery-prettyPhoto',
        'custom',
        'bootstrap-datetimepicker',
        'jsPai',
        'scripts',
        'jquery-flot',
        'jquery-flot-resize',
        'jquery-flot-pie',
        'jquery-flot-tooltip',
        'morris',
        'raphael'
    ]
];
//links CSS
$GLOBALS['links']['css']['styleDefault'] = URLADM."/assets/css/style.default.css";
$GLOBALS['links']['css']['styleInverse'] = URLADM."/assets/css/style.inverse.css";
$GLOBALS['links']['css']['morris'] = URLADM."/assets/css/morris.css";
$GLOBALS['links']['css']['fontRoboto'] = URLADM."/assets/css/font.roboto.css";
$GLOBALS['links']['css']['jqueryGritter'] = URLADM."/assets/css/jquery.gritter.css";
$GLOBALS['links']['css']['bootstrapDatetimepicker'] = URLADM."/assets/css/bootstrap-datetimepicker.min.css";
$GLOBALS['links']['css']['jqueryDatatables'] = URLADM."/assets/css/jquery.datatables.css";
$GLOBALS['links']['css']['bootstrapWysihtml5'] = URLADM."/assets/css/bootstrap-wysihtml5.css";
$GLOBALS['links']['css']['prettyPhoto'] = URLADM."/assets/css/prettyPhoto.css";
$GLOBALS['links']['css']['style'] = URLADM."/assets/Style.css";

//links javascript
$GLOBALS['links']['js']['jquery'] = URLADM . "/assets/js/jquery-1.11.1.min.js";
$GLOBALS['links']['js']['jquery-ui'] = URLADM . "/assets/js/jquery-ui-1.10.3.min.js";
$GLOBALS['links']['js']['jquery-migrate'] = URLADM . "/assets/js/jquery-migrate-1.2.1.min.js";
$GLOBALS['links']['js']['bootstrap'] = URLADM . "/assets/js/bootstrap.min.js";
$GLOBALS['links']['js']['modernizr'] = URLADM . "/assets/js/modernizr.min.js";
$GLOBALS['links']['js']['jquery-sparkline'] = URLADM . "/assets/js/jquery.sparkline.min.js";
$GLOBALS['links']['js']['toggles'] = URLADM . "/assets/js/toggles.min.js";
$GLOBALS['links']['js']['retina'] = URLADM . "/assets/js/retina.min.js";
$GLOBALS['links']['js']['jquery-cookies'] = URLADM . "/assets/js/jquery.cookies.js";
$GLOBALS['links']['js']['select2'] = URLADM . "/assets/js/select2.min.js";
$GLOBALS['links']['js']['jquery-gritter'] = URLADM . "/assets/js/jquery.gritter.min.js";
$GLOBALS['links']['js']['jquery-datatables'] = URLADM . "/assets/js/jquery.datatables.min.js";
$GLOBALS['links']['js']['wysihtml5'] = URLADM . "/assets/js/wysihtml5-0.3.0.min.js";
$GLOBALS['links']['js']['bootstrap-wysihtml5'] = URLADM . "/assets/js/bootstrap-wysihtml5.js";
$GLOBALS['links']['js']['ckeditor'] = URLADM . "/assets/js/ckeditor/ckeditor.js";
$GLOBALS['links']['js']['ckeditor-jquery'] = URLADM . "/assets/js/ckeditor/adapters/jquery.js";
$GLOBALS['links']['js']['dataTables-fnFilterClear'] = URLADM . "/assets/js/dataTables/fnFilterClear.js";
$GLOBALS['links']['js']['jquery-maskedinput'] = URLADM . "/plugins/jquery.maskedinput.min.js";
$GLOBALS['links']['js']['maskmoney'] = URLADM . "/plugins/maskmoney/jquery.maskMoney.js";
$GLOBALS['links']['js']['clipboard'] = URLADM . "/plugins/clipboard.min.js";
$GLOBALS['links']['js']['jquery-prettyPhoto'] = URLADM . "/assets/js/jquery.prettyPhoto.js";
$GLOBALS['links']['js']['custom'] = URLADM . "/assets/js/custom.js";
$GLOBALS['links']['js']['bootstrap-datetimepicker'] = URLADM . "/assets/js/bootstrap-datetimepicker.min.js";
//JS DINÂMICO
$arquivo = $gets['0'];
if(is_file('js/' . $arquivo . '.js')){
    $GLOBALS['links']['js']['jsPai'] = URLADM . "/js/$arquivo.js";
} else {
    $GLOBALS['links']['js']['jsPai'] = URLADM . "/js/index.js";
}
$GLOBALS['links']['js']['scripts'] = URLADM . "/assets/Scripts.js";
$GLOBALS['links']['js']['jquery-flot'] = URLADM . "/assets/js/flot/jquery.flot.min.js";
$GLOBALS['links']['js']['jquery-flot-resize'] = URLADM . "/assets/js/flot/jquery.flot.resize.min.js";
$GLOBALS['links']['js']['jquery-flot-pie'] = URLADM . "/assets/js/flot/jquery.flot.pie.min.js";
$GLOBALS['links']['js']['jquery-flot-tooltip'] = URLADM . "/assets/js/flot/jquery.flot.tooltip.min.js";
$GLOBALS['links']['js']['morris'] = URLADM . "/assets/js/morris.min.js";
$GLOBALS['links']['js']['raphael'] = URLADM . "/assets/js/raphael-2.1.0.min.js";

$GLOBALS['links']['js']['vuejs'] = "https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js";
$GLOBALS['links']['js']['axios'] = "https://cdn.jsdelivr.net/npm/axios@0.18.0/dist/axios.min.js";
$GLOBALS['links']['js']['select2Vue'] = URLADM . "/assets/js/vueComponents/select2Vue.js";
