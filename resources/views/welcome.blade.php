<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Create Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f1322;
            color: #fff;
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
            background: #151822;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.4s ease;
        }

        .submenu.open {
            max-height: 500px;
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
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            background: #1b1e2a;
            padding: 15px 20px;
            border-radius: 10px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
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
            background: #4dabf7;
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
            margin-bottom: 15px;
        }

        .form-group input {
            flex: 1;
            padding: 12px 15px;
            border-radius: 8px;
            border: 2px solid #2a2f40;
            background: #151822;
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
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

        .btn.add-module {
            background: #4dabf7;
            color: white;
            margin: 20px;
        }

        .btn.add-module:hover {
            background: #339af0;
        }

        .btn.cancel {
            background: #e74c3c;
            color: white;
        }

        .btn.cancel:hover {
            background: #c0392b;
        }

        .btn.save {
            background: #27ae60;
            color: white;
        }

        .btn.save:hover {
            background: #219653;
        }

        .btn.add-content {
            background: #8ce99a;
            color: #2b8a3e;
        }

        .btn.add-content:hover {
            background: #69db7c;
        }

        .btn.remove-module,
        .btn.remove-content {
            background: #ff8787;
            color: #c92a2a;
        }

        .btn.remove-module:hover,
        .btn.remove-content:hover {
            background: #fa5252;
        }

        /* Modules */
        .modules-container {
            padding: 0 20px 20px;
        }

        .module {
            background: #222736;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            position: relative;
        }

        .module-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
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
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
        }

        .content-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #343a4d;
            background: #1b1e2a;
            color: #fff;
        }

        select.content-input {
            cursor: pointer;
        }

        .actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding: 20px;
            border-top: 1px solid #2a2f40;
        }

        .module-actions {
            margin-top: 15px;
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

        .module-content {
            min-height: 50px;
        }

        /* Mobile menu button */
        .mobile-menu-btn {
            display: block;
            background: none;
            border: none;
            color: white;
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
            <a href="#" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" class="menu-item active">
                <i class="fas fa-book"></i>
                <span>Courses</span>
            </a>

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
                <h2>Create a Course</h2>
            </div>

            <div class="user-info">
                <span>John Doe</span>
                <div class="user-avatar">JD</div>
            </div>
        </div>

        <div class="container">
            <div class="course-info">
                <div class="form-group">
                    <input type="text" id="courseTitle" placeholder="Course Title">
                    <input type="text" id="featureVideo" placeholder="Feature Video URL">
                </div>
            </div>

            <button class="btn add-module"><i class="fas fa-plus"></i> Add Module</button>

            <div class="modules-container">
                <div id="modules">
                    <div class="empty-state">
                        <i class="far fa-folder-open"></i>
                        <p>No modules added yet</p>
                        <p>Click the "Add Module" button to get started</p>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button class="btn cancel"><i class="fas fa-times"></i> Cancel</button>
                <button class="btn save"><i class="fas fa-save"></i> Save Course</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let moduleCount = 0;
            let contentCount = 0;

            // Toggle sidebar on mobile
            $('.mobile-menu-btn').click(function() {
                $('.sidebar').toggleClass('open');
            });

            // Toggle submenus
            $('.has-submenu').click(function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(this).next('.submenu').toggleClass('open');
            });

            // Add Module
            $(".add-module").click(function() {
                // Remove empty state if it exists
                $(".empty-state").remove();

                moduleCount++;
                let moduleHtml = `
                    <div class="module" data-module="${moduleCount}">
                        <div class="module-header">
                            <div class="module-number">${moduleCount}</div>
                            <input type="text" class="module-title-input" placeholder="Module Title">
                            <div class="drag-handle"><i class="fas fa-grip-lines"></i></div>
                        </div>
                        <div class="module-content"></div>
                        <div class="module-actions">
                            <button class="btn add-content"><i class="fas fa-plus"></i> Add Content</button>
                            <button class="btn remove-module"><i class="fas fa-trash"></i> Remove Module</button>
                        </div>
                    </div>
                `;
                $("#modules").append(moduleHtml);
            });

            // Add Content inside Module
            $(document).on("click", ".add-content", function() {
                contentCount++;
                let contentHtml = `
                    <div class="content" data-content="${contentCount}">
                        <input type="text" class="content-input" placeholder="Content Title">
                        <select class="content-input">
                            <option value="">Video Source Type</option>
                            <option value="youtube">YouTube</option>
                            <option value="vimeo">Vimeo</option>
                            <option value="mp4">MP4</option>
                        </select>
                        <input type="text" class="content-input" placeholder="Video URL">
                        <input type="text" class="content-input" placeholder="Video Length (HH:MM:SS)">
                        <button class="btn remove-content"><i class="fas fa-trash"></i> Remove Content</button>
                    </div>
                `;
                $(this).closest('.module').find('.module-content').append(contentHtml);
            });

            // Remove Module
            $(document).on("click", ".remove-module", function() {
                $(this).closest(".module").remove();
                moduleCount--;

                // Update module numbers
                $(".module").each(function(index) {
                    $(this).find('.module-number').text(index + 1);
                });

                // Show empty state if no modules
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

            // Remove Content
            $(document).on("click", ".remove-content", function() {
                $(this).closest(".content").remove();
            });

            // Save button action
            $(".btn.save").click(function() {
                alert("Course saved successfully!");
            });

            // Cancel button action
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