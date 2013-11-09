
function reloadGroups() {
    cval = $("#curclustering").attr("cls");
    $.ajax({
        type: "GET",
        url: "?reload_groups=1&clustering_id="+cval,
        cache: false,
        success: function(response) {
            $("#groupsall"+cval).html(response);
        //   FB.XFBML.parse(document.getElementById('groupsall'));
        }
    });
}



function initEditNames() {
    $('a[id^="clusname"]').editable({
        type: 'text',
        pk: function() {
            return $(this).attr('cid')
        },
        name: 'name',
        url: 'updateName',
        title: 'Enter Group Name',
        value: '',
        mode: 'popup', //inline
        success: function(data) {
        //                    $.ajax({
        //                        type:"GET",
        //                        url:"clustering/?reload_groups",
        //                        cache:false,
        //                        success:function(response){ 
        //                            $("#groupsall").html(response);
        //                        }
        //                    });                
        },
        validate: function(value) {
            n = "clusname" + ($(this).attr('cid'));
            $('a[id=' + n + ']').html(value);
        // $("#cln"+$('a[id^="clusname"]').attr('cid')).html(value);
        // $("#clusname"+$('a[id^="clusname"]').attr('cid')).html(value);
        }
    });
}
        
        
function showNames() {
//    $('div[id^="name"]').html(function() {
//        var $t = $(this);
//        var friend_id = $(this).attr('id').substr(4);
//        //alert(myid);
//        name = "";
//        FB.api('/' + friend_id + '?fields=name', function(response) {
//            $t.html(response.name);
//        });
//    });
}

function deSelectAll(){
    
    cval = $("#curclustering").attr("cls");
    //    alert("deselect");
    //    alert(cval);
    //    alert("deSelect" + $("#public"+cval+" .members").size());
    $("#public"+cval+" .members").each(function() {
        $(this).attr("sel", "0");
        $(this).css("background-color", "white");
        $("#public"+cval+" .selectall").attr("selall","0");
    });
}

function selectAll(){
    cval = $("#curclustering").attr("cls");
    //    alert("select");
    //    alert(cval);
    //    alert("Select" + $("#public"+cval+" .members").size());
    $("#public"+cval+" .members").each(function() {
        $(this).attr("sel", "1");
        $(this).css("background-color", "#D1E3F9");
        $("#public"+cval+" .selectall").attr("selall","1");
    });
}

function showgroup(g_id) {
    $("#ld").show();
    $.ajax({
        type: "GET",
        url: "?g_id=" + g_id + "&reload=1",
        cache: false,
        success: function(response) {
            cval = $("#curclustering").attr("cls");
            $("#public"+cval).html(response);
            $("#ld").hide();
            //                   FB.XFBML.parse(document.getElementById('public'),function() {
            //showNames();
            initEditNames();
            $(".members").mouseout(function(event) {
                $(this).children("i.ilink").css("display","none");
                $(this).css("border","1px dotted #ccc");
            });
            
            $(".members").mouseover(function(event) {
                $(this).children("i.ilink").css("display",""); 
                $(this).css("border","1px solid #ccc");
            });
            $(".members").click(function(event) {
                //alert("salam");
                var $item = $(this),
                $target = $(event.target);
                if ($target.is("div.delbutton")){
                    deleteMember_($item);
                } else if ($target.is("i.ilink")){
                    openFBLink($item);
                } else {
                    selectMember_($item);
                }
                
                return false;
            });
            
            

        // $( 'div[id^="mem"]' ).click(function() {
        //      $(".delbutton").click(function() {
        //         
        //      });
        //                    });
        }

    });
}

function openFBLink($item){
    fbid = $item.attr("fbid");
    window.open('https://www.facebook.com/' + fbid);
    return false;
}
function selectMember_($item){
    //alert($item.attr("sel"));
    selected = $item.attr("sel");
    if (selected == "1") {
        $item.attr("sel", "0");
        $item.css("background-color", "white");
    } else if (selected == "0") {
        $item.attr("sel", "1");
        $item.css("background-color", "#D1E3F9");
    } else {
        alert("invalid value");
    }
}

function deleteMember_($item) {
    var size = $("div[sel='1']").size();
    // alert(size);
    if (size == 0){
        if ($(this).is(':visible')){
            var fr_db_id = $item.attr('id').substr(3);
            deleteMember(fr_db_id,true);
        }
    } else {
        $("div[sel='1']").each(function(){
            if ($(this).is(':visible')){
                var fr_db_id = $(this).attr('id').substr(3);
                deleteMember(fr_db_id,false);
            }
        }).promise().done( function(){ 
            reloadGroups()
        } );
    }
}


function deleteMember(fr_db_id, reload){
    $.ajax({
        type: "GET",
        url: "?m_id=" + fr_db_id + "&delmem=1",
        cache: false,
        success: function(response) {
            //$("#mem" + fr_db_id).hide("explode", 1000);
            if (reload == true){
                reloadGroups();
            }
        }
    });
    $("#mem" + fr_db_id).css("background-color", "white");
    $("#mem" + fr_db_id).attr("sel","0");
    $("#mem" + fr_db_id).hide("explode", 1000);
}
function addnewGroup(g_name) {
    cval = $("#curclustering").attr("cls");
    $.ajax({
        type: "GET",
        url: "?g_name=" + g_name+" &clustering_id="+cval,
        cache: false,
        success: function(response) {
            reloadGroups();
        }
    });
}

function removeGroup(g_id, to_id) {
    $.ajax({
        type: "GET",
        url: "?g_id=" + g_id + "&to_id=" + to_id + "&del=1",
        cache: false,
        success: function(response) {
            reloadGroups();
            showgroup(to_id);
        }
    });
}

// Add or shift members from groups
function dropPublic(m_id, g_id, caseFrom)
{
    $.ajax({
        type: "GET",
        url: "?m_id=" + m_id + "&g_id=" + g_id,
        cache: false,
        success: function(response) {
        //    $("#mylog").append(response);
        //    alert(response);
        }
    });
}

// Add or shift members from groups
function dropClonePublic(m_id, g_id, caseFrom)
{
    $.ajax({
        type: "GET",
        url: "?m_id=" + m_id + "&g_id=" + g_id+"&mode=clone",
        cache: false,
        success: function(response) {
            
        }
    });        
}

function loadFBdata(m_id)
{
    $.ajax({
        type: "GET",
        url: "?m_id=" + m_id + "loadfb=1",
        cache: false,
        success: function(response) {
            return response;
        }
    });        
}

function dragOverGroup(dom_id){
    // alert("over");
    //  alert($ui);
    $("#" + dom_id + " :first-child").css("background-color", "#A4D5EF");
    $("#" + dom_id).css("border", "2px solid #A4D5EF");
}

function dragOutGroup(dom_id) {
    $("#" + dom_id + " :first-child").css("background-color", "#D6D4D5");
    $("#" + dom_id).css("border", "1px solid #817f83");
}



   // Remove memebers from groups
        // It will restore into public groups or non grouped members
        //        function removeMember(g_id,m_id)
        //        {
        //            $.ajax({
        //                type:"GET",
        //                url:"clustering/?do=drop&mid="+m_id,
        //                cache:false,
        //                success:function(response){
        //                    $("#removed"+g_id).animate({"opacity" : "10" },10);
        //                    $("#removed"+g_id).show();
        //                    $("#removed"+g_id).animate({"margin-top": "-50px"}, 450);
        //                    $("#removed"+g_id).animate({"margin-top": "0px","opacity" : "0" }, 450);
        //                    //$.get("clustering/?reload", function(data){ $("#public").html(data); });
        //                }
        //            });
        //        }	
