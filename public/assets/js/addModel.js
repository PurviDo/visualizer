$(function () {
  let countModel = 0;

  $('#subcategory').on('change', function () {
    var categoryId = $(this).val();
    
    if (categoryId) {
      $.ajax({
        url: noOfFilesUrl + "/" + categoryId,
        type: 'GET',
        success: function (data) {
          $('#no_of_files').val(data);
          $('.dynamicPersonDetails').empty();

          let no_of_files = parseInt(data);

          if (!isNaN(no_of_files) && no_of_files > 0) {
            addMember(countModel, no_of_files);
            countModel++; 
          } else {
            alert("Please enter a number of user input in sub category.");
          }
        },
        error: function () {
          alert("Failed to fetch data.");
        }
      });
    } else {
      $('#no_of_files').empty();
    }
  });

  $(document).on('click', '.dynamic-pd', function () {
    if ($('.dynamicPersonDetails tr').length < 5) {
      addMember(countModel, parseInt($('#no_of_files').val(), 10));
      countModel++; 
    } else {
      alert("You can only add up to 5 members.");
    }
  });

  $(document).on('click', '.remove-field', function () {
    $(this).parents('tr').remove();
    updateAddButton();
  });

  function addMember(countModel, no_of_files) {
    let html = '<tr>';

    html += `<td>
                <fieldset class="form-group floating-label-form-group">
                    <label for="background_image_${countModel}">Background Image</label>
                    <input type="file" name="background_image[]" class="form-control background_image">
                    <div class="invalid-feedback font-weight-bold background_image_${countModel}-invalid" role="alert"></div>
                </fieldset>
              </td>
              <td>
                <fieldset class="form-group floating-label-form-group">
                    <label for="foreground_image_${countModel}">Foreground Image</label>
                    <input type="file" name="foreground_image_${countModel}" class="form-control foreground_image">
                    <div class="invalid-feedback font-weight-bold foreground_image_${countModel}-invalid" role="alert"></div>
                </fieldset>
              </td>
              <td>
                <fieldset class="form-group floating-label-form-group">
                    <label for="shadow_image_${countModel}">Shadow Image</label>
                    <input type="file" name="shadow_image_${countModel}" class="form-control shadow_image">
                    <div class="invalid-feedback font-weight-bold shadow_image_${countModel}-invalid" role="alert"></div>
                </fieldset>
              </td>
              <td>
                <fieldset class="form-group floating-label-form-group">
                    <label for="highlight_image_${countModel}">Highlight Image</label>
                    <input type="file" name="highlight_image_${countModel}" class="form-control highlight_image">
                    <div class="invalid-feedback font-weight-bold highlight_image_${countModel}-invalid" role="alert"></div>
                </fieldset>
              </td>
              <td>
                <fieldset class="form-group floating-label-form-group">
                    <label for="preview_image_${countModel}">Preview Image</label>
                    <input type="file" name="preview_image_${countModel}" class="form-control preview_image">
                    <div class="invalid-feedback font-weight-bold preview_image_${countModel}-invalid" role="alert"></div>
                </fieldset>
              </td>`;

    for (let i = 0; i < no_of_files; i++) {
      html += `<td>
                  <fieldset class="form-group floating-label-form-group">
                      <label for="file_${countModel}_${i}">File ${i + 1}</label>
                      <input type="file" name="file_${countModel}_${i}" class="form-control file-input">
                      <div class="invalid-feedback font-weight-bold file_${countModel}_${i}-invalid" role="alert"></div>
                  </fieldset>
               </td>`;
    }

    html += `<td>
                <div class="form-floating form-floating-outline">`;

    if ($('.dynamicPersonDetails tr').length == 0) {
      html += `<button type="button" name="add" class="btn btn-outline-primary dynamic-pd">+</button>`;
    } else {
      html += `<button type="button" class="btn btn-outline-danger remove-field">-</button>`;
    }

    html += `  </div>
              </td>
            </tr>`;

    $(".dynamicPersonDetails").prepend(html);
    updateAddButton();
  }

  function updateAddButton() {
    $('.dynamicPersonDetails tr').each(function (index, row) {
      if (index == 0) {
        if (!$(row).find('.dynamic-pd').length) {
          $(row).find('td:last-child div').html('<button type="button" name="add" class="btn btn-outline-primary dynamic-pd">+</button>');
        }
      } else {
        $(row).find('.dynamic-pd').remove();
        if (!$(row).find('.remove-field').length) {
          $(row).find('td:last-child div').html('<button type="button" class="btn btn-outline-danger remove-field">-</button>');
        }
      }
    });
  }
});
