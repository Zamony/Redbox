<link rel="stylesheet" href="/Themes/RedcontrolAdmin/libs/trumbowyg/design/css/trumbowyg.css">
	</head>
  <body>
  <?php echo dashboard_menu($options['dashboard-menu']); ?>
  <form method="POST" action="">
  <input type="hidden" name="content" id="editor-content">
  <div class="container">
		<div class="col-lg-8 col-offset-2 text-centered placement">
      <div class="error-block"></div>
      <div id="editor"><?php if (isset($options['content'])) echo $options['content']; ?></div>
      <div class="row text-center">
        <div class="btn-group">
          <button type="button" class="btn" id="publication">Save & Publish</button>
          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a data-toggle="modal" href="#post-options">Post Options</a></li>
            <li><a href="#" id="draft">Save to drafts</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="post-options">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Post options</h4>
      </div>
      <div class="modal-body container">
        <div class="col-lg-8 col-offset-2">
          <div class="row">
            <label for="title">Post title:</label>
             <input type="text" name="title" class="form-control" value="<?php if (isset($options['title'])) echo $options['title']; ?>">
          </div>
          <div class="row">
            <label for="category">Category:</label>
            <select name="category" class="form-control" data-style="btn-primary">
              <?php foreach($options['cats'] as $cat): ?>
              <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row">
            <label for="preview">Preview path:</label>
            <!-- <input type="file" name="preview" class="form-control" title="Browse preview"> -->
             <input type="text" name="preview" class="form-control" value="<?php if (isset($options['preview'])) echo $options['preview']; ?>">
          </div>
          <div class="row">
            <label for="tags">Tags. Enter with [, ] separator.</label>
            <input type="text" name="tags" class="form-control" value="<?php if (isset($options['tags'])) echo $options['tags']; ?>">
          </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>
<script src="/Themes/RedcontrolAdmin/libs/trumbowyg/trumbowyg.min.js"></script>
<script src="/Themes/RedcontrolAdmin/libs/bootstrap-input/bootstrap-input.js"></script>
<!-- <script src="/Themes/RedcontrolAdmin/libs/jquery-validate/jquery.validate.min.js"></script> -->
<script>
  $('#editor').trumbowyg();
  $(window).on('load', function () {
      $('input[type=file]').bootstrapFileInput();
  });
  $('document').ready(function(){
    $('#draft').click(function(){
      $('#editor-content').html($('#editor').html());
      $.post('/posts/dashboard/updateUnpublish', $('form').serialize(), function(data){
        $('.error-block').html('').html(data);
      });
    });
    $('#publication').click(function(){
      $('#editor-content').html($('#editor').html());
      $.post('/posts/dashboard/updatePublish', $('form').serialize(), function(data){
        $('.error-block').html('').html(data);
      });
    });
  });
</script>