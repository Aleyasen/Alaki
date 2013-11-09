
<?php
if (isset($_GET['m_id']) and isset($_GET['g_id'])) {
    if (isset($_GET['mode']) && $_GET['mode'] == 'clone') {
        echo $this->addMembersClone((int) $_GET['m_id'], (int) $_GET['g_id']);
        exit;
    } else {
        echo $this->addMembers((int) $_GET['m_id'], (int) $_GET['g_id']);
        exit;
    }
}

if (isset($_GET['g_name']) and isset($_GET['clustering_id'])) {
    $this->addNewGroup($_GET['g_name'], $_GET['clustering_id']);
    exit;
}

if (isset($_GET['del']) and isset($_GET['g_id'])) {
    $this->removeGroup($_GET['g_id'], $_GET['to_id']);
    exit;
}

// Remove Memebers from groups Ajax call
if (isset($_GET['delmem']) and isset($_GET['m_id'])) {
    echo $this->removeMember($_GET['m_id']);
    exit;
}

// Reload groups each ajax call
if (isset($_GET['reload']) and isset($_GET['g_id'])) {
    echo $this->getMembers_reload($_GET['g_id']);
    exit;
}


if (isset($_GET['reload_groups']) and isset($_GET['clustering_id'])) {
    echo $this->getGroups_reload($_GET['clustering_id']);
    exit;
}

if (isset($_GET['loadfb']) and isset($_GET['m_id'])) {
    echo $this->loadFBdata($_GET['m_id']);
    exit;
}
?>

<script>
    $(function() {

        //        $('#public').slimScroll({
        //            color: '#00f',
        //            size: '10px',
        //            width: '300px',
        //            alwaysVisible: true
        //        });
        //        
        //        
        //        $('#groupsall').slimScroll({
        //            color: '#00f',
        //            size: '10px',
        //            width: '200px',
        //            height: '500px',
        //            alwaysVisible: true
        //        });
        
        //   $('#public').css('float', 'right')

        var state = false;
        $(".group").click(function() {
            $(".groupheader").animate({
                backgroundColor: "#D6D4D5"
            }, 200);

            if (state) {
                $(this).find(">:first-child").animate({
                    backgroundColor: "#D6D4D5"
                }, 200);
            } else {
                $(this).find(">:first-child").animate({
                    backgroundColor: "#AACDFA"
                }, 200);
            }
            state = !state;
        });

        
        cval = $("#curclustering").attr("cls");
        var firstgid = $("#groupsall"+cval).children().eq(1).attr("id");
        //TODO
        
        showgroup(firstgid);
        $(document).on("click", ".openRemoveModal", function() {
            var clusId = $(this).data('id');
            var clusName = $(this).data('name');
            var unknownClusId = $(this).data('unknownclus');
            $(".modal-body #rclusName").text(clusName);
            $(".modal-body #rclusId").text(clusId);
            $(".modal-body #rtoclusId").text(unknownClusId);
            var memCount = $("div[id=" + clusId + "] ul").children().length;
            //alert(memCount);
            if (memCount > 0) {
                $('#removeGroupModal').modal('show');
            } else {
                removeGroup(clusId, unknownClusId);
            }
        });

        $("#addGroupSubmit").click(function() {
            addnewGroup($("#addGroupTextfield").val());
        });

        $("#removeGroupSubmit").click(function() {
            removeGroup($("#rclusId").text(), $("#rtoclusId").text());
        });
        // Initiate draggable for public and groups

        $(".selectall").livequery('click', function(event) {
            //            alert("click selectall");
            selected = $(this).attr('selall');
            if (selected == "1") {
                deSelectAll();
            } else {
                selectAll();
            }
        });
        
        

        //        $(".cont").livequery('click', function(event) {
        //            showgroup($(this).parent().attr('id'));
        //            $("html, body").animate({ scrollTop: 300 }, "slow");
        //            cval = $("#curclustering").attr("cls");
        //            $("#public"+cval).animate({ scrollTop: 0 }, "slow");
        //        });
        
        $(".group").livequery('click', function(event) {
            showgroup($(this).attr('id'));
            $("html, body").animate({ scrollTop: 300 }, "slow");
            cval = $("#curclustering").attr("cls");
            $("#public"+cval).animate({ scrollTop: 0 }, "slow");
        });
        
        //        $(".ilink").livequery('click', function(event) {
        //            
        //            $(this).tooltip({
        //                content: '... waiting on ajax ...',
        //                open: function(evt, ui) {
        //                    alert("salam")
        //                    var elem = $(this);
        //                    m_id = $(this).parent().attr('id');
        //                    $.ajax('clustering/?m_id=' + m_id + 'loadfb=1').always(function(data) {
        //                        elem.tooltip('option', 'content', data);
        //                    });
        //                }
        //            });
        //        });
        
        
    });
</script>

