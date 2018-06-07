<?php 
$uid = $this->session->userdata('user_id');
$unameArray = $this->db->get_where('users',array('id' => $uid));
$getName = $unameArray->row();
$uname = $getName->username;
echo $uname;
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Organization Chart Plugin</title>
<link rel="stylesheet" href="<?php echo site_url() ?>assets/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo site_url() ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo site_url() ?>assets/css/jquery.orgchart.css">
</head>
<body>
  <div id="chart-container"></div>

<!-- <script src="//code.jquery.com/jquery-1.12.0.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="<?php echo site_url() ?>assets/js/html2canvas.min.js"></script>
<script src="<?php echo site_url() ?>assets/js/jquery.orgchart.js"></script>
  <script type="text/javascript">
    $(function() {
   // window.$ = require('jquery')(window);
      var datascource = {
      'name': '<?php echo $uname; ?>',
      'title': 'Admin',
      'children': 
      <?php echo $childrenArray; ?>    
    };

    $('#chart-container').orgchart({
      'data' : datascource,
      'nodeContent': 'title',
    });

  });
  </script>
  </body>
</html>