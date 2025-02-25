<script>
    $(function() {
        "use strict";
        $(".meta-keyward").select2({
            tags: true,
            placeholder: "Meta keyward",
            width: "100%"
        });
        $('.seo-page-checkbox').on('change', function() {

            if ($(this).is(":checked")) {
                $(".seo-content").show();
            } else {
                $(".seo-content").hide();
            }
        })
        $('.seo-page-checkbox').trigger('change');

        $(".add-element").draggable({
            helper: function(event, ui) {
                return $(this).clone().removeClass("add-element").addClass("draggable-element")
                    .appendTo(".active_widget_list")
                    .css({
                        "zIndex": 5,

                    }).show();
            },

            cursor: "move",
            containment: "document"
        });

        $(".active_widget_list").droppable({
            accept: ".add-element",
            drop: function(event, ui) {
                let slug = $(this).find('.ui-draggable').data('slug');
                let pageId = $(this).find('.ui-draggable').data('page-id');
                let widgetName = $(this).find('.ui-draggable').data('widget-name');
                let action = baseUrl + "/dashboard/pages/add-widget-page/" + slug;

                $.ajax({
                    url: action,
                    method: 'get',
                    data: {
                        pageId,
                        widgetName
                    },
                    success: function(data) {
                        if (data.status == true) {
                            $(".active_widget_list").append(`${data.content}`);
                            $.toast({
                                heading: '{{ translate('Success') }}',
                                text: data.message,
                                icon: "success",
                                showHideTransition: 'fade',
                                position: 'top-right',
                            });
                        }
                        codeRichEditor();
                    },
                    error: function(data) {
                        $.toast({
                            heading: '{{ translate('Error') }}',
                            text: data.message,
                            icon: "error",
                            showHideTransition: 'fade',
                            position: 'top-right',
                        });
                    }
                });


            }

        }).sortable({
            placeholder: "placeholder",
            cursor: "move",
            stop: function(event, ui) {
                let item = $(this).find('.accordion-item')
                let content = [];
                $.each(item, function(key, val) {
                    let slug = $(val).find('.widget-slug').val();
                    let code = $(val).data('code');
                    content.push({
                        [code]: slug
                    });
                })

                let pageId = $("#pageId").val();
                let action = baseUrl + "/dashboard/pages/widget-sorted-by-page";
                $.ajax({
                    url: action,
                    method: 'get',
                    data: {
                        pageId,
                        content
                    },
                    dataType: 'json',
                    success: function(data) {

                        console.log(data);
                        if (data.status == false) {
                            $.toast({
                                heading: '{{ translate('Error') }}',
                                text: data.message,
                                icon: "error",
                                showHideTransition: 'fade',
                                position: 'top-right',
                            });
                        } else if (data.status == true) {
                            $.toast({
                                heading: '{{ translate('Success') }}',
                                text: data.message,
                                icon: "success",
                                showHideTransition: 'fade',
                                position: 'top-right',
                            });

                        }
                    },
                    error: function(data) {
                        $.toast({
                            heading: '{{ translate('Error') }}',
                            text: data.message,
                            icon: "error",
                            showHideTransition: 'fade',
                            position: 'top-right',
                        });
                    }
                });
            }
        });

        $(document).on('click', '.collapsed-action-btn', function(e) {

            e.preventDefault();
            let parent = $(this).closest('.accordion-item');;
            $(parent).find(".accordion-collapse").toggleClass("show");
        })

        $(document).on('submit', '.form', function(e) {

            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            let action = form.data('action');
            let lang = $("#lang").val();
            formData.append('lang', lang);


            // console.log(formData);

            $.ajax({
                type: "POST",
                url: action,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);

                    if (data.status == false) {
                        $.toast({
                            heading: '{{ translate('Error') }}',
                            text: data.message,
                            icon: "error",
                            showHideTransition: 'fade',
                            position: 'top-right',
                        });
                    } else if (data.status == true) {
                        $.toast({
                            heading: '{{ translate('Success') }}',
                            text: data.message,
                            icon: "success",
                            showHideTransition: 'fade',
                            position: 'top-right',
                        });
                    }
                },
                error: function(data) {
                    $.toast({
                        heading: '{{ translate('Error') }}',
                        text: data,
                        icon: "error",
                        showHideTransition: 'fade',
                        position: 'top-right',
                    });
                }
            })

        })

        $(document).on('click', '.add-block-content-btn', function(e) {
            e.preventDefault();
            let key1 = $(this).closest('form').find(".block-content-area .content").length;
            let parent = $(this).closest('form').find(".block-content-area");
            key1++;

            let html =
                `<div class="row align-items-center content">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">
                                                <div class="mb-2">
                                                    <label class="form-label">{{ translate('Block Title') }}</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ translate('Enter Block Title') }}" name="content[0][block_content][${key1}][block_title]">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <div class="mb-2">
                                                    <label class="form-label">{{ translate('Block Style') }}</label>
                                                    <select class="form-control select2" name="content[0][block_content][${key1}][block_style]">
                                                        <option value="">{{ translate('Select Option') }}</option>
                                                        <option value="1">Block Style 1</option>
                                                        <option value="2">Block Style 2</option>
                                                        <option value="3">Block Style 3</option>
                                                        <option value="4">Block Style 4</option>
                                                        <option value="5">Block Style 5</option>
                                                        <option value="6">Block Style 6</option>
                                                        <option value="7">Block Style 7</option>
                                                        <option value="8">Block Style 8</option>
                                                        <option value="9">Block Style 9</option>
                                                        <option value="10">Block Style 10</option>
                                                        <option value="11">Block Style 11</option>
                                                        <option value="12">Block Style 12</option>
                                                        <option value="13">Block Style 13</option>
                                                        <option value="14">Block Style 14</option>
                                                        <option value="15">Block Style 15</option>
                                                        <option value="16">Block Style 16</option>
                                                        <option value="17">Block Style 17</option>
                                                        <option value="18">Block Style 18</option>
                                                        <option value="19">Block Style 19</option>
                                                        <option value="20">Block Style 20</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <div class="mb-2">
                                                    <label class="form-label">{{ translate('Title Style') }}</label>
                                                    <select class="form-control select2" name="content[0][block_content][${key1}][title_style]">
                                                        <option value="">{{ translate('Select Option') }}</option>
                                                        <option value="1" {{ isset($block_content['title_style']) && $block_content['title_style'] == 1 ? 'selected' : '' }}>Title Style 1</option>
                                                        <option value="2" {{ isset($block_content['title_style']) && $block_content['title_style'] == 2 ? 'selected' : '' }}>Title Style 2</option>
                                                        <option value="3" {{ isset($block_content['title_style']) && $block_content['title_style'] == 3 ? 'selected' : '' }}>Title Style 3</option>
                                                        <option value="4" {{ isset($block_content['title_style']) && $block_content['title_style'] == 4 ? 'selected' : '' }}>Title Style 4</option>
                                                        <option value="5" {{ isset($block_content['title_style']) && $block_content['title_style'] == 5 ? 'selected' : '' }}>Title Style 5</option>
                                                        <option value="6" {{ isset($block_content['title_style']) && $block_content['title_style'] == 6 ? 'selected' : '' }}>Title Style 6</option>
                                                        <option value="7" {{ isset($block_content['title_style']) && $block_content['title_style'] == 7 ? 'selected' : '' }}>Title Style 7</option>
                                                        <option value="8" {{ isset($block_content['title_style']) && $block_content['title_style'] == 8 ? 'selected' : '' }}>Title Style 8</option>
                                                        <option value="9" {{ isset($block_content['title_style']) && $block_content['title_style'] == 9 ? 'selected' : '' }}>Title Style 9</option>
                                                        <option value="10" {{ isset($block_content['title_style']) && $block_content['title_style'] == 10 ? 'selected' : '' }}>Title Style 10</option>
                                                        <option value="11" {{ isset($block_content['title_style']) && $block_content['title_style'] == 11 ? 'selected' : '' }}>Title Style 11</option>
                                                        <option value="12" {{ isset($block_content['title_style']) && $block_content['title_style'] == 12 ? 'selected' : '' }}>Title Style 12</option>
                                                        <option value="13" {{ isset($block_content['title_style']) && $block_content['title_style'] == 13 ? 'selected' : '' }}>Title Style 13</option>
                                                        <option value="14" {{ isset($block_content['title_style']) && $block_content['title_style'] == 14 ? 'selected' : '' }}>Title Style 14</option>
                                                        <option value="15" {{ isset($block_content['title_style']) && $block_content['title_style'] == 15 ? 'selected' : '' }}>Title Style 15</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6 mb-2">
                                                <div class="mb-2">
                                                    <label class="form-label" for="favcolor">{{ translate('Title Color') }}</label>
                                                    <input class="form-control" type="color" id="favcolor" name="content[0][block_content][${key1}][title_color]" value="#471944">
                                                </div>
                                            </div>
                                            @php
                                                $categories = App\Models\BlogCategory::where('status', 1)->whereNull('parent_id')->orderBy('name', 'asc')->get();
                                            @endphp
                                            <div class="col-sm-6 mb-2">
                                                <div class="mb-2">
                                                    <label class="form-label">{{ translate('News Type') }}</label>
                                                    <select class="form-control select2" name="content[0][block_content][${key1}][news_type]">
                                                        @if ($categories)
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                                            @if ($category->child)
                                                            @foreach ($category->child as $child)
                                                            <option value="{{ $child->id }}">-{{ $child->getTranslation('name') }}</option>
                                                            @if ($child->child)
                                                            @foreach ($child->child as $child2)
                                                            <option value="{{ $child2->id }}">--{{ $child2->getTranslation('name') }}</option>
                                                            @endforeach
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <div class="mb-2">
                                                    <label class="form-label">{{ translate('Order') }}</label>
                                                    <select class="form-control select2" name="content[0][block_content][${key1}][news_order]">
                                                        <option value="">{{ translate('Select Option') }}</option>
                                                        <option value="asc">ASC</option>
                                                        <option value="desc">DESC</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <button class="remove-information remove text-danger border-0">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>

                                </div>`
            $('.block-content-area').append(html);
        });

        $(document).on('click', '.add-fun-facts-btn', function(e) {

            e.preventDefault();

            let key2 = $(this).closest('form').find(".fun-facts-area .content").length;
            let parent = $(this).closest('form').find(".fun-facts-area");

            key2++;


            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-3 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Title') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Enter Title') }}"
                                        name="content[0][fun_facts][${key2}][title]"
                                        value="{{ isset($fun_fact['title']) ? $fun_fact['title'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <div class="form-inner">
                                    <label class="form-label"> {{ translate('Number Count') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Enter Number Count') }}"
                                        value="{{ isset($fun_fact['number_count']) ? $fun_fact['number_count'] : '' }}"
                                        name="content[0][fun_facts][${key2}][number_count]">

                                </div>
                            </div>

                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Icon') }}</label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control widget-image-upload"
                                            name="image" data-folder="/uploads/fun_facts/">

                                        <input type="hidden"
                                            name="content[0][fun_facts][${key2}][img]"
                                            id="old_file"
                                            value="{{ isset($fun_fact['img']) ? $fun_fact['img'] : '' }}">

                                        @if (isset($fun_fact['img']))
                                            <div class="ms-2">
                                                <img height="50" width="auto"
                                                    src="{{ asset('uploads/fun_facts/' . $fun_fact['img']) }}"
                                                    alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-1 text-center">
                        <button class="remove-information remove text-danger border-0">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>`

            $('.fun-facts-area').append(html);
        });

        $(document).on('click', '.add-features-btn', function(e) {

            e.preventDefault();

            let key3 = $(this).closest('form').find(".features-area .content").length;
            let parent = $(this).closest('form').find(".features-area");

            key3++;


            let html = `
                <div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-3 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Name') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Enter Name') }}"
                                        name="content[0][features][${key3}][name]">
                                </div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Icon') }}</label>

                                    <div class="d-flex">
                                        <input type="file" class="form-control widget-image-upload"
                                            name="image" data-folder="/uploads/features/">
                                        <input type="hidden" name="content[0][features][${key3}][img]"
                                            id="old_file">

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Short Description') }}</label>
                                    <textarea class="form-control" name="content[0][features][${key3}][descriptions]"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-1 text-center">
                        <button class="remove-information remove text-danger border-0">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>`

            parent.append(html);
        });

        $(document).on('click', '.add-procedures-btn', function(e) {

            let key4 = $(this).closest('form').find(".procedures-area .content").length;
            let parent = $(this).closest('form').find(".procedures-area");

            key4++;
            e.preventDefault();

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">

                                    <label class="form-label">{{ translate('Name') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Enter Name') }}"
                                        name="content[0][procedures][${key4}][name]"
                                        value="{{ isset($procedure['name']) ? $procedure['name'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Image') }}</label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control widget-image-upload"
                                            name="image" data-folder="/uploads/procedures/">

                                        <input type="hidden"
                                            name="content[0][procedures][${key4}][img]"
                                            id="old_file"
                                            value="{{ isset($procedure['img']) ? $procedure['img'] : '' }}">

                                        @if (isset($procedure['img']))
                                            <div class="ms-2">
                                                <img height="50" width="auto"
                                                    src="{{ asset('uploads/procedures/' . $procedure['img']) }}"
                                                    alt="">
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>


                            <div class="col-sm-5 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Button Text') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Enter Button Text') }}"
                                        name="content[0][procedures][${key4}][button_text]"
                                        value="{{ isset($procedure['button_text']) ? $procedure['button_text'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Button Url') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Button Url') }}"
                                        name="content[0][procedures][${key4}][button_url]"
                                        value="{{ isset($procedure['button_url']) ? $procedure['button_url'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-4">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Description') }}</label>
                                    <textarea rows="6" name="content[0][procedures][${key4}][description]"> {!! isset($procedure['description']) ? clean($procedure['description']) : '' !!}  </textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-sm-1 text-center">
                        <button class="remove-information remove text-danger border-0">
                            <i class="bi  bi-trash"></i>
                        </button>
                    </div>
                </div>`

            parent.append(html);
        });

        $(document).on('click', '.add-faqs-btn', function(e) {
            e.preventDefault();
            let key5 = $(this).closest('form').find(".faqs-area .content").length;
            let parent = $(this).closest('form').find(".faqs-area");
            key5++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Question') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Enter Question') }}"
                                        name="content[0][faqs][${key5}][title]"
                                        >
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <label class="form-label">{{ translate('Answer') }}</label>
                                    <textarea class="form-control" rows='5' name="content[0][faqs][${key5}][description]"> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);
            codeRichEditor();
        });

        $(document).on("click", '.remove-information', function(e) {
            e.preventDefault();
            let self = $(this).closest('.content').remove();

        })
        //status Inactive

        $(document).on('change', '.status-change', function(e) {
            e.preventDefault();
            let action = $(this).data('action');
            $.ajax({
                url: action,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.status === true) {
                        $.toast({
                            heading: '{{ translate('Success') }}',
                            text: data.message,
                            icon: "success",
                            showHideTransition: 'fade',
                            position: 'top-right',
                        });

                    } else if (data.status == false) {
                        $.toast({
                            heading: '{{ translate('Error') }}',
                            text: data.message,
                            icon: "error",
                            showHideTransition: 'fade',
                            position: 'top-right',
                        });
                    }

                },
                error: function(data) {
                    $.toast({
                        heading: '{{ translate('Error') }}',
                        text: data,
                        icon: "error",
                        showHideTransition: 'fade',
                        position: 'top-right',
                    });
                }
            });

        });
        $(document).on('click', '.delete-action', function(e) {
            e.preventDefault();
            let self = $(this);
            let id = self.data('id');
            let action = baseUrl + "/dashboard/pages/widget-delete-by-page/" + id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: action,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            if (data.status === true) {
                                $.toast({
                                    heading: '{{ translate('Success') }}',
                                    text: data.message,
                                    icon: "success",
                                    showHideTransition: 'fade',
                                    position: 'top-right',
                                });
                                $(self).closest('.accordion-item').remove();

                            } else if (data.status == false) {
                                $.toast({
                                    heading: '{{ translate('Error') }}',
                                    text: data.message,
                                    icon: "error",
                                    showHideTransition: 'fade',
                                    position: 'top-right',
                                });
                            }

                        },
                        error: function(data) {
                            $.toast({
                                heading: '{{ translate('Error') }}',
                                text: data,
                                icon: "error",
                                showHideTransition: 'fade',
                                position: 'top-right',
                            });
                        }
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Cancelled',
                        'Your file is safe :)',
                        'error'
                    )
                }
            })

        });


        $(document).on('click', '.add-phone-btn', function(e) {
            e.preventDefault();

            let key = $(this).closest('form').find(".phone-area .content").length;
            let parent = $(this).closest('form').find(".phone-area");

            key++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Enter Number') }}"
                                        name="content[0][phone][${key}][phone_number]"
                                        >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);


        })
        $(document).on('click', '.add-email-btn', function(e) {
            e.preventDefault();

            let key = $(this).closest('form').find(".email-area .content").length;
            let parent = $(this).closest('form').find(".email-area");

            key++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner">
                                    <input type="email" class="form-control"
                                        placeholder="{{ translate('Enter Email') }}"
                                        name="content[0][email][${key}][email_name]"
                                        >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);


        })



        $(document).on('click', '.add-video-btn', function(e) {
            e.preventDefault();

            let key = $(this).closest('form').find(".video-area .content").length;
            let parent = $(this).closest('form').find(".video-area");

            key++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-inner mb-3">
                                    <label for="" class="form-label fw-bold">{{ translate('Video Title') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Video Title') }}"
                                        name="content[0][video][${key}][video_title]"
                                        value="{{ isset($video['video_title']) ? $video['video_title'] : '' }}">
                                </div>

                                <div class="form-inner mb-3">
                                    <label for="" class="form-label fw-bold">{{ translate('Video Url') }}</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ translate('Video URL') }}"
                                        name="content[0][video][${key}][video_url]"
                                        value="{{ isset($video['video_url']) ? $video['video_url'] : '' }}">
                                </div>

                                <div class="form-inner mb-3">
                                    <label class="form-label fw-bold"
                                        for="image">{{ translate('Thumbnail') }}</label>
                                    <div class="col-md-12 d-inline-block">
                                        <div class="input-group" data-toggle="wlluploader"
                                            data-type="image">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}
                                                </div>
                                            </div>
                                            <div class="form-control file-amount">
                                                {{ translate('Choose File') }}</div>
                                            <input type="hidden"
                                                name="content[0][video][${key}][image]"
                                                class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);
        })


        $(document).on('click', '.add-faq-btn', function(e) {
            e.preventDefault();

            let key = $(this).closest('form').find(".faq-area .content").length;
            let parent = $(this).closest('form').find(".faq-area");

            key++;

            let html =
                `<div class="row align-items-center content">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-inner mb-3">
                                    <label class="form-label fw-bold" for="">{{ translate('Question') }}</label>
                                    <input type="text" class="form-control"
                                    placeholder="{{ translate('Question') }}"
                                    name="content[0][faq][${key}][question]">
                                </div>

                                <div class="form-inner mb-3">
                                    <label class="form-label fw-bold" for="">{{ translate('Answer') }}</label>
                                    <textarea class="form-control"
                                    placeholder="{{ translate('Answer') }}"
                                    name="content[0][faq][${key}][answer]" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-1">
                        <button class="remove-information remove text-danger border-0">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>`
            parent.append(html);
        })


        //=================== widget  image  upload ===============

        $(document).on("change", '.widget-image-upload', function() {
            widgetOption(this);

        });

        // ===================  themOption  read file ====================

        function widgetOption(self) {

            if (self.files && self.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {

                    let action = "{{ route('pages.image.upload') }}";
                    let old_file = $(self).parent().find("#old_file").val();
                    let folder = $(self).data('folder');

                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: {
                            'image': e.target.result,
                            'old_file': old_file,
                            'folder': folder
                        },
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
                            if (data.status === true) {
                                $(self).parent().find("#old_file").val(data.image_name);
                            }
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    })


                };

                reader.readAsDataURL(self.files[0]);
            }
        }

        $(document).on("mouseenter", '.note-editor', function(event) {
            $(".active_widget_list").sortable("disable");
        });
        $(document).on("mouseleave", '.note-editor', function(event) {
            $(".active_widget_list").sortable("enable");
        });

        function codeRichEditor() {

            $(".summernote").summernote({

                placeholder: "Write here..",
                height: 320,
                toolbar: [
                    ['style', ['style']],
                    ['fontsize', ['fontsize']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['hr', 'link']],
                ],
                lineHeights: ['0.5', '1.0', '1.1', '1.2', '1.3', '1.4'],
                fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '24', '36', '48',
                    '64', '82', '150'
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            })

        }
    }(jQuery));
</script>
