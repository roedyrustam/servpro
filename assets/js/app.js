// Sidebar

var BASE_URL = $('#base_url').val();
var $slimScrolls = $('.slimscroll');


    // Sidebar Slimscroll

    if($slimScrolls.length > 0) {
        $slimScrolls.slimScroll({
            height: 'auto',
            width: '100%',
            position: 'right',
            size: '7px',
            color: '#ccc',
            alwaysVisible: true,
            allowPageScroll: false,
            wheelStep: 10,
            touchScrollStep: 100
        });
        var wHeight = $(window).height() - 60;
        $slimScrolls.height(wHeight);
        $('.sidebar .slimScrollDiv').height(wHeight);
        $(window).resize(function() {
            var rHeight = $(window).height() - 60;
            $slimScrolls.height(rHeight);
            $('.sidebar .slimScrollDiv').height(rHeight);
        });
    }

// booking slot Slimscroll

    // Text Editor

    if ($('.book-popup-body').length > 0) {
        $('.book-popup-body').slimScroll({
            height: '230px',
            width: '100%',
            position: 'right',
            size: '5px',
            color: '#ccc',
            distance: '10px',
            alwaysVisible: true,
            allowPageScroll: false,
            wheelStep: 10,
            touchScrollStep: 100
        });
    }



! function($) {
    "use strict";
		var BASE_URL = $('#base_url').val();

    var Sidemenu = function() {
        this.$menuItem = $("#sidebar-menu a");
    };

	Sidemenu.prototype.init = function() {
		var $this = this;
		$this.$menuItem.on('click', function(e) {
		if ($(this).parent().hasClass("submenu")) {
			e.preventDefault();
		}
		if (!$(this).hasClass("subdrop")) {
			$("ul", $(this).parents("ul:first")).slideUp(350);
			$("a", $(this).parents("ul:first")).removeClass("subdrop");
			$(this).next("ul").slideDown(350);
			$(this).addClass("subdrop");
		} else if ($(this).hasClass("subdrop")) {
			$(this).removeClass("subdrop");
			$(this).next("ul").slideUp(350);
		}
	});
		$("#sidebar-menu ul li.submenu a.active").parents("li:last").children("a:first").addClass("active").trigger("click");
	},
	$.Sidemenu = new Sidemenu;

}(window.jQuery),



