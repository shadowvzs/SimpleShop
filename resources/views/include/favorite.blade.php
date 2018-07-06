<table border="0" id="favorite_table" width="100%"> </table>

<script>
    var favorites = {
        init: function() {
			var data = JSON.parse(localStorage.getItem("favorites") || "{}");
            var keys = Object.keys(data);
            favorites.icon = document.querySelector('.fav_bar a');
            this.data = data;
            this.table = document.getElementById("favorite_table");
            keys.forEach(function(e){
                favorites.add(data[e], true);
            });
            favorites.icon.dataset.amount = keys.length;
        },
        add: function(prod, init=false) {
            var data = favorites.data, row;
            if (data[prod.id] && !init) { return $.notify("<?php echo trans('default.favorite_already_added'); ?>", "error"); }
            data[prod.id] = prod;
            row = favorites.table.insertRow(-1);
            row.innerHTML = '<td><a href="/prod/'+prod.slug+'">'+prod.name+'</a></td><td class="text-right"><a href="javascript:void(0)" onclick="favorites.remove('+prod.id+')" class="delete-link">&times;</a></td>';
            row.id = 'favorite_row_'+prod.id;
            if (!favorites.icon.classList.contains('mini_badge')) {
                favorites.icon.classList.add("mini_badge");
            }
            if (!init) {
                localStorage.setItem("favorites", JSON.stringify(data));
                favorites.icon.dataset.amount = Object.keys(data).length;
                return $.notify("<?php echo trans('default.added_to_favorites'); ?>", "info");
            }
        },
        remove: function(id) {
            var data = favorites.data;
            if (!data[id]) { return $.notify("<?php echo trans('default.favorite_not_exist'); ?>", "error"); }
            delete data[id];
            $('#favorite_row_'+id).remove();
            localStorage.setItem("favorites", JSON.stringify(data));
            favorites.icon.dataset.amount = Object.keys(data).length;
            if (!Object.keys(data).length) {
                favorites.icon.classList.remove("mini_badge");
            }
            return $.notify("<?php echo trans('default.delete_favorite_ok'); ?>", "info");
        }

    }

    $( document ).ready(function() {
        favorites.init();
        var sel = $('#add_favorite_btn');
        if (sel.length) {
            $('#add_favorite_btn').click(function(){
                var id = $('#prod_id').val();
                var data = JSON.parse(localStorage.getItem("favorites") || "{}");
                var prod = $('#prod_data').val();
                favorites.add(JSON.parse(prod));
            });
        }
    });
</script>
