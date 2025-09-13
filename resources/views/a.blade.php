<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Create Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Previous CSS styles remain unchanged */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI';
            background: #0f1322;
            color: #a0a7c9;
            min-height: 100vh;
            display: flex;
        }

        /* ... (all previous CSS styles remain exactly the same) ... */

        /* Validation Styles */
        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .input-error {
            border-color: #ff6b6b !important;
        }

        .input-success {
            border-color: #51cf66 !important;
        }

        .validation-summary {
            background: #ff8787;
            color: #c92a2a;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .validation-summary ul {
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar and main content structure remains exactly the same -->
    <!-- ... (sidebar and main content HTML remains unchanged) ... -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let moduleCount = 0;
            let contentCount = 0;

            // Add validation summary container
            $('.page-title-course').after('<div class="validation-summary"></div>');

            // Validation patterns
            const validationPatterns = {
                required: /.+/,
                youtube: /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/,
                vimeo: /^(https?:\/\/)?(www\.)?vimeo\.com\/.+$/,
                videoLength: /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/,
                url: /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/
            };

            // Validation messages
            const validationMessages = {
                required: "This field is required",
                youtube: "Please enter a valid YouTube URL",
                vimeo: "Please enter a valid Vimeo URL",
                videoLength: "Please enter time in HH:MM:SS format",
                url: "Please enter a valid URL"
            };

            // Initialize validation
            function initValidation() {
                // Course title validation
                $('#courseTitle').on('blur', function() {
                    validateField($(this), ['required']);
                });

                // Feature video validation
                $('#featureVideo').on('blur', function() {
                    validateField($(this), ['url']);
                });

                // Module title validation (for existing and future modules)
                $(document).on('blur', '.module-title-input', function() {
                    validateField($(this), ['required']);
                });

                // Content title validation
                $(document).on('blur', '.content-input[placeholder="Content Title"]', function() {
                    validateField($(this), ['required']);
                });

                // Video URL validation based on source type
                $(document).on('blur', '.content-input[placeholder="Video URL"]', function() {
                    const sourceType = $(this).closest('.content_submenu').find('select').val();
                    if (sourceType === 'youtube') {
                        validateField($(this), ['youtube']);
                    } else if (sourceType === 'vimeo') {
                        validateField($(this), ['vimeo']);
                    } else if (sourceType === 'mp4') {
                        validateField($(this), ['url']);
                    } else {
                        validateField($(this), ['required']);
                    }
                });

                // Video length validation
                $(document).on('blur', '.content-input[placeholder="Video Length (HH:MM:SS)"]', function() {
                    validateField($(this), ['videoLength']);
                });

                // Source type change event
                $(document).on('change', '.content-input select', function() {
                    const videoUrlInput = $(this).closest('.content_submenu').find('input[placeholder="Video URL"]');
                    videoUrlInput.trigger('blur');
                });
            }

            // Validate a field based on rules
            function validateField(field, rules) {
                let isValid = true;
                let errorMessage = '';

                // Remove previous error classes and messages
                field.removeClass('input-error input-success');
                field.next('.error-message').remove();

                for (const rule of rules) {
                    if (!validationPatterns[rule].test(field.val().trim())) {
                        isValid = false;
                        errorMessage = validationMessages[rule];
                        break;
                    }
                }

                if (!isValid) {
                    field.addClass('input-error');
                    field.after(`<div class="error-message">${errorMessage}</div>`);
                } else {
                    field.addClass('input-success');
                }

                return isValid;
            }

            function validateAll() {
                let isValid = true;
                const errors = [];

                if (!validateField($('#courseTitle'), ['required'])) {
                    isValid = false;
                    errors.push("Course title is required");
                }

                if ($('#featureVideo').val().trim() && !validateField($('#featureVideo'), ['url'])) {
                    isValid = false;
                    errors.push("Feature video URL is invalid");
                }

                $('.module').each(function(index) {
                    const moduleTitle = $(this).find('.module-title-input');
                    if (!validateField(moduleTitle, ['required'])) {
                        isValid = false;
                        errors.push(`Module ${index + 1}: Title is required`);
                    }

                    // Validate contents in this module
                    $(this).find('.content').each(function(contentIndex) {
                        const contentTitle = $(this).find('input[placeholder="Content Title"]');
                        const sourceType = $(this).find('select').val();
                        const videoUrl = $(this).find('input[placeholder="Video URL"]');
                        const videoLength = $(this).find('input[placeholder="Video Length (HH:MM:SS)"]');

                        if (!validateField(contentTitle, ['required'])) {
                            isValid = false;
                            errors.push(`Module ${index + 1}, Content ${contentIndex + 1}: Title is required`);
                        }

                        if (sourceType === 'youtube') {
                            if (!validateField(videoUrl, ['youtube'])) {
                                isValid = false;
                                errors.push(`Module ${index + 1}, Content ${contentIndex + 1}: YouTube URL is invalid`);
                            }
                        } else if (sourceType === 'vimeo') {
                            if (!validateField(videoUrl, ['vimeo'])) {
                                isValid = false;
                                errors.push(`Module ${index + 1}, Content ${contentIndex + 1}: Vimeo URL is invalid`);
                            }
                        } else if (sourceType === 'mp4') {
                            if (!validateField(videoUrl, ['url'])) {
                                isValid = false;
                                errors.push(`Module ${index + 1}, Content ${contentIndex + 1}: Video URL is invalid`);
                            }
                        } else if (!sourceType) {
                            isValid = false;
                            errors.push(`Module ${index + 1}, Content ${contentIndex + 1}: Please select a video source type`);
                        }

                        if (!validateField(videoLength, ['videoLength'])) {
                            isValid = false;
                            errors.push(`Module ${index + 1}, Content ${contentIndex + 1}: Video length format is invalid (use HH:MM:SS)`);
                        }
                    });
                });

                // Show validation summary if there are errors
                if (!isValid) {
                    const summary = $('.validation-summary');
                    summary.html('<strong>Please fix the following errors:</strong><ul></ul>');

                    errors.forEach(error => {
                        summary.find('ul').append(`<li>${error}</li>`);
                    });

                    summary.show();

                    // Scroll to the first error
                    $('html, body').animate({
                        scrollTop: $('.input-error').first().offset().top - 100
                    }, 500);
                } else {
                    $('.validation-summary').hide();
                }

                return isValid;
            }

            $('.mobile-menu-btn').click(function() {
                $('.sidebar').toggleClass('open');
            });

            $('.has-submenu').click(function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.submenu').toggleClass('open');
            });

            $('.mobile-menu-btn').on('click', function() {
                $('.main-content').toggleClass('main-content-open');
            });

            // Add Module function
            function addModule() {
                $(".empty-state").remove();
                moduleCount++;
                let moduleHtml = `
                    <div class="module" data-module="${moduleCount}">
                        <h3 class="menu_content has_submenu">Module ${moduleCount}</h3>
                        <div class="module_submenu form_content custom_padding" style="margin-top: 10px">
                            <div class="module-header">
                               <input type="text" class="module-title-input" placeholder="Module Title">
                            </div>
                            <div class="module-actions">
                               <button class="btn add-content"> Add Content <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="module-content"></div>
                        </div>
                        <span class="btn_delete remove-module">x</span>
                    </div>
                `;
                $("#modules").append(moduleHtml);

                if (moduleCount === 1) {
                    $("#modules .module:first-child .has_submenu").addClass("open active_title");
                    $("#modules .module:first-child .module_submenu").addClass("open");
                }
            }

            // Add Content to Module function
            function addContentToModule(moduleElement) {
                contentCount++;
                let contentHtml = `
                    <div class="main_content" id="content_submenu">
                        <h3 class="menu_title has_submenu">Content ${contentCount}</h3>
                        <div class="content content_submenu form_content custom_padding" data-content="${contentCount}">
                            <input type="text" class="content-input" placeholder="Content Title">
                            <select class="content-input">
                                <option value="">Video Source Type</option>
                                <option value="youtube">YouTube</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="mp4">MP4</option>
                            </select>
                            <input type="text" class="content-input" placeholder="Video URL">
                            <input type="text" class="content-input" placeholder="Video Length (HH:MM:SS)">
                        </div>
                        <button class="btn_delete_content remove-content">x</button>
                    </div>
                `;
                moduleElement.find('.module-content').append(contentHtml);

                if (contentCount === 1) {
                    moduleElement.find('.menu_title.has_submenu:first').addClass('open active_title');
                    moduleElement.find('.content_submenu:first').addClass('open');
                }
            }

            addModule();
            initValidation();

            $(".btn.add-module").click(function() {
                addModule();
            });

            $(document).on("click", ".add-content", function() {
                addContentToModule($(this).closest('.module'));
            });

            $(document).on("click", ".has_submenu", function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.submenu').toggleClass('open');
                $(this).next('.module_submenu').toggleClass('open');
                $(this).next('.content_submenu').toggleClass('open');
            });

            $(document).on("click", ".remove-module", function() {
                $(this).closest(".module").remove();
                moduleCount--;

                $(".module").each(function(index) {
                    $(this).find('.module-number').text(index + 1);
                });

                if ($(".module").length === 0) {
                    $("#modules").html(`
                        <div class="empty-state">
                            <i class="far fa-folder-open"></i>
                            <p>No modules added yet</p>
                            <p>Click the "Add Module" button to get started</p>
                        </div>
                    `);
                }
            });

            $(document).on("click", ".remove-content", function() {
                $(this).closest(".main_content").remove();
            });

            $(document).on("click", "h3.menu_content", function() {
                $(this).toggleClass('active_title');
            });

            // Save button with validation
            $(".btn.save").click(function() {
                if (!validateAll()) {
                    return false;
                }

                let courseData = {
                    title: $("#courseTitle").val(),
                    feature_video: $("#featureVideo").val(),
                    modules: []
                };

                $(".module").each(function() {
                    let moduleTitle = $(this).find(".module-title-input").val();
                    let moduleObj = {
                        title: moduleTitle,
                        contents: []
                    };

                    $(this).find(".content").each(function() {
                        let contentObj = {
                            title: $(this).find("input[placeholder='Content Title']").val(),
                            source_type: $(this).find("select").val(),
                            video_url: $(this).find("input[placeholder='Video URL']").val(),
                            video_length: $(this).find("input[placeholder='Video Length (HH:MM:SS)']").val()
                        };
                        moduleObj.contents.push(contentObj);
                    });

                    courseData.modules.push(moduleObj);
                });

                $.ajax({
                    url: "/courses",
                    method: "POST",
                    data: {
                        course: courseData,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        alert("Course saved successfully!");
                        console.log(res);
                    },
                    error: function(xhr, status, error) {
                        alert("Error saving course: " + error);
                    }
                });
            });

            $(".btn.cancel").click(function() {
                if (confirm("Are you sure you want to cancel? All changes will be lost.")) {
                    alert("Course creation cancelled.");
                    location.reload();
                }
            });
        });
    </script>
</body>

</html>