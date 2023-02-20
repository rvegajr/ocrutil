<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OCRUtil</title>
    <meta name="description" content="ArmyTee OCR Utility">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <base href="/"/>
    <style>
        const { console } = ChromeUtils.importESModule("resource://gre/modules/Console.sys.mjs");
    </style>
    <link href="<?=base_url("resources/packages/bootstrap-5.2.3-dist/css/bootstrap.min.css");?>" rel="stylesheet" title="style" media="all" />
    <link href="<?=base_url("resources/packages/bootstrap-icons-1.10.2/bootstrap-icons.css");?>" rel="stylesheet" title="style" media="all" />
    <meta name="theme-color" content="#7952b3">
    <script type="text/javascript" src="<?=base_url("resources/js/jquery-2.2.4.min.js");?>"></script>

    <script type="text/javascript" src="<?=base_url("resources/js/qtip/dist/jquery.qtip.min.js");?>"></script>
    <link href="<?=base_url("resources/js/qtip/dist/jquery.qtip.min.css");?>" rel="stylesheet" title="style" media="all" />

    <script type="text/ecmascript" src="<?=base_url("resources/packages/jqGrid-V5.7.0/js/trirand/jquery.jqGrid.min.js");?>"></script>
    <script type="text/ecmascript" src="<?=base_url("resources/packages/jqGrid-V5.7.0/js/trirand/i18n/grid.locale-en.js");?>"></script>
    <link href="<?=base_url("resources/packages/jqGrid-V5.7.0/css/jquery-ui.css");?>" rel="stylesheet" title="style" media="all" />
    <link href="<?=base_url("resources/packages/jqGrid-V5.7.0/css/trirand/ui.jqgrid-bootstrap5.css");?>" rel="stylesheet" title="style" media="all" />
    <link href="<?=base_url("resources/css/ui/smoothness/jquery-ui-1.8.21.custom.css");?>" rel="stylesheet" title="style" media="all" />

    <meta charset="utf-8" />
    <script type="text/javascript" src="<?=base_url("resources/js/jqgrid/plugins/jquery.tablednd.js");?>"></script>
    <script type="text/ecmascript" src="<?=base_url("resources/packages/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/ocrutil.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/custom.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/jquery.quicksearch.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/ui/jquery-ui-1.8.21.custom.min.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/jquery.treeview.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/jquery.cookie.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/superfish.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/live_search.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/jquery.tablesorter.min.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/tooltip.js");?>"></script>
    <script type="text/javascript" src="<?=base_url("resources/js/jquery.loadJSON.js");?>"></script>
    <link href="<?=base_url("resources/css/SmoothSkin.css");?>" rel="stylesheet" title="style" media="all" />

    <script>
        var a='<?=$is_admin?>';
        $.jgrid.defaults.styleUI = 'Bootstrap5';
        $.jgrid.defaults.iconSet = 'Bootstrap5';

        $(function(){
            var current = location.pathname;
            $('.nav-item-active').removeClass('nav-item-active');
            $('.nav li a').each(function(){
                var $this = $(this);
                console.log('current', $this.attr('href'));
                if (current.endsWith($this.attr('href'))) {
                    $this.addClass('nav-item-active');
                }
            });
        })
    </script>
</head>
<body>
<main>
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light nav-container">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none" >
            <i class="bi bi-suit-spade me-2"></i>
            <span class="fs-4">OCR Utility</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item  btn-toggle-nav ">
                <a href="/exception" class="nav-link link-dark nav-orderentry">
                    <i class="bi bi-pencil-square me-2"></i>
                    Exception Queue
                </a>
            </li>
            <li class="nav-item  btn-toggle-nav ">
                <a href="/documenthistory" class="nav-link link-dark nav-ordersearch">
                    <i class="bi bi-search me-2"></i>
                    Document History
                </a>
            </li>
            <li class="nav-item  btn-toggle-nav ">
                <a href="/archive" class="nav-link link-dark nav-reports">
                    <i class="bi bi-printer me-2"></i>
                    Archive History
                </a>
            </li>
        </ul>
        <hr>
        <div>
                <div class="col flex-column" >
                    <label for="post_list" class="post_list_label">Post:</label>
                    <select id="post_list" name="post_list" class="form-select form-select-md mb-2 list_opt user-ele user-required">
                        <option>** SELECT **</option>
                        <option>BN</option>
                        <option>LW</option>
                        <option>JK</option>
                    </select>
                </div>
        </div>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2"></i>
                <strong><?=str_replace("@armytee.app", "", $username )?></strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="/logout">Sign out</a></li>
            </ul>
        </div>
    </div>
    <div id="app">
        <?php echo $content; ?>
    </div>
