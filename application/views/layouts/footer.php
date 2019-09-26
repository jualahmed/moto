
<footer class="main-footer" >
  <input name="ret_and_sel" type="hidden" id="ret_and_sel" value="<?php echo base_url();?>extra_controller/retrive_and_select" />
  <input name="ret_and_sel_with_id" type="hidden" id="ret_and_sel_with_id" value="<?php echo base_url();?>extra_controller/retrive_and_select_with_id" />
    <div class="pull-right hidden-xs" style="color: #405367;margin-top:5px;">
      &#169; <?php echo $this->tank_auth->get_shopname(); ?>, <?php echo $this->tank_auth->get_shopaddress(); ?>.
    </div>
  <p style="color: #405367;margin-top:5px;"><i class="fa fa-cog fa-spin fa-lg fa-fw"></i>Dokani Developed by 
    <span class="lead"> 
      <a href="http://www.itlabsolutions.com" target="_blank" id="companyTitle"> 
        <img id="footerLogo" style="width:30px;" src="<?php echo base_url();?>images/itlablogo.png"/> IT Lab Solutions Ltd.<sup>&reg;</sup> 
      </a>
    </span> +8801842485222
  </p>
</footer>
 </div>

<script>
  var base_url="<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url();?>assets/assets2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/dist/js/app.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.scrollbar.min.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>


<?php if(isset($vuejscomp)){ ?>
  <script src="<?php echo base_url();?>assets/vuejs/vue.min.js"></script>
  <script src="<?php echo base_url();?>assets/vuejs/vue-select.js"></script>
  <script src="<?php echo base_url();?>assets/vuejs/vue-multiselect.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vuejs/vue-multiselect.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vuejs/vue-select.css">
  <script src="<?php echo base_url();?>assets/vuejs/vuejs-datepicker.min.js"></script>
  <script src="<?php echo base_url();?>assets/vuejs/vuejscomp/<?php echo $vuejscomp ?>"></script>
<?php } ?>
</body>
</html>
