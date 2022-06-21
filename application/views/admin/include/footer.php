<style type="text/css">
    /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .3s;
  transition: .3s;
}

input:checked + .slider {
  background-color: #228B22;
}

input:focus + .slider {
  box-shadow: 0 0 0px #8B0000;
}

input:checked + .slider:before {
  -webkit-transform: translateX(16px);
  -ms-transform: translateX(16px);
  transform: translateX(16px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 20px;
}

.slider.round:before {
  border-radius: 40%;
}
</style>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
          <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

    <script type="text/javascript">var base_url = "<?php echo $base_url; ?>";</script>
    <script type="text/javascript" src="<?php echo $base_url; ?>assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/front_end/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/tagsinput.js"></script>

    
    <?php  $page = $this->uri->segment(1);
    if($page == 'dashboard'){ ?>
      <script type="text/javascript" src="<?php echo $base_url; ?>assets/plugins/morris/morris.min.js"></script>
      <script type="text/javascript" src="<?php echo $base_url; ?>assets/plugins/raphael/raphael-min.js"></script>
      <script>
        var $arrColors = ['#00839a', '#00839a',  '#00839a', '#00839a'];
        var json = (function () {
          var json = null;
          $.ajax({
            'async': false,
            'global': false,
            'url': "<?php echo $base_url; ?>" + "dashboard/provider_request_chart_details",
            'dataType': "json",
            'success': function (data) {
              json = data;
            }
          });
          return json;
        })
        ();
        var testData = json;
        Morris.Bar({
          element: 'provide-request-bar-graph',
          data: testData,
          xkey: 'x',
          ykeys: ['y', 'z'],
          labels: ["Requests", 'Provides'],
          barColors: function (row, series, type) {
            return $arrColors[row.x];
          }, 
        });
      </script>
    <?php }  ?>
    <script src="<?php echo $base_url; ?>assets/js/bootstrapValidator.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/app.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/admin.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/language.js"></script>
    <script>setTimeout(function(){ $('#flash_success_message').hide(); }, 5000);</script>
    <script>setTimeout(function(){ $('#flash_succ_message').hide(); }, 5000);</script>
    <script>setTimeout(function(){ $('#flash_error_message').hide(); }, 5000);</script>
    <?php	if($page == 'admin-profile'){ ?>
      <script type="text/javascript" src="<?php echo $base_url; ?>assets/js/cropper_profile.js"></script>
      <script type="text/javascript" src="<?php echo $base_url; ?>assets/js/cropper.min.js"></script>
    <?php } ?>
    <?php  if($page=='categories' || $page=='sub-categories' || $page=='ratings-type' || $page == 'service-requests' || $page == 'language' || $page == 'users'){ ?>
      <script src="<?php echo $base_url; ?>assets/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function(){
          $('.categories_table').DataTable();
        });
        $(document).ready(function(){
          $('.ratingstype_table').DataTable();
        });
      </script>
    <?php } if($page == 'service-providers'){ ?>
    <script src="<?php echo $base_url; ?>assets/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo $base_url; ?>assets/js/bootstrap-toggle.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
            $('.toggle-demo').bootstrapToggle();

          providers_table = $('#providers_table').on( 'init.dt', function () {
            $('.toggle-demo').bootstrapToggle();
          } ).DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "ordering": false,
            "ajax": {
              "url": "<?php echo site_url('provider_list')?>",
              "type": "POST",
              "data": function ( data ) {

              },

            },
            "columnDefs": [
            {
            "targets": [ 5 ], //first column / numbering column
            "orderable": false, //set not orderable
          },
          ],

        });

        });

        function change_Status(id)
        {
         var stat= $('#status_'+id).prop('checked');

         if(stat==true)
         {
           var status=1;
         }
         else
         {
           var status=0;
         }
         $.post('<?php echo base_url();?>admin/service/change_Status',{id:id,status:status},function(data){

         });

       }


       function delete_service(id) {
        if(confirm("Are you sure you want to delete this provider?")){
          $.post('<?php echo base_url();?>admin/service/delete_provider',{id:id},function(result){
            if(result)
            {

              window.location.reload();
            }
          });

        }   
      }

    </script>
  <?php } ?>



  <script type="text/javascript">
    

    language_web_table = $('#language_web_table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "ajax": {
              "url": "<?php echo site_url('language_web_list')?>",
              "type": "POST",
              "data": function ( data ) {

              }
            },
            "columnDefs": [
            {
            "targets": [  ], //first column / numbering column
            "orderable": false, //set not orderable
          },
          ],

        });
    
      </script>



      <?php  if($page == 'service-requests'){ ?>
       <script type="text/javascript">
        $(document).ready(function() {

          requests_table = $('#requests_table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "ajax": {
              "url": "<?php echo site_url('request_list')?>",
              "type": "POST",
              "data": function ( data ) {}
            },
            "columnDefs": [
            {
            "targets": [ 7 ], //first column / numbering column
            "orderable": false, //set not orderable
          },
          ],

        });
        });
      </script>
    <?php } ?>

    <?php  if($page == 'users'){  ?>
      <script src="<?php echo $base_url; ?>assets/js/bootstrap-toggle.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {

          users_table = $('#users_table').on( 'init.dt', function () {
            $('.toggle-demo').bootstrapToggle();
          } ).DataTable({
            "paging": true,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "ordering": false,
            "ajax": {
              "url": "<?php echo site_url('users_list')?>",
              "type": "POST",
              "data": function ( data ) {}
            },
            "columnDefs": [
            {
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
          },
          ],

        });

        });

        function change_Status(id)
        {
         var stat= $('#status_'+id).prop('checked');

         if(stat==true)
         {
           var status=1;
         }
         else
         {
           var status=0;
         }
         $.post('<?php echo base_url();?>admin/dashboard/change_Status',{id:id,status:status},function(data){

         });

       }
     </script>
   <?php } ?>
   <?php
   $page_id = $this->uri->segment(2);
   if($page == 'language'){ ?>
     <script type="text/javascript">
      $(document).ready(function() {

        language_table = $('#language_table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "ajax": {
              "url": "<?php echo site_url('language_list')?>",
              "type": "POST",
              "data": function ( data ) {
                data.page_key = "<?php echo $page_id ?>"
              }
            },
            "columnDefs": [
            {
            "targets": [  ], //first column / numbering column
            "orderable": false, //set not orderable
          },
          ],

        });
      });
    </script>
  <?php } ?>

  <script type="text/javascript">
    $(document).ready(function(){     
      $('#form_emailsetting').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
          email_address:   {
            validators:          {
              notEmpty:              {
                message: 'Please enter a Email'
              },
              emailAddress: {
                message: 'Please enter valid email address'
              }
            }
          },
          email_tittle:   {
            validators:          {
              notEmpty:              {
                message: 'Please enter a Title'
              }
            }
          },
          email_host:   {
            validators:          {
              notEmpty:              {
                message: 'Please enter a Host Name'
              }
            }
          },
          email_port:   {
            validators:          {
              notEmpty:              {
                message: 'Please enter a Port Number'
              }
            }
          }

        }
      });
    });

    $(document).ready(function() {
  $("#selectallad1").change(function(){
    if(this.checked){
      $(".checkboxad").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkboxad").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkboxad").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkboxad").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#selectallad1").prop("checked", true); }     
    }else {
      $("#selectallad1").prop("checked", false);
    }
  });

  if ($(".checkboxad").is(":checked")){
      var isAllChecked = 0;
      $(".checkboxad").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#selectallad1").prop("checked", true); }     
    }else {
      $("#selectallad1").prop("checked", false);
    }
});
  
  </script>

  <script src="<?php echo $base_url; ?>assets/js/summernote.js"></script>
  <script type="text/javascript">

</script>

</body>

</html>