</main>
<!-- Right Click Menu -->
<?php
switch (preg_replace("/\/new\/admin\//","",$_SERVER['REQUEST_URI'])){
    case "users":
        echo '<ul id="myMenu" class="contextMenu">
				    <li class="insert"><a href="#insert">New User</a></li>		
				    <li class="edit"><a href="#edit">Edit User</a></li>			        
				    <li class="edit"><a href="#chpass">Change Password</a></li>			        
				    <li class="delete"><a href="#delete">Delete User</a></li>			
				</ul>';
        break;
    case "vendors":
        echo '<ul id="myMenu" class="contextMenu">
				    <li class="insert"><a href="#insert_vendor">New Vendor</a></li>		
				    <li class="edit"><a href="#edit_vendor">Edit Vendor</a></li>			        			        
				    <li class="delete"><a href="#delete_vendor">Delete Vendor</a></li>			
				</ul>';
        break;
    case "producttypes":
        echo '<ul id="myMenu" class="contextMenu">
				    <li class="edit"><a href="#edit_option" id="eoi">Edit Option</a></li>			        		        
				    <li class="delete"><a href="#delete_option">Delete Option</a></li>			
				</ul>';
        break;
    case "posts":
        echo '<ul id="myMenu" class="contextMenu menu">
				    <li class="insert"><a href="#new_post">New Post</a></li>			        		        
				    <li class="edit"><a href="#edit_post">Edit Post</a></li>			        		        
				    <li class="delete"><a href="#delete_post">Delete Post</a></li>			
				</ul>';
        break;
    case "product":
        echo '<ul id="myMenu1" class="contextMenu menu1">
				    <li class="insert"><a href="#new_product">New Product</a></li>			        		        
				    <li class="edit"><a href="#edit_product">Edit Product</a></li>			        		        
				    <li class="delete"><a href="#delete_product">Delete Product</a></li>			
				</ul>';
        echo '<ul id="myMenu2" class="contextMenu menu2">
				    <li class="insert"><a href="#new_list">Add List</a></li>			        		        
				    <li class="edit" onmouseover="get_posts_list($(\'#posts_all\').val());"><a href="#">Copy list to -></a>
				    <ul id="posts_list" class="contextMenu" style=" left: 130px !important; top: 25px !important; width: 135px !important;">
				    	<li class="insert"><a href="#new_list">Model</a></li>
				    </ul>
				    </li>			        		        
				    <li class="delete"><a href="#delete_list">Delete List</a></li>			
				</ul>';
        break;
    case "cycles":
        echo '<ul id="myMenu1" class="contextMenu menu1">
				    <li class="insert"><a href="#insert_comp">Add A Company</a></li>		
				    <li class="edit"><a href="#edit_camp" id="ecamp">Edit Cycle</a></li>			        
				    <li class="delete"><a href="#delete_camp">Delete Cycle</a></li>			
				</ul>';
        echo '<ul id="myMenu2" class="contextMenu menu2">
				    <li class="insert"><a href="#insert_cplat">Add A Platoon</a></li>		
				    <li class="edit"><a href="#edit_comp" id="ecomp">Edit Company</a></li>			        
				    <li class="delete"><a href="#delete_comp">Delete Company</a></li>			
				</ul>';
        echo '<ul id="myMenu3" class="contextMenu menu3">
				    <li class="insert"><a href="#insert_sol">Add A Soldier</a></li>		
				    <li class="edit"><a href="#edit_cplat">Edit Platoon</a></li>			        
				    <li class="delete"><a href="#delete_cplat">Delete Platoon</a></li>			
				</ul>';
        echo '<ul id="myMenu4" class="contextMenu menu4">
				    <li class="edit"><a href="#edit_sol">Edit Soldier</a></li>			        
				    <li class="delete"><a href="#delete_sol">Delete Soldier</a></li>			
				</ul>';
        break;
}
switch (preg_replace("/\/new\//","",$_SERVER['REQUEST_URI'])){
    case "ordersearch":
        echo '<ul id="myMenu" class="contextMenu">
	    <li class="edit"><a href="#edit_order" name="modal">Edit Order</a></li>			        		        
	    <li class="insert"><a href="#new_order">Create Order</a></li>			        		        
	    <li class="delete"><a href="#delete_order">Delete Order</a></li>			
	</ul>';
        break;
    case "art":
        echo '<ul id="myMenu" class="contextMenu">
	    <li class="insert"><a href="#upload_file">Upload File</a></li>			        		        
	   	<!--<li class="edit"><a href="#comment_file">Comment File</a></li>-->			        		        
	    <li class="delete"><a href="#download_files">Download Files</a></li>			
	</ul>';
        break;
}
?>
<div id="boxes">
    <div id="dialog" class="window">
        Simple Modal Window |
        <a href="#"class="close"/>Close it</a>
    </div>

    <div id="dialog2" title="Basic dialog" style="display: none;">
        <!-- <form name="change_price" method="post" onsubmit="return false;">-->
        <center>Price: <input type="text" name="new_price" id="new_price" style="width:70px;"></center><br>
        <input type="hidden" name="pr_id_new" id="pr_id_new" />
        <input type="radio" name="type_np" value="1" checked> Current order only<br>
        <input type="radio" name="type_np" value="2"> Any future orders for this Platoon in this Cycle<br><br/>

        <center><strong>Quantity Discounts</strong></center><br/>
        <center>Quantity: <input id="qty1" value="" style="width:25px;" maxlength="2"> Price: <input id="cost1" value="" style="width:43px;" maxlength="5"></center><br/>
        <center>Quantity: <input id="qty2" value="" style="width:25px;" maxlength="2"> Price: <input id="cost2" value="" style="width:43px;" maxlength="5"></center><br/>
        <center>Quantity: <input id="qty3" value="" style="width:25px;" maxlength="2"> Price: <input id="cost3" value="" style="width:43px;" maxlength="5"></center><br/>
        <center>Quantity: <input id="qty4" value="" style="width:25px;" maxlength="2"> Price: <input id="cost4" value="" style="width:43px;" maxlength="5"></center><br/>

        <center><strong>Product Options</strong></center><br/>
        <center>Opt 1: <input id="opt1" value="" style="width:65px;" maxlength="15"> Price: <input id="opt1cost" value="" style="width:43px;" maxlength="5"></center><br/>
        <center>Opt 2: <input id="opt2" value="" style="width:65px;" maxlength="15"> Price: <input id="opt2cost" value="" style="width:43px;" maxlength="5"></center><br/><br/>
        <center>Opt 3: <input id="opt3" value="" style="width:65px;" maxlength="15"> Price: <input id="opt3cost" value="" style="width:43px;" maxlength="5"></center><br/><br/>
        <center>Opt 4: <input id="opt4" value="" style="width:65px;" maxlength="15"> Price: <input id="opt4cost" value="" style="width:43px;" maxlength="5"></center><br/><br/>

        <center>Why? <input type="text" name="mod_reason" id="mod_reason" ></center><br/>
        <center><input type="button" id="do_price_mod" value="Do it!" pid="0" ></center>
        <!--  </form>-->
    </div>
    <div id="mask"></div>
</div>
<script>
    /* global bootstrap: false */
    (function () {
        'use strict'
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })()
    ;
</script>
</body>
</html>

