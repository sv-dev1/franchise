<head>
<style>
.copy-to-clipboard input {
	border: none;
	background: transparent;
}

.copied {
    position: absolute;
    background: #696969;
    color: #fff;
    font-weight: normal;
    z-index: 99;
    width: 100px;
    top: -27px;
    text-align: center;
    padding: 5px;
    display: none;
    font-size: 10px;
    left: 0;
    right: 0;
    margin: auto;
}
.ln_solid {
   border-top: none; 
    background-color: transparent; 
}
.copy-to-clipboard input {
    padding: 10px !important;
    height: 26px;
    width: 95%;
}
</style>
</head>
<div class="right_col" role="main">
  <div class="">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel1">
           <table style="width:100%,border=1" class="table-bordered">
  <tr>
    <th>Bonus Estagio</th>
    <th>Bonus Direct</th> 
    <th>Bonus Indirect</th>
    <th>Fast Bonus</th>
    <th>Assistent Bonus</th>
    <th>Equivalence Bonus</th>
  </tr>
  <tr>
    <td><?php echo $bonus_estagio; ?></td>
    <td><?php echo $bonus_direct; ?></td> 
    <td><?php echo $bonus_indirect ?></td>
    <td><?php echo $fast_bonus ?></td>
    <td><?php echo $equivalence_bonus ?></td>
  </tr>
</table>	 
          
        </div>
      </div>
    </div>             
  </div>


<script>
$(document).ready(function(){
	$(function() {
	$('.copy-to-clipboard input').click(function() {
	$(this).focus();
	$(this).select();
	document.execCommand('copy');
	$(".copied").text("Copied to clipboard").show().fadeOut(1200);
    });
});
});
</script>