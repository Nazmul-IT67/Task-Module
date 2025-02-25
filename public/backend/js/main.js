// $(function ($) {
//     // USE STRICT
//     "use strict";

//     $('.select2').select2();
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     // delete confirm alert
//     $(".confirm-delete").click(function (e) {
//         e.preventDefault();
//         var url = $(this).data("href");
//         $("#deleteModal").modal("show");
//         $("#delete-link").attr("action", url);
//     });
//     // trash confirm alert
//     $(".confirm-trash").click(function (e) {
//         e.preventDefault();
//         var url = $(this).data("href");
//         $("#trashModal").modal("show");
//         $("#trash-link").attr("action", url);
//     });
//     // restore confirm alert
//     $(".confirm-restore").click(function (e) {
//         e.preventDefault();
//         var url = $(this).data("href");
//         $("#restoreModal").modal("show");
//         $("#restore-link").attr("action", url);
//     });

//     $(document).on('change', '[name=country_id]', function () {
//         var country_id = $(this).val();
//         get_states(country_id);
//     });

//     $(document).on('change', '[name=state_id]', function () {
//         var state_id = $(this).val();
//         get_city(state_id);
//     });

//     function get_states(country_id) {
//         $('[name="state_id"]').html("");
//         $.ajax({
//             url: "/get-state",
//             type: 'POST',
//             data: {
//                 country_id: country_id
//             },
//             success: function (response) {
//                 var obj = JSON.parse(response);
//                 if (obj != '') {
//                     $('[name="state_id"]').html(obj);
//                 }
//             }
//         });
//     }

//     function get_city(state_id) {
//         $('[name="city_id"]').html("");
//         $.ajax({
//             url: "/get-city",
//             type: 'POST',
//             data: {
//                 state_id: state_id
//             },
//             success: function (response) {
//                 var obj = JSON.parse(response);
//                 if (obj != '') {
//                     $('[name="city_id"]').html(obj);
//                 }
//             }
//         });
//     }

//     $('.flag-changer').select2({
//         templateResult: flagStyles
//     });

//     function flagStyles(selection) {
//         if (!selection.id) { return selection.text; }
//         var thumb = $(selection.element).data('thumb');
//         if (!thumb) {
//             return selection.text;
//         } else {
//             var $selection = $(
//                 //   '<img src="' + thumb + '" alt=""><span class="img-changer-text">' + $(selection.element).text() + '</span>'
//                 '<div class=""><img src="' + thumb + '" class="mr-2"><span>' + $(selection.element).text() + '</span></div>'
//             );
//             return $selection;
//         }
//     }

//     $(".lang-change").click(function () {
//         var lang = $(this).data('flag');
//         if (lang) {
//             $.ajax({
//                 url: "/get-city",
//                 type: 'POST',
//                 data: {
//                     lang: lang
//                 },
//                 success: function (response) {
//                     var obj = JSON.parse(response);
//                     if (obj != '') {
//                         $('[name="city_id"]').html(obj);
//                     }
//                 }
//             });
//         }
//     });

//     //custom jquery method for toggle attr
//     $.fn.toggleAttr = function (attr, attr1, attr2) {
//         return this.each(function () {
//             var self = $(this);
//             if (self.attr(attr) == attr1) self.attr(attr, attr2);
//             else self.attr(attr, attr1);
//         });
//     };
// });
