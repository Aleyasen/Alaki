<link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media = "screen, projection" />
<link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media = "print" />
<!--[if lt IE 8]>
<link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media = "screen, projection" />
<![endif]-->

<link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
<link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/bs/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/bs-editable/css/bootstrap-editable.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/1b14b3a1/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/1b14b3a1/jquery.yii.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.livequery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bs/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bs-editable/js/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/scripts.js"></script>

<script>
    $(function() {
        $("#addGroupModal").on('shown', function() {
            $(this).find("#addGroupTextfield").val("");
            $(this).find("#addGroupTextfield").focus();
        });
    
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('a[data-toggle="tab"]').on('shown', function (e) {
            //alert(e.target); // activated tab
            //alert(e.relatedTarget); // previous tab
            if (endsWith(e.target,"alg1")){
                clsVal = $("#alg1").attr("cls"); 
            } else if (endsWith(e.target,"alg2")){
                clsVal = $("#alg2").attr("cls");    
            } else if (endsWith(e.target,"alg3")){
                clsVal = $("#alg3").attr("cls");    
            }
            $("#curclustering").attr("cls", clsVal);
            var firstgid = $("#groupsall"+clsVal).children().eq(1).attr("id");
            showgroup(firstgid);
            reloadGroups();
            //alert($("#curclustering").attr("cls"));
        });
        $('#myTab a:first').tab('show');
    });

    function endsWith(str1, suffix) {
        var str = new String(str1);
        return str.indexOf(suffix, str.length - suffix.length) !== -1;
    }
</script>

<style>

    body { font-family:'lucida grande',arial,tahoma,verdana,arial,sans-serif; font-size: 11px; }
    #main_portion{width:920px; text-align: left; padding:0; float: left; }
    .public { float:right; max-height:500px; overflow-y:auto; display: inline; }
    .members{ color: #3B5998; text-decoration: none; background-color: white;
              cursor: pointer;width:170px;
              position: relative; float: left; border:1px dotted #ccc; 
              border-radius:5px; text-align: left; padding:2px; margin-top: 2px;
              margin-left: 2px;z-index:999; font-weight:bold; font-size:10.5px;}
    .members img{ padding:2px; margin-right:8px; border:1px solid #ccc; float:left;}
    .groupsall{ float:left; clear:left; display: inline; max-height:500px; overflow: auto; width:180px; }
    .group{ float:left; position:relative; width:117px; border:1px solid #817f83; margin:15px; margin-top:4px; text-align: left; min-height:137px; height:auto; background-color: white; }
    .supgroup{float:left; position:relative; width:150px; border:1px solid #aca9af; margin:3px; text-align: left; height:auto; background-color: #dcbdf9;}
    .cont{width:115px;min-height:115px; height:auto; background: none;}
    .supcont{width:128px;}
    .group ul{ padding:0; margin:0;}
    .group li { float:left; list-style: none; padding:2px;}
    .supgroup ul{ padding:0; margin:0;}
    .supgroup li { float:left; list-style: none; padding:2px;}

    .add{ position: absolute; z-index:99;}
    .remove{ position: absolute; z-index:99;}
    h2{ font-size: 22px; text-align: left;}
    h1{  font-size: 28px;}
    .groupheader{ background-color:#D6D4D5; padding-left:4px;  }
    .supgroupheader{ background-color:#6cddf2; padding-left:4px; }
    .fb_thumb {float:left; padding:2px;}
    .fb_thumb_count {display:inline-block; background-color:#DFC4E2;  height:34px; width: 34px; text-align:center;   font-size:12pt; line-height:34px; }
    .close2{
        font-size: 40px;
    }
    .color1 {background-color: #66ff33 }
    .color2 {background-color: #ff00ff}
    .color3 {background-color: #ff9999 }
    .color4 {background-color: #6699ff }
    .color5 {background-color: #00cc66 }
    .color6 {background-color: #ff9999}
    .editable-click, a.editable-click, a.editable-click:hover {
        border-bottom: 1px dashed #0088CC;
        color: black;
        text-decoration: none;
    }
    .ilink {
        position: absolute;
        right: 3px;
        top: 43px;
        color: #B5B5B5;
    }
    .ilink:hover {
        color: #45619D;
    }

    .algtab {
        font-size: 15px;
    }
</style>


<ul class="nav nav-tabs" id="myTab">
   
   
       <li><a href="#alg1" data-toggle="tab" class="algtab">Disjoint</a></li>  
       <li><a href="#alg2" data-toggle="tab" class="algtab">Overlapping</a></li>  
        <li><a href="#alg3" data-toggle="tab" class="algtab">Hierarchical</a></li> 
    
</ul>


<div id="curclustering" cls="<?php echo $this->getClusteringId($this->getVar('user'), 1); ?>"></div>
<div class="tab-content">
    <div class="tab-pane active" id="alg1" cls="<?php echo $this->getClusteringId($this->getVar('user'), 1); ?>">
        <?php
        $clusteringId = $this->getClusteringId($this->getVar('user'), 1);
        $this->renderPartial('clustering', array(
            'user' => $user,
            'clusteringId' => $clusteringId
        ));
        ?>
    </div>
    <div class="tab-pane" id="alg2" cls="<?php echo $this->getClusteringId($this->getVar('user'), 5); ?>">
        <?php
        $clusteringId = $this->getClusteringId($this->getVar('user'), 5);
        $this->renderPartial('clustering_overlap', array(
            'user' => $user,
            'clusteringId' => $clusteringId
        ));
        ?>
    </div>
    <div class="tab-pane" id="alg3" cls="<?php echo $this->getClusteringId($this->getVar('user'), 4); ?>">
        <?php
        $clusteringId = $this->getClusteringId($this->getVar('user'), 4);
        $this->renderPartial('clustering_hier', array(
            'user' => $user,
            'clusteringId' => $clusteringId
        ));
        ?>
    </div>
</div>

<div id="next" style="float:center;">
    <center><a href='#FinishGroupModal' role='button' class='btn btn-primary' data-toggle='modal'>Finish</a></center>
</div>

<!-- Modal -->
<div id="addGroupModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="myModalLabel">Add Group</h4>
    </div>
    <div class="modal-body" style="font-size:10pt;">
        Group Name:
        <?php
        echo CHtml::textField('GroupName', '', array('id' => 'addGroupTextfield',
            'width' => 40, 'maxlength' => 200));
        ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button id="addGroupSubmit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Add</button>
    </div>
</div>


<div id="removeGroupModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="myModalLabel2">Delete Group</h4>
    </div>
    <div class="modal-body" style="font-size:10pt;">
        Are you sure to delete "<div id='rclusName' style="display:inline"></div>"? By deleting it, all the members will go to un-grouped.
        <div id='rclusId' style="display:none"></div>
        <div id='rtoclusId' style="display:none"></div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button id="removeGroupSubmit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Delete</button>
    </div>
</div>

<div id="FinishGroupModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="myModalLabel3">Done!</h4>
    </div>
    <div class="modal-body" style="font-size:10pt;">
        Are you done with your groups?
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
        <?php echo CHtml::button('Yes', array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'aria-hidden' => 'true', 'submit' => array('frontend/finish'))); ?>
    </div>
</div>

