<?php
include_once '_base_clustering.php';
?>


<script type="text/javascript" >
    $(function() {
        // Initiate Droppable for groups
        // Adding members into groups
        // Removing members from groups
        // Shift members one group to another

        cval = $("#alg1").attr("cls");
    
        $("#groupsall"+cval+" .group").livequery(function() {
            var casePublic = false;
            $(this).droppable({
                activeClass: "ui-state-highlight",
                accept: "div[id^='mem']",
                drop: function(event, ui) {
                    //var m_id = $(ui.draggable).attr('rel');
                    var size = $("div[sel='1']").size();
                    if (size == 0) {
                        tag = "<span style='color: #3B5998; font-weight:bold; font-size:12px; background-color:#D1E3F9; border:1px dotted #ccc; border-radius:6px; padding:6px;'>+1<span>";
                        if (!m_id)
                        {
                            casePublic = true;
                            var m_id = $(ui.draggable).attr("id");
                            var fb_id = $(ui.draggable).attr("fbid");
                            m_id = parseInt(m_id.substring(3)); //todo: test this line!
                        }
                        var g_id = $(this).attr('id');
                        $(ui.draggable).hide("explode", 1000);
                        dropPublic(m_id, g_id, casePublic);
                        $("#mem" + m_id).hide();
                        $("div[picfbid='" + fb_id + "']").remove();
                        var count = $("#" + g_id + " ul").children().length;
                        if (count > 8) {
                            $("#" + g_id + " ul > div:first").remove();
                        }
                        //  $("#"+g_id+" ul").append("<div picfbid='"+ fb_id +"' class='fb_thumb'><fb:profile-pic class='logopic' uid=" + fb_id + " size='square' width='34' facebook-logo='false' linked='false'></fb:profile-pic></div>");
                        $("#" + g_id + " ul").append("<div picfbid='" + fb_id + "' class='fb_thumb'><img  src='https://graph.facebook.com/" + fb_id + "/picture' width='34'></div>");

                        // FB.XFBML.parse(document.getElementById(g_id));
                        $("<li></li>").html(ui.draggable).appendTo(this);

                    } else {
                        tag = "<span style='color: #3B5998; font-weight:bold; font-size:12px; background-color:#D1E3F9; border:1px dotted #ccc; border-radius:6px; padding:6px;'>+" + (size - 1) + "<span>";
                        var g_id = $(this).attr('id');
                        var group = $(this);
                        $("div[sel='1']").each(function() {
                            $(this).attr("sel", "0");
                            if ($(this).attr("id")) {
                                //alert($(this).attr("id")+" "+$(this).html());
                                // if(!m_id)
                                // {
                                casePublic = true;
                                var m_id = $(this).attr("id");
                                var fb_id = $(this).attr("fbid");
                                m_id = parseInt(m_id.substring(3)); //todo: test this line!
                                //  }					

                                $(this).hide("explode", 1000);
                                //  alert("m:"+m_id+" g:"+g_id);
                                dropPublic(m_id, g_id, casePublic);
                                $("#mem" + m_id).hide();
                                $("div[picfbid='" + fb_id + "']").remove();
                                var count = $("#" + g_id + " ul").children().length;
                                if (count > 8) {
                                    $("#" + g_id + " ul > div:first").remove();
                                }
                                //  $("#"+g_id+" ul").append("<div picfbid='"+ fb_id +"' class='fb_thumb'><fb:profile-pic class='logopic' uid=" + fb_id + " size='square' width='34' facebook-logo='false' linked='false'></fb:profile-pic></div>");
                                $("#" + g_id + " ul").append("<div picfbid='" + fb_id + "' class='fb_thumb'><img src='https://graph.facebook.com/" + fb_id + "/picture' width='34'></div>");

                                //   FB.XFBML.parse(document.getElementById(g_id));
                                $("<li></li>").html(ui.draggable).appendTo(group);
                            }
                        });
                    }

                    $("#added" + g_id).html(tag);
                    $("#added" + g_id).animate({"opacity": "10"}, 10);
                    $("#added" + g_id).show();
                    $("#added" + g_id).animate({"margin-top": "-50px"}, 450);
                    $("#added" + g_id).animate({"margin-top": "0px", "opacity": "0"}, 450);
                    dragOutGroup($(this).attr("id"));

                },
                out: function(event, ui) {
                    dragOutGroup($(this).attr("id"));
                },
                over: function( event, ui ) {
                    dragOverGroup($(this).attr("id"))
                }
                
            });
        });

        var $gallery = $("#public"+cval+" .members, #groupsall"+cval+" .group");
        $("div[id^='mem']", $gallery).live("mouseenter", function() {
            var $this = $(this);
            if (!$this.is(':data(draggable)')) {
                $this.draggable({
                    helper: "clone",
                    containment: $("#demo-frame").length ? "#demo-frame" : "document",
                    cursor: "move"
                });
            }
        });
    });
</script>

<div id="ld" style='display:none;top:50%;left:50%;position:fixed'><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif' width='50' height='50'></div>

<div id="main_portion" class="row">

    <div id="public<?php echo $clusteringId ?>" class="span9 public">
        <!-- Initiate members -->



    </div>
    <div id="groupsall<?php echo $clusteringId ?>" class="span2 groupsall">
        <!-- Initiate Groups -->
        <?php
        $clusteringId = $this->getClusteringId($user, 1);
        echo $this->getGroups_reload($clusteringId);
        ?>
    </div>
</div>
<hr/>

