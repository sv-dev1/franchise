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
         	     <!--  <form id="demo-form2" method='post' data-parsley-validate class="form-horizontal form-label-left"> -->
            <form>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Affiliate Link :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                	<div class='copied'></div>

					<div class="copy-to-clipboard">
                  <input type="text" name="alink" id="myinput" value="<?php echo site_url('register/').$alink; ?>" placeholder="Plan Name" class="form-control col-md-7 col-xs-12" readonly>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                
                 <!--  <button type="submit" class="btn btn-success">Submit</button> -->
                </div>
              </div>
            </form>       
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