$(document).ready(function($) {

	// Sidebar Initiate

	$.Sidemenu.init();

    // Sidebar overlay

    var $sidebarOverlay = $(".sidebar-overlay");
    $("#mobile_btn, .task-chat").on("click", function(e) {
        var $target = $($(this).attr("href"));
        if ($target.length) {
            $target.toggleClass("opened");
            $sidebarOverlay.toggleClass("opened");
            $("html").toggleClass("menu-opened");
            $sidebarOverlay.attr("data-reff", $(this).attr("href"));
        }
        e.preventDefault();
    });

    $sidebarOverlay.on("click", function(e) {
        var $target = $($(this).attr("data-reff"));
        if ($target.length) {
            $target.removeClass("opened");
            $("html").removeClass("menu-opened");
            $(this).removeClass("opened");
            $(".main-wrapper").removeClass("slide-nav");
        }
        e.preventDefault();
    });

    // Select 2

    if ($('.select').length > 0) {
        $('.select').select2 ({
            minimumResultsForSearch: -1,
            width: '100%'
        });
    }

    // Page wrapper height

    if ($('.page-wrapper').length > 0) {
        var height = $(window).height();
        $(".page-wrapper").css("min-height", height);
    }

    $(window).resize(function() {
        if ($('.page-wrapper').length > 0) {
            var height = $(window).height();
            $(".page-wrapper").css("min-height", height);
        }
    });

    // Datetimepicker

    if ($('.datetimepicker').length > 0) {
        $('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    }

    // Datatable

    if ($('.datatable').length > 0) {
        $('.datatable').DataTable({
            "bFilter": false,
        });
    }

    // Bootstrap Tooltip

    if ($('[data-toggle="tooltip"]').length > 0) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Mobile Menu

    if ($('.main-wrapper').length > 0) {
        var $wrapper = $(".main-wrapper");
        $('#mobile_btn').on('click',function(){
            $wrapper.toggleClass('slide-nav');
            $('#chat_sidebar').removeClass('opened');
            $(".dropdown.open > .dropdown-toggle").dropdown("toggle");
            return false;
        });
    }

    // Dropdown in Table responsive

    $('.table-responsive').on('shown.bs.dropdown', function(e) {
        var $table = $(this),
            $dropmenu = $(e.target).find('.dropdown-menu'),
            tableOffsetHeight = $table.offset().top + $table.height(),
            menuOffsetHeight = $dropmenu.offset().top + $dropmenu.outerHeight(true);

        if (menuOffsetHeight > tableOffsetHeight)
            $table.css("padding-bottom", menuOffsetHeight - tableOffsetHeight);
    });
    $('.table-responsive').on('hide.bs.dropdown', function() {
        $(this).css("padding-bottom", 0);
    });

    // Chart

    if ($("#areaChart, #bar-example, #donutChart, #area-chart").length > 0) {
        var colors = [
            '#E94B3B',
            '#39C7AA',
            '#1C7EBB',
            '#F98E33',
            '#ad96da'
        ];
        var data = [{
                    y: '2014',
                    a: 50,
                    b: 90
                },
                {
                    y: '2015',
                    a: 65,
                    b: 75
                },
                {
                    y: '2016',
                    a: 50,
                    b: 50
                },
                {
                    y: '2017',
                    a: 75,
                    b: 60
                },
                {
                    y: '2018',
                    a: 80,
                    b: 65
                },
                {
                    y: '2019',
                    a: 90,
                    b: 70
                },
                {
                    y: '2020',
                    a: 100,
                    b: 75
                },
                {
                    y: '2021',
                    a: 115,
                    b: 75
                },
                {
                    y: '2022',
                    a: 120,
                    b: 85
                },
                {
                    y: '2023',
                    a: 145,
                    b: 85
                },
                {
                    y: '2024',
                    a: 160,
                    b: 95
                }
            ],
            config = {
                data: data,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Total Income', 'Total Outcome'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                gridLineColor: '#eef0f2',
                lineColors: ['gray', '#d42129']
            };
        config.element = 'area-chart';
        Morris.Area(config);
        Morris.Line({
            lineColors: colors,
            element: 'areaChart',

            data: [{
                    y: '6',
                    a: 100,
                    b: 40,
                    c: 70,
                    d: 40
                },
                {
                    y: '7',
                    a: 120,
                    b: 60,
                    c: 50,
                    d: 50
                },
                {
                    y: '8',
                    a: 120,
                    b: 90,
                    c: 80,
                    d: 60
                },
                {
                    y: '9',
                    a: 130,
                    b: 120,
                    c: 120,
                    d: 80
                },

            ],
            xkey: 'y',
            ykeys: ['a', 'b', 'c', 'd'],
			resize: true,
            labels: ['Target', 'Starbucks', 'test3', 'test4']
        });
        config.element = 'stacked';
        config.stacked = true;
        Morris.Bar({
            lineColors: colors,
            element: 'bar-example',
            data: [{
                    y: '2006',
                    a: 100,
                    b: 90
                },
                {
                    y: '2007',
                    a: 75,
                    b: 65,
                    c: 20,
                    d: 55
                },
                {
                    y: '2008',
                    a: 50,
                    b: 40,
                    c: 10,
                    d: 55
                },
                {
                    y: '2009',
                    a: 75,
                    b: 65,
                    c: 25,
                    d: 55
                },
                {
                    y: '2010',
                    a: 50,
                    b: 40,
                    c: 30,
                    d: 55
                },
                {
                    y: '2011',
                    a: 75,
                    b: 65,
                    c: 60,
                    d: 55
                },
                {
                    y: '2012',
                    a: 100,
                    c: 80,
                    d: 55
                }
            ],
            xkey: 'y',
            ykeys: ['a', 'b', 'c', 'd'],
			resize: true,
            labels: ['test1', 'test2', 'test3', 'test4']
        });
        Morris.Donut({
            element: 'donutChart',
            data: [{
                    value: 40,
                    label: 'Tasks'
                },
                {
                    value: 15,
                    label: 'Clients'
                },
                {
                    value: 45,
                    label: 'Projects'
                },
                {
                    value: 30,
                    label: 'Employees'
                },
                {
                    value: 15,
                    label: 'Messages'
                },
            ],
            labelColor: '#333',
			resize: true,
            colors: colors
        });
    }
});

$("#loginSubmit").on("click", function(){
  $("#adminSignIn").submit();
});

			     $('#adminSignIn').bootstrapValidator({
            fields: {
            	username:   {
                    validators:          {
                    notEmpty:              {
                            message: 'Please enter your Username'
                                           }
                                         }
                                        },
                    password:           {
                    validators:           {
                    notEmpty:               {
                            message: 'Please enter your Password'
                                            }
                                          }
                                        }
    		}
        }).on('success.form.bv', function(e) {

        var username = $('#username').val();
           var password = $('#password').val();
    $.ajax({
           type:'POST',
           url: base_url+'admin/login/is_valid_login',
           data : {username:username,password:password},
           success:function(response)
           {
         if(response==1)
         {
             window.location = base_url+'dashboard';
         }
         else {
            location.reload();
         }
           }
            });
    return false;
        });  // admin login success function completes here

        $('#addSubscription').bootstrapValidator({
            fields: {
            	subscription_name:   {
                    validators: {
                      remote: {
                        url: base_url + 'service/check_subscription_name',
                        data: function(validator) {
                            return {
                                subscription_name: validator.getFieldElements('subscription_name').val()
                            };
                        },
                        message: 'This subscription name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter subscription name'

                    }
                  }
                },
                    amount:           {
                    validators:           {
                    notEmpty:               {
                            message: 'Please enter subscription amount'
                                            }
                                          }
                                        },
                    duration:           {
                    validators:           {
                    notEmpty:               {
                            message: 'Please select subscription duration'
                                            }
                                          }
                                        }
    		}
        }).on('success.form.bv', function(e) {

        var subscription_name = $('#subscription_name').val();
        var fee_description = $('#subscription_description').val();
        var amount = $('#amount').val();
        var duration = $('#duration').val();
        var status = $('input[name="status"]:checked').val();
    $.ajax({
           type:'POST',
           url: base_url+'service/save_subscription',
           data : {subscription_name:subscription_name,fee_description:fee_description,subscription_amount:amount,subscription_duration:duration,status:status},
           success:function(response)
           {
         if(response==1)
         {
             window.location = base_url+'subscriptions';
         }
         else
         {
             window.location = base_url+'subscriptions';
         }
           }
            });
                return false;
        });  // admin login success function completes here

          $('#add_category').bootstrapValidator({
            fields: {
                category_name:   {
                    validators: {
                      remote: {
                        url: base_url + 'categories/check_category_name',
                        data: function(validator) {
                            return {
                                category_name: validator.getFieldElements('category_name').val()
                            };
                        },
                        message: 'This category name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter category name'

                    }
                  }
                },
                category_image: {
                validators: {
                notEmpty: {
                            message: 'Please upload category image'
                },
                file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: 'Invalid extension (only allow "png", "jpg" with maximum 2MB size)'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            return true;
        });

        $('#update_category').bootstrapValidator({
            fields: {
                category_name:   {
                    validators: {
                      remote: {
                        url: base_url + 'categories/check_category_name',
                        data: function(validator) {
                            return {
                                category_name: validator.getFieldElements('category_name').val(),
                                category_id: validator.getFieldElements('category_id').val()
                            };
                        },
                        message: 'This category name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter category name'
                    }
                  }
                },
                category_image:{
                    validators:{
                    file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: 'Invalid extension (only allow "png", "jpg" with maximum 2MB size)'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            return true;
        });  // admin login success function completes here

        $('#add_subcategory').bootstrapValidator({
            fields: {
                subcategory_name:   {
                    validators: {
                      remote: {
                        url: base_url + 'categories/check_subcategory_name',
                        data: function(validator) {
                            return {
                                category: validator.getFieldElements('category').val(),
                                subcategory_name: validator.getFieldElements('subcategory_name').val()
                            };
                        },
                        message: 'This sub category name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter sub category name'

                    }
                  }
                },
                subcategory_image: {
                validators: {
                notEmpty: {
                        message: 'Please upload category image'
                    },
                    file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: 'Invalid extension (only allow "png", "jpg" with maximum 2MB size)'
                        }
                    }
                },
                category:  {
                validators:  {
                notEmpty: {
                    message: 'Please select category'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {

                return true;
        });



        $('#update_subcategory').bootstrapValidator({
            fields: {
                subcategory_name:   {
                    validators: {
                      remote: {
                        url: base_url + 'categories/check_subcategory_name',
                        data: function(validator) {
                            return {
                                category: validator.getFieldElements('category').val(),
                                subcategory_name: validator.getFieldElements('subcategory_name').val(),
                                subcategory_id: validator.getFieldElements('subcategory_id').val()
                            };
                        },
                        message: 'This sub category name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter sub category name'

                    }
                  }
                },

                category:           {
                    validators:           {
                    notEmpty:               {
                            message: 'Please select category'
                                            }
                                          }
                                        },
                subcategory_image: {
                    validators:{
                        file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: 'Invalid extension (only allow "png", "jpg" with maximum 2MB size)'
                        }
                    }
                }

            }
        }).on('success.form.bv', function(e) {
            return true;
        });  // admin login success function completes here

         $('#add_ratingstype').bootstrapValidator({
            fields: {
                name:   {
                    validators: {
                      remote: {
                        url: base_url + 'ratingstype/check_ratingstype_name',
                        data: function(validator) {
                            return {
                                category_name: validator.getFieldElements('name').val()
                            };
                        },
                        message: 'This Rating type name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter rating type name'

                    }
                  }
                },
            }
        }).on('success.form.bv', function(e) {
                return true;
        });

        $('#update_ratingstype').bootstrapValidator({
            fields: {
                name:   {
                    validators: {
                      remote: {
                        url: base_url + 'ratingstype/check_ratingstype_name',
                        data: function(validator) {
                            return {
                                name: validator.getFieldElements('name').val(),
                                id: validator.getFieldElements('id').val()
                            };
                        },
                        message: 'This rating type name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter rating type name'

                    }
                  }
                },

            }
        }).on('success.form.bv', function(e) {


    return true;
        });  // admin login success function completes here




        $("#duration").on("change", function(){
          var description = $("#duration option:selected").text();
          $("#subscription_description").val(description);
        })

        $('#editSubscription').bootstrapValidator({
            fields: {
            	subscription_name:   {
                    validators: {
                      remote: {
                        url: base_url + 'service/check_subscription_name',
                        data: function(validator) {
                            return {
                                subscription_name: validator.getFieldElements('subscription_name').val(),
                                subscription_id: validator.getFieldElements('subscription_id').val()
                            };
                        },
                        message: 'This subscription name is already exist',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter subscription name'

                    }
                  }
                },
                    amount:           {
                    validators:           {
                    notEmpty:               {
                            message: 'Please enter subscription amount'
                                            }
                                          }
                                        },
                    duration:           {
                    validators:           {
                    notEmpty:               {
                            message: 'Please select subscription duration'
                                            }
                                          }
                                        }
    		}
        }).on('success.form.bv', function(e) {

        var subscription_id = $('#subscription_id').val();
        var subscription_name = $('#subscription_name').val();
        var fee_description = $('#subscription_description').val();
        var amount = $('#amount').val();
        var duration = $('#duration').val();
        var status = $('input[name="status"]:checked').val();
    $.ajax({
           type:'POST',
           url: base_url+'service/update_subscription',
           data : {subscription_id:subscription_id,subscription_name:subscription_name,fee_description:fee_description,subscription_amount:amount,subscription_duration:duration,status:status},
           success:function(response)
           {
         if(response==1)
         {
             window.location = base_url+'subscriptions';
         }
         else
         {
             window.location = base_url+'subscriptions';
         }
           }
            });
    return false;
        });  // admin login success function completes here

        $('#addKeyword').bootstrapValidator({
            fields: {
                    multiple_key:           {
                    validators:           {
                    notEmpty:               {
                            message: 'Please enter keyword'
                                            }
                                          }
                                        }
    		}
        }).on('success.form.bv', function(e) {

        var page_key = $('#page_key').val();
        var multiple_key = $('#multiple_key').val();
    $.ajax({
           type:'POST',
           url: base_url+'admin/language/save_keywords',
           data : {page_key:page_key,multiple_key:multiple_key},
           success:function(response)
           {
             if(response==1)
             {
                 window.location = base_url+'language/'+page_key;
             }
           }
            });
    return false;
        });  // admin login success function completes here
    function update_language(lang_key, lang, page_key)
    {
      var cur_val = $('input[name="'+lang_key+'['+lang+']"]').val();
      var prev_val = $('input[name="prev_'+lang_key+'['+lang+']"]').val();

      $.post(base_url+'admin/language/update_language',{lang_key:lang_key, lang:lang, cur_val:cur_val, page_key:page_key},function(data){
        if(data == 1)
        {
          $("#flash_success_message").show();
        }
        else if(data == 0)
        {
          $('input[name="'+lang_key+'['+lang+']"]').val(prev_val);
          $("#flash_error_message").html('Sorry, This keyword already exist!');
          $("#flash_error_message").show();
        }
        else if(data == 2)
        {
          $('input[name="'+lang_key+'['+lang+']"]').val(prev_val);
          $("#flash_error_message").html('Sorry, This field should not be empty!');
          $("#flash_error_message").show();
        }
      });

    }

  function changeAdminProfile(){
  $('#image_error').hide();
  var profile_img = $('#crop_prof_img').val();
  var error = 0;
  if(profile_img==""){
    error =1;
    $('#image_error').show();
  }else{
    $('#image_error').hide();
  }
  if(error==0){
   var url = base_url+'admin/profile/update_profile';
      //fetch file
      var formData = new FormData();
      formData.append('profile_img', profile_img);
      $.ajax({
        url: url,
        type: "POST",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        context: this,
        success:function(res)
        {
          window.location.href=base_url+'admin-profile';
			}
		});
  }
}

/* Search and advance search End */
  $("#cform_submit").on("click",function(e){
			e.preventDefault();
			$('#current_block_error').hide();
			$('#current_chkblock_error').hide();
			$('#new_block_error').hide();
			$('#new_blockchk_error').hide();
			$('#passwordchk_error').hide();
			$('#repeat_block_error').hide();
			$('#repeat_chkblock_error').hide();
			var current_password = $('#current_password').val();
			var new_password = $('#new_password').val();
			var repeat_password = $('#confirm_password').val();
			var passReg = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,20}$/;
			var error =0;
			if(current_password==""){
				error =1;
				$('#current_block_error').show();
                return false;
			}else{
				$('#current_block_error').hide();
                if(error==0){

                var url = base_url+'admin/profile/check_password';
                var request = $.ajax({
          url: url,
          type: "post",
          data: {'current_password': current_password},
        success: function(response) {
                    if(response==0){
                    $('#current_chkblock_error').show();
                    return false;
                    }
                    else{
                        $('#current_chkblock_error').hide();
                         $('#change_password_form').submit();
                    }
        }
            });
            }
			}
			if(new_password==""){
				error =1;
				$('#new_block_error').show();
                return false;
			}else{
				$('#new_block_error').hide();
				if(!passReg.test(new_password)){
					error = 1;
					$('#passwordchk_error').show();
                    return false;
				}else{
				 $('#passwordchk_error').hide();
	 				if(new_password == current_password)
	 				{
	 					error =1;
	 					$('#new_blockchk_error').show();
                        return false;
	 				}
					else {
	 					$('#new_blockchk_error').hide();					}
				}
			}
			if(repeat_password==""){
				error =1;
				$('#repeat_block_error').show();
                return false;
			}else{
				$('#repeat_block_error').hide();
					if(repeat_password!=new_password){
						error =1;
						$('#repeat_chkblock_error').show();
                        return false;
					}else{
						$('#repeat_chkblock_error').hide();
					}
			}


            if(error==0){

                var url = base_url+'admin/profile/check_password';
                var request = $.ajax({
                    url: url,
                    type: "post",
                    data: {'current_password': current_password},
                    success: function(response) {
                        if(response==0){
                        $('#current_chkblock_error').show();
                        return false;
                        }
                        else{
                        $('#current_chkblock_error').hide();
                        $('#change_password_form').submit();
                        }
                    }
                });
            }
		});
$("#selectallall1").on('click',function() {
				$(".checkboxad").prop('checked', $(this).prop('checked'));
				var checkboxValues = [];
				$('.checkboxad:checked').each(function (index, elem) {
					checkboxValues.push($(elem).val());
				});
			});

  function delete_category(id)
  {
    $('#delete_category').modal('show');
    $('#category_id').val(id);
  }

 function delete_adminlist(id)
  {
    $('#delete_adminlist').modal('show');
    $('#admin_id').val(id);
  }
function delete_userlist(id)
  {
    $('#delete_userlist').modal('show');
    $('#userid').val(id);
  }
  

  function delete_subcategory(id)
  {
    $('#delete_subcategory').modal('show');
    $('#subcategory_id').val(id);
  }

 function delete_ratings_type(id)
  {
    $('#delete_ratings_type').modal('show');
    $('#id').val(id);
  }

  $('[data-toggle="tooltip"]').tooltip();

    // Small Sidebar

    $(document).on('click', '#toggle_btn', function() {
        if($('body').hasClass('mini-sidebar')) {
            $('body').removeClass('mini-sidebar');
            $('.subdrop + ul').slideDown();
        } else {
            $('body').addClass('mini-sidebar');
            $('.subdrop + ul').slideUp();
        }
        setTimeout(function(){
            mA.redraw();
            mL.redraw();
        }, 300);
        return false;
    });

        $(document).on('mouseover', function(e) {
        e.stopPropagation();
        if($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
            var targ = $(e.target).closest('.sidebar').length;
            if(targ) {
                $('body').addClass('expand-menu');
                $('.subdrop + ul').slideDown();
            } else {
                $('body').removeClass('expand-menu');
                $('.subdrop + ul').slideUp();
            }
            return false;
        }

        $(window).scroll(function() {
      if ($(window).scrollTop() >= 30) {
        $('.header').addClass('fixed-header');
      } else {
        $('.header').removeClass('fixed-header');
      }
    });

    });
