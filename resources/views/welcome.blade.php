<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Create Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
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

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: #1b1e2a;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #2a2f40;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo {
            font-size: 22px;
            font-weight: bold;
            color: #4dabf7;
        }

        .sidebar-menu {
            padding: 15px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #a0a7c9;
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
        }

        .menu_content,
        .menu_title {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 12px 15px;
            /* margin-bottom: 10px; */
            background: #1b1e2a;
            border: 1px solid #343a4d;
            /* border-radius: 6px; */
        }

        .active_title {
            background: #343a4d;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #2a2f40;
            color: #fff;
        }

        .menu-item.active {
            border-left: 4px solid #4dabf7;
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        .submenu {
            background: #222736;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.4s ease;
        }

        .module_submenu {
            background: #222736;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.4s ease;
        }

        .submenu-item {
            padding: 12px 20px 12px 50px;
            display: block;
            color: #8a91ab;
            text-decoration: none;
            transition: all 0.3s;
        }

        .submenu-item:hover,
        .submenu-item.active {
            background: #222736;
            color: #4dabf7;
        }

        .has-submenu::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 20px;
            transition: transform 0.3s;
        }

        .has-submenu.open::after {
            transform: rotate(180deg);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px 20px;
            padding: 20px 20px 20px 0px;
            transition: margin-left 0.3s ease;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            background: #1b1e2a;
            padding: 15px 20px;
            border-radius: 10px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title-course {
            margin-bottom: 20px;
        }

        .page-title-course h3 {
            font-size: 28px;
            font-weight: 500;
            margin-left: 7px;
            margin-bottom: 8px;
        }

        .page-title-course a {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 6px;
            font-size: 16px;
            font-weight: normal;
            color: #2D75F1;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .page-title-course a:hover {
            color: #339af0;
        }

        .back-link {
            color: #4dabf7;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #a5d8ff;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #2D75F1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Container */
        .container {
            background: #1b1e2a;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .course-info {
            padding: 20px;
            border-bottom: 1px solid #2a2f40;
        }

        .form-group {
            display: flex;
            gap: 15px;
            /* margin-bottom: 15px; */
        }

        .form-group input {
            flex: 1;
            padding: 12px 15px;
            border-radius: 8px;
            border: 2px solid #2a2f40;
            background: #151822;
            color: #a0a7c9;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form_content input,
        .form_content select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 2px solid #2a2f40;
            background: #151822;
            color: #74767d;
            /* appearance: none; */
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
            margin-bottom: 10px;
            width: 100%;
            position: relative;
            /* opacity: .5; */
        }

        .form_content select {
            /* remove default arrow */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            background-image: url("data:image/svg+xml;utf8,<svg fill='gray' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 12px center;
            /* control arrow position */
            background-size: 25px;
        }

        .form_content input:focus {
            border-color: #4dabf7;
        }

        .form-group input:focus {
            border-color: #4dabf7;
        }

        .form-group input::placeholder {
            color: #6c7293;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn_delete,
        .btn_delete_content {
            padding: 10px 20px;
            /* border-radius: 8px; */
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn.add-module {
            background: #2D75F1;
            color: #dfe3e9ff;
            margin: 20px 20px 0px 20px;
        }

        .btn.add-module:hover {
            background: #339af0;
        }

        .btn.cancel {
            background: #e74c3c;
            color: #dfe3e9ff;
        }

        .btn.cancel:hover {
            background: #c0392b;
        }

        .btn.save {
            background: #27ae60;
            color: #dfe3e9ff;
        }

        .btn.save:hover {
            background: #219653;
        }

        .btn.add-content {
            background: #2D75F1;
            color: #dfe3e9ff;
        }

        .btn.add-content:hover {
            background: #69db7c;
        }

        .module {
            position: relative;
            padding-right: 60px;
        }

        .main_content {
            position: relative;
            padding-right: 60px;
        }

        .btn_delete.remove-module,
        .btn_delete_content.remove-content {
            background: #ff8787;
            color: #c92a2a;
            position: absolute;
            right: 10px;
            top: 0px;
        }

        .btn_delete.remove-module:hover,
        .btn_delete_content.remove-content:hover {
            background: #fa5252;
        }

        .module-header {
            display: flex;
            align-items: center;
            gap: 10px;
            /* margin-bottom: 15px; */
        }

        .module-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #4dabf7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .module-title-input {
            flex: 1;
            padding: 10px 15px;
            border-radius: 8px;
            border: 2px solid #2a2f40;
            background: #151822;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            outline: none;
            transition: border-color 0.3s;
        }

        .module-title-input:focus {
            border-color: #4dabf7;
        }

        .content {
            background: #2a2f40;
            margin-top: 5px;
        }

        .content-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #343a4d;
            background: #1b1e2a;
            /* color: #fff; */
            position: relative;
        }

        select.content-input {
            cursor: pointer;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            justify-content: start;
            gap: 15px;
            padding: 20px;
            border-top: 1px solid #2a2f40;
        }

        .module-actions {
            margin-top: 5px;
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c7293;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .empty-state p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .drag-handle {
            cursor: move;
            color: #6c7293;
            padding: 5px;
        }

        /* .module-content {
            min-height: 50px;
        } */

        /* Mobile menu button */
        .mobile-menu-btn {
            display: block;
            background: none;
            border: none;
            color: #dfe3e9ff;
            font-size: 24px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            background: #2a2f40;
        }

        .sidebar {
            transform: translateX(0);
            width: 240px;
        }

        .sidebar.open {
            transform: translateX(-100%);
        }

        .has_submenu {
            position: relative;
            margin: 0;
            padding-right: 30px;
        }

        .has_submenu::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            transition: transform 0.3s;
        }

        .has_submenu.open::after {
            transform: rotate(180deg);
        }

        .content.submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }

        .content.submenu.open {
            max-height: 500px;
        }

        div#modules {
            width: 90%;
        }

        div#modules .module_submenu {
            width: 90%;
            display: none;
            /* padding: 0px 10px 10px; */
        }

        div#content_submenu .content_submenu {
            width: 90%;
            display: none;
            /* padding: 0px 10px 10px; */
        }

        .module_submenu.open {
            max-height: 100%;
            width: 90%;
            display: block !important;
        }

        .content_submenu.open {
            max-height: 100%;
            width: 90%;
            display: block !important;
        }

        .submenu.open {
            max-height: 500px;
        }

        .custom_padding {
            padding: 10px 10px 10px;
            background: #1b1e2a;
            margin: 0px !important;
            border: 1px solid #343a4d;

        }

        .main-content-open {
            margin-left: 0px;
            width: 100%;
        }

        .module:first-child .menu_content {
            margin-top: 20px;
        }

        /* .main_content:last-child .menu_title {
            margin-bottom: 20px;
        } */

        .module {
            margin-left: 20px;
        }

        .form-field {
            width: 50%;
        }

        .module:first-child .btn_delete {
            display: none;
        }

        .main_content:first-child .btn_delete_content {
            display: none;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }

            .sidebar.open {
                transform: translateX(0);
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .form-group {
                flex-direction: column;
                gap: 10px;
            }

            .actions {
                flex-direction: column;
            }

            .form-field {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">LearnHub</div>
        </div>

        <div class="sidebar-menu">
            <a href="#" class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" class="menu-item has-submenu">
                <i class="fas fa-book"></i>
                <span>Courses</span>
            </a>
            <div class="submenu">
                <a href="#" class="submenu-item">Course Analytics</a>
                <a href="#" class="submenu-item">Revenue Reports</a>
                <a href="#" class="submenu-item">Engagement Metrics</a>
            </div>

            <a href="#" class="menu-item has-submenu">
                <i class="fas fa-graduation-cap"></i>
                <span>Students</span>
            </a>
            <div class="submenu">
                <a href="#" class="submenu-item">All Students</a>
                <a href="#" class="submenu-item">Progress Tracking</a>
                <a href="#" class="submenu-item">Certificates</a>
            </div>

            <a href="#" class="menu-item has-submenu">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
            <div class="submenu">
                <a href="#" class="submenu-item">Course Analytics</a>
                <a href="#" class="submenu-item">Revenue Reports</a>
                <a href="#" class="submenu-item">Engagement Metrics</a>
            </div>

            <a href="#" class="menu-item has-submenu">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            <div class="submenu">
                <a href="#" class="submenu-item">Account Settings</a>
                <a href="#" class="submenu-item">Payment Setup</a>
                <a href="#" class="submenu-item">Notifications</a>
            </div>

            <a href="#" class="menu-item">
                <i class="fas fa-question-circle"></i>
                <span>Help & Support</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="user-info">
                <span>John Doe</span>
                <div class="user-avatar">JD</div>
            </div>
        </div>

        <div class="page-title-course">
            <h3>Create a Course</h2>
                <a><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg> Back to Course Page</h4>
        </div>

        <div class="container">
            <div class="course-info">
                <div class="form-group">
                    <div class="form-field">
                        <h3>Course Title</h3>
                        <input type="text" style="width: 100%;margin-top: 10px" id="courseTitle" placeholder="Course Title" required>
                    </div>
                    <div class="form-field">
                        <h3>Feature Video URL</h3>
                        <input type="text" style="width: 100%;margin-top: 10px" id="featureVideo" placeholder="Feature Video URL" required>
                    </div>
                </div>
            </div>

            <button class="btn add-module"> Add Module <i class="fas fa-plus"></i></button>

            <div class="modules-container">
                <div id="modules">
                </div>
            </div>

            <div class="actions">
                <button class="btn save"> Save </button>
                <button class="btn cancel"> Cancel</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let moduleCount = 0;
            let contentCount = 0;

            $('.mobile-menu-btn').click(function() {
                $('.sidebar').toggleClass('open');
            });

            $('.has-submenu').click(function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.submenu').toggleClass('open');
            });

            $('.mobile-menu-btn').on('click', function() {
                // $('.sidebar').toggleClass('open');
                $('.main-content').toggleClass('main-content-open');
            });

            // // Function to add a new module
            // function addModule() {
            //     $(".empty-state").remove();
            //     moduleCount++;
            //     let moduleHtml = `
            //         <div class="module" data-module="${moduleCount}">
            //             <h3 class="menu_content has_submenu">Module ${moduleCount}</h3>
            //             <div class="module_submenu form_content custom_padding" style="margin-top: 10px">
            //                 <div class="module-header">
            //                    <input type="text" class="module-title-input" placeholder="Module Title">
            //                 </div>
            //                 <div class="module-actions">
            //                    <button class="btn add-content"> Add Content <i class="fas fa-plus"></i></button>
            //                 </div>
            //                 <div class="module-content"></div>
            //             </div>
            //             <span class="btn_delete remove-module">x</span>
            //         </div>
            //     `;
            //     $("#modules").append(moduleHtml);

            //     // Auto-activate the first module only
            //     if (moduleCount === 1) {
            //         $("#modules .module:first-child .has_submenu").addClass("open active_title");
            //         $("#modules .module:first-child .module_submenu").addClass("open");
            //     }

            // }
            // addModule();

            // Add Module
            function addModule() {
                // $(".add-module").click(function() {
                $(".empty-state").remove();
                moduleCount++;
                let moduleHtml = `
                    <div class="module" data-module="${moduleCount}">
                        <h3 class="menu_content has_submenu">Module ${moduleCount}</h3>
                        <div class="module_submenu form_content custom_padding" style="margin-top: 10px">
                            <div class="module-header">
                               <input type="text" class="module-title-input" placeholder="Module Title" required>
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

                    let $firstModule = $("#modules .module:first-child");
                    $firstModule.find(".has_submenu").addClass("open active_title");
                    $firstModule.find(".module_submenu").addClass("open");
                    addContentToModule($firstModule);
                }
                // });

                // $(document).on("click", ".add-content", function(e) {
                //     e.preventDefault();

                //     let module = $(this).closest(".module");
                //     addContentToModule(module);
                // });
            }


            function addContentToModule(moduleElement) {
                // $(document).on("click", ".add-content", function() {
                contentCount++;
                let contentHtml = `
                    <div class="main_content" id="content_submenu">
                        <h3 class="menu_title has_submenu">Content ${contentCount}</h3>
                        <div class="content content_submenu form_content custom_padding" data-content="${contentCount}">
                            <input type="text" class="content-input" placeholder="Content Title" required>
                            <select class="content-input" required>
                                <option value="">Video Source Type</option>
                                <option value="youtube">YouTube</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="mp4">MP4</option>
                            </select>
                            <input type="text" class="content-input" placeholder="Video URL" required>
                            <input type="text" class="content-input" placeholder="Video Length (HH:MM:SS)" required>
                        </div>
                        <button class="btn_delete_content remove-content">x</button>
                    </div>
                `;
                //     $(this).closest('.module').find('.module-content').append(contentHtml);
                // });

                moduleElement.find('.module-content').append(contentHtml);

                if (contentCount === 1) {
                    moduleElement.find('.menu_title.has_submenu:first').addClass('open active_title');
                    moduleElement.find('.content_submenu:first').addClass('open');
                }
            }

            addModule();

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

            // $(".btn.save").click(function() {
            //     alert("Course saved successfully!");
            // });

            $(".btn.cancel").click(function() {
                if (confirm("Are you sure you want to cancel? All changes will be lost.")) {
                    alert("Course creation cancelled.");
                    location.reload();
                }
            });

            $(".btn.save").click(function() {
                let isValid = true;
                let errorMessage = "";

                if (!$("#courseTitle").val().trim()) {
                    isValid = false;
                    errorMessage += "- Course title is required.\n";
                }

                $(".module").each(function(index) {
                    let moduleTitle = $(this).find(".module-title-input").val().trim();
                    if (!moduleTitle) {
                        isValid = false;
                        errorMessage += `- Module ${index + 1} title is required.\n`;
                    }

                    $(this).find(".content").each(function(contentIndex) {
                        let contentTitle = $(this).find("input[placeholder='Content Title']").val().trim();
                        let sourceType = $(this).find("select").val();
                        let videoUrl = $(this).find("input[placeholder='Video URL']").val().trim();
                        let videoLength = $(this).find("input[placeholder='Video Length (HH:MM:SS)']").val().trim();

                        if (!contentTitle || !sourceType || !videoUrl || !videoLength) {
                            isValid = false;
                            errorMessage += `- All fields are required for Content ${contentIndex + 1} in Module ${index + 1}.\n`;
                        }
                    });
                });

                if (!isValid) {
                    alert("Please fix the following errors:\n" + errorMessage);
                    return;
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
                    }
                });
            });


        });
    </script>
</body>

</html>