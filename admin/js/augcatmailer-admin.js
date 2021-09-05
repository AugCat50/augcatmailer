(function( $ ) {
	'use strict';
    
	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
    
    $( window ).load(function() {
        let fieldList = new Array();
        let i = 0;
        
        //Добавить поле
        //Собираем данные по полям, удаляем невалидные символы, формируем html таблицы
        $('.js_am__add-sect').on('click', '.js_am__add-field', function() {
            let field = new Object();
            field.type          = $('.js_am_field-type').val();
            field.class         = $('.js_am_field-class').val().replace(         /[^a-zA-Z0-9\-\_\s]/g, '' );
            field.placeholder   = $('.js_am_field-placeholder').val().replace(   /[^a-zA-Z0-9\-\_\s]/g, '' );
            field.label         = $('.js_am_field-label').val().replace(         /[^a-zA-Z0-9\-\_\s]/g, '' );
            field.label_class   = $('.js_am_field-label-class').val().replace(   /[^a-zA-Z0-9\-\_\s]/g, '' );
            field.wrapper       = $('.js_am_field-wrapper').val().replace(       /[^a-zA-Z0-9\-\_\s]/g, '' );
            field.wrapper_class = $('.js_am_field-wrapper-class').val().replace( /[^a-zA-Z0-9\-\_\s]/g, '' );
            
            //0 поле зарезервировано для имени и классов формы, будут заполнены при сохранении
            i++;
//            console.log("i = "+i);
            
            //Массив объектов-полей
            fieldList[i] = field;
//            console.log(fieldList);
            
            //Построение html строки таблицы, которая добавится в список созданных полей формы
            let fHtml = '<td class="js_am_td-type">' + field.type + '</td>';
            if ( field.class !== '') {
                fHtml += '<td class="js_am_td-class">' + field.class + '</td>';
            } else {
                fHtml += '<td class="js_am_td-class"></td>';
            }
            if ( field.placeholder !== '') {
                fHtml += '<td class="js_am_td-placeholder">' + field.placeholder + '</td>';
            } else {
                fHtml += '<td class="js_am_td-placeholder"></td>';
            }
            if ( field.label !== '') {
                fHtml += '<td class="js_am_td-label">' + field.label + '</td>';
            } else {
                fHtml += '<td class="js_am_td-label"></td>';
            }
            if ( field.label_class !== '') {
                fHtml += '<td class="js_am_td-label-class">' + field.label_class + '</td>';
            } else {
                fHtml += '<td class="js_am_td-label-class"></td>';
            }
            if ( field.wrapper !== '') {
                fHtml += '<td class="js_am_td-wrapper">' + field.wrapper + '</td>';
            } else {
                fHtml += '<td class="js_am_td-wrapper"></td>';
            }
            if ( field.wrapper_class !== '') {
                fHtml += '<td class="js_am_td-wrapper-class">' + field.wrapper_class + '</td>';
            } else {
                fHtml += '<td class="js_am_td-wrapper-class"></td>';
            }
            
            //Выводим представление
            $('.js_am_no-fields').attr('hidden', true);
            $('.js_am_fields-table').attr('hidden', false);
            $('.js_am_fields-table').append('<tr class="js_am_row" list="' + i + '"><td><input type="number" class="am_field-order js_am_field-order" value="' + i + '"></td>' + fHtml + '<td><button class="js_am_field-del">Delete</button></td></tr>');
        });
        
        //Удалить поле, затираем элемент в массиве
        $('.js_am__add-sect').on('click', '.js_am_field-del', function() {
            let j        = $(this).closest('.js_am_row').attr('list');
//            fieldList[j] = "";
            fieldList.splice(j-1, 1);
            $(this).closest('.js_am_row').remove();
        });
        
        //Сохранить форму
        $('.js_am__add-sect').on('click', '.js_am__save-form', function() {
            
            //Проверяем добавлены ли поля
            if($("input").is(".js_am_field-order")) {
                fieldList[0]           = new Object();
                fieldList[0].formName  = $('.js_am__form-name').val();
                fieldList[0].formClass = $('.js_am__form-class').val().replace( /[^a-zA-Z0-9\-\_\s]/g, '' );
                
                //Перебор таблицы в цикле, сбор и добавление данных о сортировке
                $('.js_am_row').each(function(i,elem) {
                    let j = $(this).attr('list');
                    let order = $(this).find('.js_am_field-order').val();
                    fieldList[j].order = order;
                });
                
                let formData = JSON.stringify(fieldList);
                console.log(formData);
                
                //Отправляем данные на сервер
                ajaxQuery ('save_form', formData, '.js_am__system-message');
            } else {
                $('.js_am_fields-table').attr('hidden', true);
                $('.js_am_no-fields').html('<strong style="color: red;">Add fields to your form!</strong>');
                $('.js_am_no-fields').attr('hidden', false);
            }
        });
        
        //Получить код формы по имени
        $('.js_am__list-sect').on('click', '.js_list__form-name', function() {
            let name = $(this).html();
            ajaxQuery ('get_form', name, '.js_am__system-message');
        });
        
        
        function ajaxQuery (action, data, clss){
            
                $.ajax({
				    type     : 'POST', // define the type of HTTP verb we want to use (POST for our form)
//				    url      : '/wordpress/wp-content/plugins/augcatmailer/augcatmailer.php', // the url where we want to POST
                    url      : ajaxurl, // the url where we want to POST
				    data     : {
                        action: action,
                        data:   data
                    }, // our data object
					dataType : 'text', // what type of data do we expect back from the server
					encode   : true,
					success  : function(msg) {
//                        var ret = $.parseJSON(JSON.stringify(msg));
//						var ret = $.parseJSON(JSON.stringify(msg));
//						response.html(ret.message).fadeIn(500);
                        $(clss).html('<p>'+msg+'</p>');
                        
                        if(action === 'save_form' || action === 'del_form' ) {
                            ajaxQuery('get_list', false, '.js_am__list-sect__wrapper');
                        }
				    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $(clss).html('<p>'+msg+'</p>');
                    }
				});
            
//            $.ajax({
//                url: window.location.hostname + '/wordpress/wp-content/plugins/augcatmailer/augcatmailer.php',
//                method: 'post',
//                data: {
//                    action: action,
//                    data:   data
//                },
//                success: function(msg){
////                    $(clss).html(msg);
////                    
////                    //Если список позиций пуст, выводим сообщение
////                    let hummer = $(".second_menu").html();
////                    if(hummer===""){
////                        $(".sizes_table").html("Список позиций пуст.");
////                    }
//                }
//        });
    }
        
        
        
        
        
        
        
        
        
        
        
        
        /* ---------------------------------------------- /*
		 * Contact form ajax
		/* ---------------------------------------------- */

		$('#contact-form1').submit(function(e) {

			e.preventDefault();

			var c_name = $('#c_name').val();
			var c_email = $('#c_email').val();
			var c_message = $('#c_message ').val();
			var response = $('#contact-form .ajax-response');
			
			var formData = {
				'name'       : c_name,
				'email'      : c_email,
				'message'    : c_message
			};
            
			if (( c_name== '' || c_email == '' || c_message == '') || (!isValidEmailAddress(c_email) )) {
				response.fadeIn(500);
				response.html('<i class="fa fa-warning"></i> Please fix the errors and try again.');
			} else {
					 $.ajax({
							type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
							url         : 'wp-content/themes/portfolio/assets/php/contact.php', // the url where we want to POST
							data        : formData, // our data object
							dataType    : 'json', // what type of data do we expect back from the server
							encode      : true,
							success		: function(res){
											var ret = $.parseJSON(JSON.stringify(res));
											response.html(ret.message).fadeIn(500);
							}
						});
            }           
            return false;
});
    });

})( jQuery );
