<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>Sanshin</h3>
            <p>Hệ thống quản lý đơn</p>
        </div>
        <div class="main">
            <div class="sidebar">
                <div class="sidebar_item active">
                    <a href="<?php echo BASE_URL; ?>/public/index.php?url=dashboard/dashboard">Dashboard</a>
                </div>
                <div class="sidebar_item">
                    <a href="<?php echo BASE_URL; ?>/public/index.php?url=users">Quản lý người dùng</a>
                </div>
                <div class="sidebar_item">
                    <a href="<?php echo BASE_URL; ?>/public/index.php?url=letters">Quản lý đơn</a>
                </div>
                <div class="sidebar_item">
                    <a href="<?php echo BASE_URL; ?>/public/index.php?url=auth/logout">Đăng xuất</a>
                </div>
            </div>
           
    