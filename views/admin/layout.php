<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminNvt</title>
    <!-- Remix Icon: đẹp, phổ biến, hiện đại -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #170f23;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            background-color: #231b2e;
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* canh giữa logo */
        }

        .sidebar .logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
            object-fit: contain;
            filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.1));
        }


        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .menu li {
            margin-bottom: 12px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 6px;
            color: #fff;
            text-decoration: none;
            transition: background 0.2s, opacity 0.2s;
        }

        .menu-link:hover,
        .menu-link.active {
            background-color: #3a3344;
            opacity: 0.9;
        }


        .create-playlist {
            padding: 12px;
            margin-top: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .create-playlist a {
            text-decoration: none;
            display: inline-block;
            color: #fff;
        }

        .create-playlist:hover {
            /* background-color: #3a3344; */
            opacity: 70%;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            padding-bottom: 100px;
        }

        .main-content h2 {
            margin-bottom: 16px;
        }

        .btn-custom {
            background-color: #9b4de0;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 12px;
            display: inline-block;
        }

        .btn-custom:hover {
            background-color: #b86aff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #231b2e;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #3a3344;
        }

        th {
            background-color: #2e253a;
        }

        img.img-thumbnail {
            border-radius: 4px;
            width: 60px;
            height: auto;
        }

        .action-btn {
            padding: 4px 8px;
            margin: 0 4px;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            color: white;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #ffc107;
        }

        .yt-btn {
            background-color: #28ff07ff;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .player-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 90px;
            background-color: #1e1b2e;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            padding: 0 20px;
            z-index: 100;
            border-top: 1px solid #333;
            box-sizing: border-box;
        }

        .player-left,
        .player-center,
        .player-right {
            display: flex;
            align-items: center;
        }

        .player-left {
            flex: 1;
            gap: 14px;
        }

        .player-left img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 8px;
        }

        .song-info h4 {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .song-info p {
            font-size: 12px;
            color: #aaa;
        }

        .player-center {
            flex: 2;
            flex-direction: column;
            justify-content: center;
        }

        .controls {
            display: flex;
            gap: 20px;
            margin-bottom: 8px;
            font-size: 20px;
        }

        .play-btn {
            font-size: 30px;
            color: white;
            border: 2px solid white;
            border-radius: 50%;
            padding: 6px;
        }

        .progress {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: #ccc;
            width: 100%;
            max-width: 500px;
        }

        .progress-bar {
            flex: 1;
            height: 4px;
            border-radius: 5px;
            background: #ccc;
            outline: none;
            cursor: pointer;
        }

        .player-right {
            flex: 1;
            justify-content: flex-end;
            gap: 14px;
            min-width: 220px;
        }

        .player-right .tag {
            border: 1px solid #666;
            padding: 2px 6px;
            font-size: 10px;
            border-radius: 4px;
            color: #aaa;
        }

        .volume-bar {
            width: 80px;
            height: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="layout">
        <div class="sidebar">
            <!-- <img src="./../admin/1/img/php.png" alt="logo" class="logo"> -->
            <h2>Quản lý</h2>
            <ul class="menu">
                <li>
                    <a href="index.php?controller=admin&action=index" class="menu-link">
                         <i class="ri-bar-chart-fill"></i>Danh Sách Người Dùng
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=admin&action=getAllSinhVien" class="menu-link">
                        <i class="ri-bar-chart-fill"></i> Danh Sách Sinh Viên
                    </a>
                </li>
                
                 <li> 
                    <a href="index.php?controller=admin&action=getAllGiangVien" class="menu-link">
                        <i class="ri-bar-chart-fill"></i> Danh Sách Giảng Viên
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=admin&action=the_loai" class="menu-link">
                        <i class="ri-bar-chart-fill"></i> Danh Sách Khoa
                    </a>
                </li> 
                <li>
                    <a href="index.php?controller=auth&action=logout" class="menu-link">
                        🚪 Đăng Xuất
                    </a>
                </li>
            </ul>

        </div>
        <div class="main-content">
            <?php echo  $content ?? '' ?>
        </div>

    </div>
</body>

</html>