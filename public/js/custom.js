$(function() {
  const reader = new FileReader();
  var sel = $('.multi-selectable');

  if (sel.length) {
    sel.on( "click", ".target", function( e ) {
        e.preventDefault();
        $( this ).toggleClass('active');
    });
  }

  sel = $('.selectable');

  if (sel.length) {
    sel.on( "click", ".target", function( e ) {
        $('.selectable .target.active').each(function(i, obj){
          $(obj).removeClass('active');
        })
        e.preventDefault();
        $( this ).toggleClass('active');
    });
  }

  sel = $('input[type="file"]');
  if (sel.length) {
    if (sel.data( "target")) {
        sel.change(showPreviewImage);
    }
  }

  var old_box = $('.old_images');
  function showPreviewImage(e) {
      const input = $(this), inputFiles = this.files, m = inputFiles.length, maxSize = 5000000;
      let target = $(input.data( "target")), c = 0, img, totalFileSize = 0;

      if (inputFiles == undefined || inputFiles.length == 0) return;

      for (let file of inputFiles) {
        totalFileSize += file.size;
      }

      if (totalFileSize > maxSize) {
        this.value = '';
        target.html('<b>File Size Error: </b><br><i>file sizes too high (<b>'+(totalFileSize/1000000).toFixed(2)+'</b> Mb), <br> images must be lower than <b>5</b> Mb.</i><br>please resize or convert your image');
        reader.onload = null;
        return;
      }

      target.html('');

      reader.onloadend = function(e) {
        const reselect = $('.selectable .target.active').length === 0;
        target.append( $('<img src="'+e.target.result+'" class="img-thumbnail m-1 target'+(!c && reselect ? ' active' : '')+'" alt="preview" data-id="'+c+'">') );
        c++;
        if (c < m) {
          loadPreview(inputFiles, c);
        }
      };

      reader.onerror = function(e) {
          alert("I AM ERROR: " + e.target.error.code);
          c++;
          if (c < m) {
            loadPreview(inputFiles, c);
          }
      };

      loadPreview(inputFiles, c);
  }

  function loadPreview (files, index) {
    if (!files[index]) { return; }
    reader.readAsDataURL(files[index]);
  }


  sel = $('#page_type');

  if (sel.length) {
    var select = sel;
    var prod_cat = $('select[name=category]');
    var page_content = $('textarea[name=content]');
    var url = $('input[name=url]');
    var url_hint = $('#url_hint');

    select.change(function(e) { changeInputForPage(); });
    prod_cat.change(function(e) { changeUrlInput(); });

    function changeInputForPage(){
        var type = select.val();
        if (type == 1) {
            page_content.hide();
            prod_cat.show();
            url_hint.hide();
            url.prop('readonly', true);
        } else {
            page_content.show();
            prod_cat.hide();
            url_hint.show();
            url.prop('readonly', false);
        }
    }

    function changeUrlInput() {
        url.attr('value', '/collection/'+prod_cat.find("option:selected").data('slug'));
    }

    changeInputForPage();
    if (url.attr('value').length < 1) {
        changeUrlInput();
    }
  }

  sel = $('.language_choose');
  if (sel.length) {
      sel.click(function() {
          var id = $(this).data('id');
          $.ajax({
            method: "GET",
            url: "/language/"+id,
            dataType: "json",
            async: true
           })
           .done(function( response ) {
                if (response.success) {
                    location.reload();
                }
           });
      });
  }

  sel = $('#add_product_form');
  if (sel.length) {
      sel.submit(function( e ) {
          const sizes = $('#product_size').find('.active');
          const colors = $('#product_color').find('.active');
          let images = $('#product_images').find('.active'), jsonData = {size: [], color: [], main_image: 0};

          if (images.length == 0 && old_box.length > 0) { images = old_box.find('.active'); }
          if (!sizes.length || !colors.length) {
              e.preventDefault();
              alert('Select atleast 1 size and color');
              return;
          }

          if (images.length !== 1) {
              e.preventDefault();
              alert('Select a cover image');
              return;
          }
          sizes.each(function () {
              jsonData['size'].push($(this).data('id'));
          });
          colors.each(function () {
              jsonData['color'].push($(this).data('id'));
          });

          jsonData.main_image = images.data('id');

          $('#json_input').val(JSON.stringify(jsonData));

      });
  }

  $('a.delete').click(function(e) {
      let target = $($(this).data('target')),
          url = $(this).data('url');

      if (confirm('Are you sure?')) {
          $.get(url, function(data, status){
              if (status == "success" && data == "true") {
                target.remove();
              }
          });
      }
  });

  // for admin languages
  sel = $('form label.set_lang');
  if (sel.length) {
      sel.click(function(){
          var id = $(this).data('id');
          var code = $(this).data('code');
          if (!id || !code) { return; }
          location = "/dashboard/language/"+id+"/"+code;
      })
  }
});
