Dropzone.options.uploader = {
  maxFiles: 2,
  accept: function(file, done) {
    console.log("uploaded");
    done();
  },
  init: function() {
    this.on("maxfilesexceeded", function(file){
      this.removeFile(file);
    });
  }
};

$('.next').click(function(){

  var sheet_number = $('#sheet_number').val();
  var name_cell = $('#name_cell').val();
  var grade_cell = $('#grade_cell').val();
  var cell_range = $('#cell_range').val();
  var header_row = $('#header_row').val();
  var start_row = $('#start_row').val();
  var end_row = $('#end_row').val();

  $.post(
    'save-settings.php', 
    {
      'sheet_number': sheet_number,
      'name_cell': name_cell,
      'grade_cell': grade_cell,
      'cell_range': cell_range,
      'header_row': header_row,
      'start_row': start_row,
      'end_row': end_row
    },
    function(response){
      document.location.href = 'index.html';
    }
  );

});