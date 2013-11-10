var hexDigits = new Array
        ("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");

//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}

function increase_brightness(hex, percent) {
    // strip the leading # if it's there
    hex = hex.replace(/^\s*#|\s*$/g, '');

    // convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
    if (hex.length == 3) {
        hex = hex.replace(/(.)/g, '$1$1');
    }

    var r = parseInt(hex.substr(0, 2), 16),
            g = parseInt(hex.substr(2, 2), 16),
            b = parseInt(hex.substr(4, 2), 16);

    return '#' +
            ((0 | (1 << 8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
            ((0 | (1 << 8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
            ((0 | (1 << 8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
}

function addDragDrop() {
    var container = document.querySelector('#cluster-zone');
    var msnry = new Masonry(container, {
        columnWidth: 200,
        itemSelector: '.ul-cluster'
    });

    $(".ul-cluster").mouseenter(function() {
      
    });
    colors = ["#E7987E",
        "#72DB44",
        "#E37FE7",
        "#78D7C5",
        "#EAA134",
        "#65DA8A",
        "#CBC2C1",
        "#B9A5E3",
        "#CAD73D",
        "#E893B4",
        "#9BB485",
        "#82BFE0",
        "#AFD26F",
        "#D3B55E",
        "#DAE0AB"];
    $('#bottom-list li').each(function(index) {
        $(this).css('background-color', colors[index]);
    });


    $(".cluster").draggable({
        revert: true
    });
    $(".group").droppable({
        hoverClass: "drop-hover",
        accept: ".cluster,.friend_div",
        drop: function(event, ui) {
            if (ui.draggable.attr('data-type') == "user") {
                //$(this).find("#og").append(ui.draggable.html());
                $(ui.draggable).hide("explode", 1000);
                ui.draggable.detach().appendTo($(this).find("#og .list"));
                $cid = $(this).attr('data-cid');
                $this = $(this);
                $.ajax({
                    url: $url_moveFriend,
                    data: {friendId: ui.draggable.attr('data-id'), sourceId: ui.draggable.attr('data-cid'), destId: $cid},
                    success: function(msg) {
                        $this.html(msg);
                    },
                    error: function(xhr) {
                        alert("failure" + xhr.readyState + this.url)
                    }
                });
            }
            else {
                $(ui.draggable).hide("explode", 1000);
                ui.draggable.detach().appendTo($(this));
                $cid = $(this).attr('data-cid');
                $this = $(this);
                $.ajax({
                    url: $url_moveCluster,
                    data: {clusId: ui.draggable.attr('data-cid'), destId: $cid},
                    success: function(msg) {
                        $this.html(msg);
                    },
                    error: function(xhr) {
                        alert("failure" + xhr.readyState + this.url)
                    }
                });
            }
        }
    });


    $(".friend_div").draggable({
        revert: true
    });
    $(".cluster").droppable({
        hoverClass: "drop-hover",
        accept: ".friend_div",
        drop: function(event, ui) {
            ui.draggable.detach().appendTo($(this).find(".list"));
        }
    });

    $(".groups").click(function(event) {
        $cid = $(event.target).attr('data-cid');
        $cid_color = $(event.target).parent().css("background-color");
        if ($cid == null) {
            $cid = $(event.target).parent().attr('data-cid');
            $cid_color = $(event.target).parent().parent().css("background-color");
        }
        $.ajax({
            url: $url_showCluster,
            data: {clusId: $cid},
            success: function(msg) {
                $('#cluster-zone').html(msg);
                console.log($cid_color);
                $(".cluster").css("background-color", increase_brightness(rgb2hex($cid_color), 50));
            },
            error: function(xhr) {
                alert("failure" + xhr.readyState + this.url)
            }
        });
    });
}
$(document).ready(function() {
    addDragDrop();
    console.log("Document loaded");
});
$(document).ajaxComplete(function() {
    addDragDrop();
});
